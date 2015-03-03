<?php

/**
 * @author Jessy James
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/FieldValidator.class.php';
require_once 'models/DataField.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/MalformedRequestDataException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';
require_once 'exceptions/data-fields/DataFieldTypeNotFoundException.class.php';
require_once 'exceptions/data-fields/DataFieldNotFoundException.class.php';
require_once 'exceptions/data-fields/ValidatorNotFoundException.class.php';
require_once 'exceptions/data-fields/DataFieldTiedToOtherEntitiesException.class.php';

class DataFieldResource implements Resource
{
    
    private $dataFieldDAO;
    private $dataFieldTypeDAO;
    private $validatorDAO;
    private $orgDataFieldDAO;
    private $dataFields;
    
    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> dataFieldDAO = $DAOFactory -> getDataFieldsDAO();
        $this -> dataFieldTypeDAO = $DAOFactory -> getDataFieldsTypeDAO();
        $this -> validatorDAO = $DAOFactory -> getFieldValidatorsDAO();
        $this -> orgDataFieldDAO = $DAOFactory -> getOrgDataFieldsDAO();
    }
    
    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete'));
    }
    
    public function delete($resourceVals, $data) {
        global $logger, $warnings_payload;
        $dataFieldName = $resourceVals['data-fields'];
        
        if (!isset($dataFieldName)) {
            $warnings_payload[] = 'DELETE call to /data-fields must be succeeded ' . 
                                    'by /data-field-name i.e. DELETE /data-fields/data-field-name';
            throw new UnsupportedResourceMethodException();
        }
        
        $logger -> debug('Load DataFields Details of data_field_name to be deleted: ' . $dataFieldName);
        $dataFieldObj = $this -> dataFieldDAO -> read('name', $dataFieldName);
        if (! $dataFieldObj) {
            return array('code' => '5004');
        }
        
        if (! $dataFieldObj) 
            throw new DataFieldNotFoundException('name', $dataFieldName);
        $logger -> debug('DataField Loaded: ' . $dataFieldObj -> toString());
        $dataFieldId = $dataFieldObj -> getId();

        $orgDataFieldsTiedToIt = $this -> orgDataFieldDAO -> 
                                    queryByOrgIdOrderByDataFieldId($dataFieldId);
        $logger -> debug('CHECK - Are Other Entities Tied to the DataField Loaded: ' . $orgDataFieldsTiedToIt);
        if (! empty($orgDataFieldsTiedToIt)) 
            throw new DataFieldTiedToOtherEntitiesException('name', $dataFieldName, "Org-data-fields", 'deletion');

        $deleted = $this -> softDelete($dataFieldObj);
        //$deleted = $this -> physicalDelete($dataFieldName);
        
        $result = array();
        if ($deleted) {
            $result = array('code' => '5003');
        } else {
            $result = array('code' => '5013');
        }   
        
        return $result;
    }

    public function softDelete($dataFieldObj) {
        global $logger;

        $logger -> debug('CHECK - Soft Deleting: ' . $dataFieldObj -> getName());
        $dataFieldObj -> setIsActive(false);
        $dataFieldObj -> setLastUpdate(date('Y-m-d H:i:s'));

        //TO-DO: Change the result to contain true or false instead of id
        $result = $this -> dataFieldDAO -> update($dataFieldObj);
        $logger -> debug('SoftDeleted DataField object: ' . $dataFieldObj -> toString());

        return $result;
    }

    public function physicalDelete($dataFieldName) {

        $isDataFieldDeleted = $areValidatorsDeleted = false;

        //Start an InnoDB transaction
        $transaction = new Transaction();
        
        $isDataFieldDeleted = $this -> dataFieldDAO -> delete($dataFieldId);
        $logger -> debug("DataField Deleted? " . $isDataFieldDeleted);
        
        if ($isDataFieldDeleted) $areValidatorsDeleted = $this -> dataFieldDAO -> deleteAllValidator($dataFieldId);
        $logger -> debug("Are Validators Deleted? " . $areValidatorsDeleted);
        
        if ($areValidatorsDeleted) {
            //Commit the transaction
            $transaction -> commit();
        } else {
            //Rollback the transaction
            $transaction -> rollback();
        }

        return $areValidatorsDeleted;
    }
    
    public function put($resourceVals, $data) {
        global $logger, $warnings_payload;
        $listOfNewValidators = $listOfNewValidatorIds = null;
        
        $dataFieldName = $resourceVals['data-fields'];
        if (!isset($dataFieldName)) {
            $warnings_payload[] = 'PUT call to /data-fields must be succeeded ' . 
                                    'by /data_field_name i.e. PUT /data-fields/data_field_name';
            throw new UnsupportedResourceMethodException();
        }
        if (!isset($data)) throw new MissingParametersException('No fields specified for updation');
        
        $logger -> debug('Load DataFields Details of data_field_name passed: ' . $dataFieldName);
        $dataFieldObj = $this -> dataFieldDAO -> read('name', $dataFieldName);
        $logger -> debug('DataField Loaded: ' . print_r($dataFieldObj, true));
        
        if (!$dataFieldObj) throw new DataFieldNotFoundException('name', $dataFieldName);

        $orgDataFieldsTiedToIt = $this -> orgDataFieldDAO -> 
                                    queryByOrgIdOrderByDataFieldId($dataFieldObj -> getId());
        if (! empty($orgDataFieldsTiedToIt)) 
            throw new DataFieldTiedToOtherEntitiesException('name', $dataFieldName, 'Org-data-fields', 'updation');
        
        /* Replace dataFieldObj Values With Payload Values */
        $newName = $data['name'];
        $newIsArray = $data['is_array'];
        $newBaseType = $data['base_type'];
        $newComplexType = $data['complex_type'];
        $newParentType = $data['parent_type'];
        $newDefaultValue = $data['default_value'];
        $newIsActive = $data['is_active'];
        $newAddedOn = $data['added_on'];
        $newLastUpdate = $data['last_update'];
        $newDescription = $data['description'];
        $newValidators = $data['validators'];
        
        if (isset($newName)) {
            throw new MalformedRequestDataException("DataField's 'name' cannot be updated");
        }
        if (isset($newIsActive)) {
            throw new MalformedRequestDataException("DataField's 'is_active' cannot be updated");
        }
        if (isset($newAddedOn)) {
            throw new MalformedRequestDataException("DataField's 'added_on' cannot be updated");
        }
        if (isset($lastUpdate)) {
            throw new MalformedRequestDataException("DataField's 'last_update' cannot be updated");
        }
        
            
        if (isset($newIsArray)) {
            if (! is_bool($newIsArray)) 
                throw new MalformedRequestDataException("Data-field's 'is_array' field must be a boolean value");
        
            if ($newIsArray != $dataFieldObj -> getIsArray()) 
                $dataFieldObj -> setIsArray($newIsArray);
        }

        if (isset($newBaseType) && isset($newComplexType)) {
            
            throw new MissingParametersException(
                "Either the data-field's 'base_type' or 'complex_type' field must be specified; " . 
                "Both may not be specified together");
        } else if (isset($newBaseType)) {
            
            if (empty($newBaseType)) 
                throw new MalformedRequestDataException("Data-field's 'base_type' field cannot be empty");
            
            if (!ctype_alpha($newBaseType)) 
                throw new MalformedRequestDataException(
                    "Data-field's 'base_type' field must be an alphabetic value");
            
            if ($newBaseType == 'complex' && (isset($newParentType))) {
                throw new MissingParametersException(
                    "Data-field's 'parent_type' field must not be specified " . 
                    "when the base_type is 'complex'");
            }
            if ($newBaseType == 'complex' && isset($newDefaultValue)) {
                throw new MalformedRequestDataException(
                    "Data-field's 'default_value' field must not be specified " . 
                    "when the base_type is 'complex'");
            } else if ($newBaseType != 'complex' && (!isset($newDefaultValue))) {
                throw new MissingParametersException("Data-field's 'default_value' field is missing");
            }
            if ($newBaseType == 'complex' && isset($newValidators)) {
                throw new MalformedRequestDataException(
                    "Data-field's 'validators' field must not be specified " . 
                    "when the base_type is 'complex'");
            } else if ($newBaseType != 'complex' && (!isset($newValidators))) {
                throw new MissingParametersException("Data-field's 'validators' field is missing");
            }
            
            $logger -> debug('CHECK - Load DataFieldType details with base_type: ' . $newBaseType);
            $newBaseDataFieldTypeObj = $this -> dataFieldTypeDAO -> read('name', $newBaseType);

            if (!$newBaseDataFieldTypeObj) {
                $logger -> debug('CHECK - NewBaseDataFieldTypeObj: ' . $newBaseDataFieldTypeObj);
                throw new DataFieldTypeNotFoundInDataFieldEndpointException('name', $newBaseType);
            }
            $logger -> debug('CHECK - NewBaseDataFieldTypeObj: ' . $newBaseDataFieldTypeObj -> toString());
            
            $newBaseTypeId = $newBaseDataFieldTypeObj -> getId();
            $baseTypeId = -1;
            if (is_object($dataFieldObj -> getBaseType())) 
                $baseTypeId = $dataFieldObj -> getBaseType() -> getId();
            if ($newBaseTypeId != $baseTypeId) {
                $dataFieldObj -> setBaseType($newBaseDataFieldTypeObj);
            }

            if ($newBaseDataFieldTypeObj -> getType() == 'complex') {
                $dataFieldObj -> setDefaultValue(null);
                $dataFieldObj -> setFieldValidators(array());
            }                

        } else if (isset($newComplexType)) {
            
            if (empty($newComplexType)) 
                throw new MalformedRequestDataException("Data-field's 'complex_type' field cannot be empty");
            
            if (!ctype_alpha($newComplexType)) 
                throw new MalformedRequestDataException(
                    "Data-field's 'complex_type' field must be an alphabetic value");
            
            if (isset($newParentType)) 
                throw new MalformedRequestDataException(
                    "Data-field's 'parent_type' field must not be specified " . 
                    "when the complex_type field is set");
            
            if (isset($newDefaultValue)) 
                throw new MalformedRequestDataException(
                    "Data-field's 'default_value' field must not be specified " . 
                    "when the complex_type field is set");
            
            if (isset($newValidators)) 
                throw new MalformedRequestDataException(
                    "Data-field's 'validators' field must not be specified " . 
                    "when the complex_type field is set");
            
            $logger -> debug('CHECK - Load DataField details with complex_type: ' . $newComplexType);
            $newComplexTypeDataFieldObj = $this -> dataFieldDAO -> read('name', $newComplexType);
            
            if (!$newComplexTypeDataFieldObj) {
                $logger -> debug('CHECK - NewComplexTypeDataFieldObj: ' . $newComplexTypeDataFieldObj);
                throw new DataFieldTypeNotFoundInDataFieldEndpointException('name', $newComplexType);
            }
            $logger -> debug('CHECK - NewComplexTypeDataFieldObj: ' . $newComplexTypeDataFieldObj -> toString());
            
            $newComplexTypeId = $newComplexTypeDataFieldObj -> getId();
            $complexTypeId = -1;
            if (is_object($dataFieldObj -> getComplexType())) 
                $complexTypeId = $dataFieldObj -> getComplexType() -> getId();
            if ($newComplexTypeId != $complexTypeId) {
                $dataFieldObj -> setComplexType($newComplexTypeDataFieldObj);
            }
        } 
        
        if (isset($newParentType)) {
            if (!ctype_alnum(str_replace(array('_', '.'), '', $newParentType))) 
                throw new MissingParametersException(
                    "Data-field's 'parent_type' field must be an alphanumeric value with the exception of '_' and '.'");
        
            $logger -> debug('CHECK - Load DataField details with parent_type: ' . $newParentType);
            $newParentTypeDataFieldObj = $this -> dataFieldDAO -> read('name', $newParentType);
            
            if (!$newParentTypeDataFieldObj) {
                $logger -> debug('CHECK - NewParentTypeDataFieldObj: ' . $newParentTypeDataFieldObj);
                throw new DataFieldTypeNotFoundInDataFieldEndpointException('name', $newParentType, true);
            }
            $logger -> debug('CHECK - NewParentTypeDataFieldObj: ' . $newParentTypeDataFieldObj -> toString());
            
            $newParentTypeId = $newParentTypeDataFieldObj -> getId();
            $parentTypeId = -1;
            if (is_object($dataFieldObj -> getParentType())) 
                $parentTypeId = $dataFieldObj -> getParentTypeId();
            if ($newParentTypeId != $parentTypeId) {
                $dataFieldObj -> setParentType($newParentTypeDataFieldObj);
            }
        }

        if (isset($newDefaultValue)) {
            if ($newDefaultValue != $dataFieldObj -> getDefaultValue()) 
                $dataFieldObj -> setDefaultValue($newDefaultValue);
        }

        if (isset($newDescription)) {
            if ($newDescription != $dataFieldObj -> getDescription()) 
                $dataFieldObj -> setDescription($newDescription);
        }
        
        if (isset($newValidators)) {
            
            /* To check if they exist load validators details from field_validators relation
             and gather validator IDs to store */
            $logger -> debug('To Check If They Exist Load Validators Details: ' . json_encode($newValidators));
            $listOfNewValidators = array();
            foreach ($newValidators as $key => $validatorName) {
                $validatorName = trim($validatorName);
                $logger -> debug('CHECK - Load validator with validator_name: ' . $validatorName);
                $validatorObj = $this -> validatorDAO -> read('name', $validatorName);
                
                if (!$validatorObj) {
                    $logger -> debug('CHECK - Validator Loaded: ' . $validatorObj);
                    throw new ValidatorNotFoundInDataFieldEndpointException('name', $validatorName);
                }
                $logger -> debug('CHECK - Validator Loaded: ' . $validatorObj -> toString());
                
                $listOfNewValidators[] = $validatorObj;
            }
            $dataFieldObj -> setValidators($listOfNewValidators);
        }
        $dataFieldObj -> setLastUpdate(date('Y-m-d H:i:s'));
        $logger -> debug('PUT DataField object: ' . $dataFieldObj -> toString());
        
        //TO-DO: Change the result to contain true or false instead of id
        $result = $this -> dataFieldDAO -> update($dataFieldObj);
        $logger -> debug('Updated entry? ' . $result);
        
        $dataField = $dataFieldObj -> toArray();
        
        $this -> dataFields[] = $dataField;
        
        return array('code' => '5002', 'data' => array('data-fields' => $this -> dataFields));
    }
    
    public function post($resourceVals, $data) {
        global $logger, $warnings_payload;
        
        $dataFieldName = $resourceVals['data-fields'];
        if (isset($dataFieldName)) {
            $warnings_payload[] = 'POST call to /data-fields must not have ' . 
                                    '/data-field-name appended i.e. POST /data-fields/data-field-name';
            throw new UnsupportedResourceMethodException();
        }
        
        $this -> sanitize($data);
        
        $baseDataFieldTypeObj = $complextDataFieldObj = $parentDataFieldObj = null;
        $baseTypeId = $complexTypeId = $parentTypeId = - 1;
        $isArray = trim($data['is_array']);
        $baseType = trim($data['base_type']);
        $complexType = trim($data['complex_type']);
        $parentType = trim($data['parent_type']);
        
        /* To check if the type exists, load type from data_fields_type or data_fields relation */
        if (!empty($baseType)) {
            $logger -> debug('Load DataFieldType Details With base_type: ' . $baseType);
            $baseDataFieldTypeObj = $this -> dataFieldTypeDAO -> read('name', $baseType);
            
            if (!$baseDataFieldTypeObj) {
                $logger -> debug('CHECK - DataFieldType loaded: ' . $baseDataFieldTypeObj);
                throw new DataFieldTypeNotFoundInDataFieldEndpointException('name', $baseType);
            }
        } else {
            $logger -> debug('Load DataField Details With complex_type: ' . $complexType);
            $complexDataFieldObj = $this -> dataFieldDAO -> read('name', $complexType);
            
            if (!$complexDataFieldObj) {
                $logger -> debug('CHECK - DataField loaded: ' . $complexDataFieldObj);
                throw new DataFieldNotFoundException('name', $complexType);
            }
        }
        if (!empty($parentType)) {
            $logger -> debug('Load DataField Details With parent_type: ' . $parentType);
            $parentDataFieldObj = $this -> dataFieldDAO -> read('name', $parentType);
            
            if (!$parentDataFieldObj) {
                $logger -> debug('CHECK - DataField loaded: ' . $parentDataFieldObj);
                throw new DataFieldNotFoundException('name', $parentType, true);
            }
        }
        
        /* To check if the validators exist, load validators details from field_validators relation
         and gather validator IDs to store */
        $validators = $data['validators'];
        $listOfValidatorIds = $listOfValidators = null;
        if (!empty($validators)) {
            $logger -> debug('To Check If They Exist Load Validators Details From: ' . json_encode($validators));
            foreach ($validators as $key => $validatorName) {
                $validatorName = trim($validatorName);
                $logger -> debug('validator_name: ' . $validatorName);
                $validatorObj = $this -> validatorDAO -> read('name', $validatorName);
                
                if (!$validatorObj) throw new ValidatorNotFoundInDataFieldEndpointException('name', $validatorName);
                
                $logger -> debug('Validator Loaded: ' . $validatorObj -> toString());
                $listOfValidators[] = $validatorObj;
            }
        }
        
        /* Insert into db */
        $dataFieldObj = new DataField($data['name'], $isArray, $baseDataFieldTypeObj, 
                                        $complexDataFieldObj, $parentDataFieldObj, 
                                        $data['default_value'], true, date('Y-m-d H:i:s'), 
                                        date('Y-m-d H:i:s'), $data['description'], $listOfValidators);
        $logger -> debug("POSTed DataField: " . $dataFieldObj -> toString());
        
        $result = $this -> dataFieldDAO -> create($dataFieldObj);
        $logger -> debug("Inserted Entry: " . $result);
        
        /* Transform for appropriate response */
        $dataField = $dataFieldObj -> toArray();
        
        $this -> dataFields[] = $dataField;
        
        return array('code' => '5001', 'data' => array('data-fields' => $this -> dataFields));
    }
    
    public function get($resourceVals, $data) {
        global $logger;
        $name = $resourceVals['data-fields'];
        
        if (isset($name)) $result = $this -> getDataFieldDetails($name);
        else {
            $result = $this -> getListOfAllDataFields();
        }
        
        if (!is_array($this -> dataFields)) {
            throw new DataFieldNotFoundException();
        }
        
        return $result;
    }
    
    private function getListOfAllDataFields() {
        global $logger;
        $logger -> debug('Fetch list of DataFields with their details...');
        
        $dataFieldObjs = $this -> dataFieldDAO -> readAll();
        
        if (empty($dataFieldObjs)) throw new DataFieldNotFoundException();
        
        foreach ($dataFieldObjs as $dataFieldObj) {
            $dataField = $dataFieldObj -> toArray();
            
            $this -> dataFields[] = $dataField;
        }
        
        $logger -> debug('Fetched list of DataFields: ' . json_encode($this -> dataFields));
        
        return array('code' => '5000', 'data' => array('data-fields' => $this -> dataFields));
    }
    
    private function getDataFieldDetails($name) {
        global $logger;
        
        /* Fetch from db */
        $logger -> debug("Fetch DataField Details with data_field_name: " . $name);
        $dataFieldObj = $this -> dataFieldDAO -> read('name', $name);
        
        if (!is_object($dataFieldObj)) {
            throw new DataFieldNotFoundException('name', $name);
        }
        
        /* Transform for appropriate response */
        $dataField = $dataFieldObj -> toArray();
        
        $this -> dataFields[] = $dataField;
        
        return array('code' => '5000', 'data' => array('data-fields' => $this -> dataFields));
    }
    
    private function sanitize($data) {
        global $warnings_payload;

        if (!isset($data['name'])) 
            throw new MissingParametersException("Data-field's 'name' field is missing");
        
        if (empty($data['name'])) 
            throw new MalformedRequestDataException("Data-field's 'name' field cannot be empty");
        
        if (!ctype_alnum(str_replace(array('.', '_'), '', $data['name']))) 
            throw new MalformedRequestDataException(
                "Data-field's 'name' field must be an alphanumeric value " . 
                "with the exception of '_' and '.'");
        
        if (!isset($data['is_array'])) 
            throw new MissingParametersException("Data-field's 'is_array' field is missing");
        
        if (!is_bool($data['is_array'])) 
            throw new MalformedRequestDataException("Data-field's 'is_array' field must be a boolean value");
        
        if (isset($data['base_type']) && isset($data['complex_type'])) {
            
            throw new MissingParametersException(
                "Either the data-field's 'base_type' or 'complex_type' field must be specified; " . 
                "Both may not be specified together");

        } else if (isset($data['base_type'])) {
            
            if (empty($data['base_type'])) 
                throw new MalformedRequestDataException("Data-field's 'base_type' field cannot be empty");
            
            if (!ctype_alpha($data['base_type'])) 
                throw new MalformedRequestDataException(
                    "Data-field's 'base_type' field must be an alphabetic value");
            
            /*if ($data['base_type'] == 'complex' && (isset($data['parent_type']))) {
                throw new MissingParametersException(
                    "Data-field's 'parent_type' field must not be specified " . 
                    "when the base_type is 'complex'");
            }*/
            if ($data['base_type'] == 'complex' && isset($data['default_value'])) {
                throw new MalformedRequestDataException(
                    "Data-field's 'default_value' field must not be specified " . 
                    "when the base_type is 'complex'");
            } else if ($data['base_type'] != 'complex' && (!isset($data['default_value']))) {
                throw new MissingParametersException("Data-field's 'default_value' field is missing");
            }
            if ($data['base_type'] == 'complex' && isset($data['validators'])) {
                throw new MalformedRequestDataException(
                    "Data-field's 'validators' field must not be specified " . 
                    "when the base_type is 'complex'");

            } else if ($data['base_type'] != 'complex' && (!isset($data['validators']))) {
                throw new MissingParametersException("Data-field's 'validators' field is missing");
            }
        } else if (isset($data['complex_type'])) {
            
            if (empty($data['complex_type'])) 
                throw new MalformedRequestDataException("Data-field's 'complex_type' field cannot be empty");
            
            if (!ctype_alnum(str_replace(array('.', '_'), '', $data['complex_type']))) 
                throw new MalformedRequestDataException(
                    "Data-field's 'complex_type' field must be an alphabetic value");
            
            /*if (isset($data['parent_type'])) 
                throw new MalformedRequestDataException(
                    "Data-field's 'parent_type' field must not be specified " . 
                    "when the complex_type field is set");*/
            
            if (isset($data['default_value'])) 
                throw new MalformedRequestDataException(
                    "Data-field's 'default_value' field must not be specified " . 
                    "when the complex_type field is set");
            
            if (isset($data['validators'])) 
                throw new MalformedRequestDataException(
                    "Data-field's 'validators' field must not be specified " . 
                    "when the complex_type field is set");
        } else {
            throw new MissingParametersException(
                "Either the data-field's 'base_type' or 'complex_type' field must be provided");
        }
        
        if (isset($data['parent_type']) && (!ctype_alnum(str_replace(array('.', '_'), '', $data['parent_type'])))) 
            throw new MissingParametersException("Data-field's 'parent_type' field must be an alphabetic value");
        
        if (isset($data['default_value']) && empty($data['default_value'])) 
            $warnings_payload[] = "Data-field's 'default_value' field should not be empty";
        
        if (!isset($data['description'])) 
            $warnings_payload[] = "Data-field's 'description' field is missing";
        
        if (isset($data['validators']) && !is_array($data['validators'])) 
            throw new MalformedRequestDataException(
                "Data-field's 'validators' field must be an array of validator-names");
    }
}