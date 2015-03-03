<?php

    /**
     * @author Jessy James
     */

    require_once 'resources/Resource.interface.php';
    require_once 'dao/DAOFactory.class.php';
    require_once 'models/FieldValidator.class.php';
    require_once 'models/OrgDataField.class.php';
    require_once 'exceptions/MissingParametersException.class.php';
    require_once 'exceptions/MalformedRequestDataException.class.php';
    require_once 'exceptions/UnsupportedResourceMethodException.class.php';
    require_once 'exceptions/MySqlDbException.class.php';
    require_once 'exceptions/DuplicateEntityException.class.php';
    require_once 'exceptions/org-data-fields/OrgDataFieldNotFoundException.class.php';
    require_once 'exceptions/org-data-fields/OrganizationNotFoundException.class.php';
    require_once 'exceptions/org-data-fields/ChannelNotFoundException.class.php';
    require_once 'exceptions/org-data-fields/DataFieldNotFoundException.class.php';
    require_once 'exceptions/org-data-fields/ValidatorNotFoundException.class.php';
    //require_once 'resources/IntouchCustomfieldsResource.class.php';   

    class OrganizationChannelFieldResource implements Resource {

        private $orgDataFieldDAO;

        private $orgDataFields;
        
        /* The setOrganization() sets the value below */
        private $organization;
        /* The setChannel() sets the value below */
        private $channel;
        /* The setDataField() sets the value below */
        private $dataField;
        /* The setValidator() sets the values below */
        private $validatorIds = array();
        private $validatorNames = array();
        private $validators;
        /* The setOrgDataFieldObj() sets the values below */
        private $orgDataFieldObj;

        public function __construct () {
            $DAOFactory = new DAOFactory();

            $this -> orgDataFieldDAO = $DAOFactory -> getOrgDataFieldsDAO();
        }
        
        public function checkIfRequestMethodValid ($requestMethod) {
            return in_array($requestMethod, array ('get', 'put', 'post', 'delete'));
        }

        public function delete ($resourceVals, $data) {
            global $logger, $warnings_payload; 
            
            $orgId = $resourceVals ['organizations'];
            $channelName = $resourceVals ['channels'];
            $name = $resourceVals ['fields'];

            if (! isset($name)) {
                $warnings_payload [] = 'DELETE call to /fields ' . 
                            'must be succeeded by /<field_name> ' . 
                            'i.e. DELETE /organizations/<org_id>/channels/<channel_name>/fields'; 
                throw new UnsupportedResourceMethodException();
            }

            /* To check if the orgId exists, load org from organizations relation */
            $this -> setOrganization($orgId);
            /* To check if the channel exists, load channel from channels relation */
            $this -> setChannel($channelName);
            /* To check if the org_data_field exists, load field from org_data_fields relation */
            $this -> setOrgDataFieldObj($name);

            if(! $this -> orgDataFieldObj) 
                throw new OrgDataFieldNotFoundException('name', $name);
            
            $areOdfAndValidatorsDeleted = $this -> orgDataFieldDAO -> delete($this -> orgDataFieldObj);
            $logger -> debug ("Are OrgDataField + Validators Deleted? " . $areOdfAndValidatorsDeleted);

            if ($areOdfAndValidatorsDeleted) 
                $result = array('code' => '6203');
            else 
                $result = array('code' => '6213');

            return $result;
        }

        public function put ($resourceVals, $data) {
            global $logger, $warnings_payload;
            $listOfNewValidators = $listOfNewValidatorIds = null;
            
            $odfName = $resourceVals ['fields'];
            if (! isset($odfName)) {
                $warnings_payload [] = 'PUT call to /fields must be succeeded ' . 
                                        'must be succeeded by /<field_name> ' . 
                            'i.e. PUT /organizations/<org_id>/channels/<channel_name>/fields'; 
                throw new UnsupportedResourceMethodException();
            }
            if (! isset($data))
                throw new MissingParametersException('No fields specified for updation');

            $orgId = $resourceVals ['organizations'];
            $channelName = $resourceVals ['channels'];            

            /* To check if the orgId exists, load org from organizations relation */
            $this -> setOrganization($orgId);
            /* To check if the channel exists, load channel from channels relation */
            $this -> setChannel($channelName);
            /* To check if the org_data_field exists, load field from org_data_fields relation */
            $this -> setOrgDataFieldObj($odfName);

            /* Sanitize the resource vals as well as the payload data */
            $this -> updateOrgDataFieldObj($data);

            //TO-DO: Change the result to contain true or false instead of id
            $result = $this -> orgDataFieldDAO -> update($this -> orgDataFieldObj);
            $logger -> debug('Updated entry? ' . $result);
            $logger -> debug('Updated OrgDataField: ' . $this -> orgDataFieldObj -> toString());

            $orgDataField = $this -> orgDataFieldObj -> toArray();

            /* Set into '$this -> orgDataFields' */
            /*$this -> setIntoOrgDataFields ($orgDataField);*/
            $this -> orgDataFields [] = $orgDataField;
            
            return array('code' => '6202', 
                            'data' => array(
                                'data-fields' => $this -> orgDataFields
                            )
            );
        }

        public function post ($resourceVals, $data) {
            global $logger, $warnings_payload;

            /* Sanitize the resource vals as well as the payload data */
            $this -> sanitizeResourceVals($resourceVals);
            $data = $this -> sanitizePayload($data);

            $orgId = $resourceVals ['organizations'];
            $channelName = $resourceVals ['channels'];
            $dataFieldName = $data ['data_field'];

            try {
                /* To check if the orgId exists, load org from organizations relation */
                $this -> setOrganization($orgId);
                /* To check if the channel exists, load channel from channels relation */
                $this -> setChannel($channelName);

                $this -> dataField = null;
                if (isset($dataFieldName)) {
                    /* To check if the data-field exists, load dataField from data_fields relation */
                    $this -> setDataField('name', $dataFieldName);
                }
                /* To check if the validators exist, load validators details from 
                field_validators relation and gather validator IDs to store */
                $this -> setValidators('name', $data ['validators']);

                /* Create object */
                $typed = (int) $data ['typed'];

                $orgDataFieldObj = new OrgDataField($data ['name'], $this -> organization, 
                                                     $this -> channel, $typed, 
                                                     $this -> dataField, $data ['required'], 
                                                     $data ['priority'], date('Y-m-d H:i:s'), 
                                                     date('Y-m-d H:i:s'), $this -> validators);
                $logger -> debug ("POSTed OrgDataField: " . $orgDataFieldObj -> toString()); 

                /* Insert into db */
                $result = $this -> orgDataFieldDAO -> create($orgDataFieldObj);
                $logger -> debug ("Inserted ID: " . $result);
                
                $orgDataField = $orgDataFieldObj -> toArray();
            } catch (MySqlDbException $e) {
                $odfName = $data ['name'];
                $mySqlErrNo = $e -> getErrNo();

                if ($mySqlErrNo == 1062) 
                    throw new DuplicateEntityException("Field with name '$odfName' exists", $e);
                else 
                    throw $e;
            } catch (Exception $e) {
                    throw $e;
            }

            /* Set into '$this -> orgDataFields' */
            /*$this -> setIntoOrgDataFields ($orgDataField);*/
            $this -> orgDataFields [] = $orgDataField;
            
            return array('code' => '6201', 
                            'data' => array(
                                'data-fields' => $this -> orgDataFields
                            )
            );
        }

        public function get ($resourceVals, $data) {

            $orgId = $resourceVals ['organizations'];
            $channelName = $resourceVals ['channels'];
            $name = $resourceVals ['fields'];

            /* To check if the orgId exists, load org from organizations relation */
            $this -> setOrganization($orgId);
            /* To check if the channel exists, load channel from channels relation */
            $this -> setChannel($channelName);

            if (isset ($name)) 
                $result = $this -> getOrgDataFieldDetails($name);
            else {
                /*if ($channelName == "intouch"){
                    $intouchCustomfieldsResource = new IntouchCustomfieldsResource();
                    $result = $intouchCustomfieldsResource->getListOfAllIntouchCustomfields($orgId);
                }
                else*/
                $result = $this -> getListOfAllOrgDataFields();
            }

            return $result;
        }

        private function getListOfAllOrgDataFields() {
            global $logger;

            $logger -> debug ("Fetch details of all OrgDataFields");
            $listOfOrgDataFieldObjs = $this -> orgDataFieldDAO -> readAll($this -> organization -> getOrgId(), 
                                                                            $this -> channel -> getId());

            if (empty ($listOfOrgDataFieldObjs)) 
                throw new OrgDataFieldNotFoundException();

            foreach ($listOfOrgDataFieldObjs as $orgDataFieldObj) {
                $orgDataField = $orgDataFieldObj -> toArray();

                /* Set into '$this -> orgDataFields' */
                /*$this -> setIntoOrgDataFields ($orgDataField, 'name');*/
                $this -> orgDataFields [] = $orgDataField;

            }

            return array('code' => '6200', 
                            'data' => array(
                                'fields' => $this -> orgDataFields
                            )
            );
        }

        private function getOrgDataFieldDetails($name) {
            global $logger; 

            /* To check if the org_data_field exists, load field from org_data_fields relation */
            $this -> setOrgDataFieldObj($name);

            if(! $this -> orgDataFieldObj) 
                throw new OrgDataFieldNotFoundException();

            /* Set into '$this -> orgDataFields' */
            $orgDataField = $this -> orgDataFieldObj -> toArray();
            /*$this -> setIntoOrgDataFields ($orgDataField, 'name');*/
            $this -> orgDataFields [] = $orgDataField;

            return array('code' => '6200', 
                            'data' => array(
                                'fields' => $this -> orgDataFields
                            )
            );
        }

        private function setOrganization($orgId) {
            global $logger;

            $logger -> debug ('CHECK - Fetch ORG Details with org_id: ' . $orgId);
            $organizationObj = ResourceUtil :: loadOrganization($orgId);

            if (! isset($organizationObj)) {
                $logger -> debug ('CHECK - Fetched ORG: ' . $organizationObj);
                throw new OrganizationNotFoundException($orgId);
            }
            $logger -> debug ('CHECK - Fetched ORG: ' . $organizationObj -> toString());
            
            /*$organization = $organizationObj -> toArray();*/

            $this -> organization = $organizationObj;
        }

        private function setChannel($channelName) {
            global $logger;

            $logger -> debug ('CHECK - Fetch Channel Details with channel_name: ' . $channelName);
            $channelObj = ResourceUtil :: loadChannel('name', $channelName);

            if(! isset($channelObj)) {
                $logger -> debug ('CHECK - Fetched Channel: ' . $channelObj);
                throw new ChannelNotFoundException('name', $channelName);
            }
            $logger -> debug ('CHECK - Fetched Channel: ' . $channelObj -> toString());
            
            /*$channel = $channelObj -> toArray();*/

            $this -> channel = $channelObj;
        }

        private function setDataField ($by, $value) {
            global $logger;

            $logger -> debug ("CHECK - Fetch DataField Details with '$by': '$value'");

            $dataFieldObj = ResourceUtil :: loadDataField($by, $value);

            if(! isset($dataFieldObj)) {
                $logger -> debug('CHECK - Fetched DataFieldObj: ' . $dataFieldObj);
                throw new DataFieldNotFoundException($by, $value);
            }
            $logger -> debug('CHECK - Fetched DataFieldObj: ' . $dataFieldObj -> toString());
            
            /*$dataField = $dataFieldObj -> toArray();*/
            /* Unsetting validators since org_data_field_validators contain 
            appropriate data_field_validators + org_data_field_validators */
            /*unset ($dataField ['validators']); */

            $this -> dataField = $dataFieldObj;
        }

        private function setValidators($by, $validatorValues) {
            global $logger;

            if (empty($validatorValues)) {
                return;
            }
            $logger -> debug('CHECK - Load Validators Details From: ' . 
                                                json_encode($validatorValues));
            
            /*$this -> validatorIds = $this -> validatorNames = array();*/
            foreach ($validatorValues as $key => $validatorVal) {
                $validatorName = trim($validatorVal);

                $logger -> debug("Load by '$by' : '$validatorVal'");
                $validatorObj = ResourceUtil :: loadValidator($by, $validatorVal);
                
                if(! $validatorObj) {
                    $logger -> debug('Validator Loaded: ' . $validatorObj);
                    throw new ValidatorNotFoundException($by, $validatorVal);
                }
                $logger -> debug('Validator Loaded: ' . $validatorObj -> toString());
                $validatorId = $validatorObj -> getId();
                /*$validatorName = $validatorObj -> getValidatorName();*/
                $logger -> debug('Validator ID: ' . $validatorId);

                $this -> validators [] = $validatorObj;
                /*$this -> validatorIds [] = $validatorId;
                $this -> validatorNames [] = $validatorName;*/
            }
        }

        private function setOrgDataFieldObj($name) {
            global $logger;

            $logger -> debug ("CHECK - load OrgDataField with org_data_field_name: $name");
            $this -> orgDataFieldObj = $this -> orgDataFieldDAO -> read($this -> organization -> getOrgId(), 
                                                                        $this -> channel -> getId(), 
                                                                        $name, 'name');

            if (! isset ($this -> orgDataFieldObj)) {
                $logger -> debug('CHECK - Loaded DataFieldObj: ' . $this -> orgDataFieldObj);
                throw new OrgDataFieldNotFoundException('name', $name);
            }
            $logger -> debug('CHECK - Loaded DataFieldObj: ' . $this -> orgDataFieldObj -> toString());
        }

        private function setIntoOrgDataFields ($odfArray, $by = 'id') {  

            /* Load dataField from data_fields relation for it's name */
            /*$this -> setDataField('id', $odfArray ['data_field']);*/
            /* Load validators details from field_validators relation and 
            gather validator names */
            /*$this -> setValidators($by, $odfArray ['validators']);*/

            /* Transform for appropriate response */
            $odfArray = $this -> transformOdfKeys($odfArray);
            
            $this -> orgDataFields [] = $odfArray;
        }

        private function transformOdfKeys ($odf) {  
            global $logger; 

            $odf ['org'] = $this -> organization ['name'];
            $odf ['channel'] = $this -> channel ['name'];
            $odf ['data_field'] = $this -> dataField ['name'];
            $odf ['validators'] = $this -> validatorNames;
            $logger -> debug('Transformed OrgDataField: ' . json_encode($odf));

            return $odf;
        }

        private function updateOrgDataFieldObj ($data) {

            /*Replace dataFieldObj Values With Payload Values*/
            if (isset($data ['name'])) 
                throw new MalformedRequestDataException(
                    "Field's 'name' parameter cannot be updated");

            $newTyped = $data ['typed'];
            $newDataField = $data['data_field'];
            $newIsRequired = $data ['required'];
            $newPriority = $data ['priority'];
            $newValidators = $data['validators'];

            if (isset($newTyped)) {

                if (! is_bool($newTyped)) 
                    throw new MalformedRequestDataException(
                        "Field's 'typed' parameter must be a boolean value");
                
                if ($newTyped != $this -> orgDataFieldObj  -> getTyped())
                    $this -> orgDataFieldObj -> setTyped((int) $newTyped);

                if (! $newTyped) {
                    $newDataField = null;
                    $this -> orgDataFieldObj -> unsetDataField();
                }
            }

            if (isset($newDataField)) {
                
                if (! ctype_alnum(str_replace(array('_', '.'), '', $newDataField))) 
                    throw new MissingParametersException(
                    "Field's 'data_field' parameter must be an alphanumeric value with the exception of '_' and '.' symbols");

                /* To check if the data-field exists, load dataField from data_fields relation */
                $this -> setDataField('name', $newDataField);
                
                $existingDataFieldId = -1;
                if (is_object ($this -> orgDataFieldObj  -> getDataField())) 
                    $existingDataFieldId = $this -> orgDataFieldObj  -> getDataField() -> getId();

                if ($this -> dataField != $existingDataFieldId)
                    $this -> orgDataFieldObj -> setDataField($this -> dataField);
            }

            if (isset($newIsRequired)) {

                if (! is_bool($newIsRequired)) 
                    throw new MalformedRequestDataException(
                        "Field's 'required' parameter must be a boolean value");
                
                if ($newIsRequired != $this -> orgDataFieldObj  -> getIsRequired())
                    $this -> orgDataFieldObj -> setIsRequired((int) $newIsRequired);
            }

            if (isset($newPriority)) {
                
                if (! intval($newPriority))
                    throw new MalformedRequestDataException(
                    "Field's 'priority' parameter must be an integer value");
                
                if ($newPriority != $this -> orgDataFieldObj  -> getPriority())
                    $this -> orgDataFieldObj -> setPriority($newPriority);
            }

            if (isset ($newValidators)) { 
                if (! is_array ($data ['validators'])) 
                    throw new MalformedRequestDataException(
                        "Field's 'validators' parameter must be an array of validator-names");

                /* To check if the validators exist, load validators details from 
                field_validators relation and gather validator IDs to store */
                $this -> setValidators('name', $newValidators);
                $this -> orgDataFieldObj -> setValidators($this -> validators);
            }

            $this -> orgDataFieldObj -> setLastUpdate(date('Y-m-d H:i:s'));
        }

        private function sanitizeResourceVals ($resourceVals) {

            $orgDataFieldName = $resourceVals ['fields'];
            if (isset($orgDataFieldName)) {
                $warnings_payload [] = 'POST call to /fields must not have /<field-name> appended ' . 
                                'i.e. POST /organizations/<org_id>/channels/<channel_name>/fields';
                throw new UnsupportedResourceMethodException();
            }

            $orgId = $resourceVals ['organizations'];
            if (! ctype_digit($orgId) || $orgId < 0)
                throw new MalformedRequestDataException(
                    "/organizations/<org_id> '$orgId' must be an integer value");

            $channelName = $resourceVals ['channels'];
            if (! ctype_alpha($channelName)) 
                throw new MalformedRequestDataException(
                    "/organizations/<org_id>/channels/<channel_name> '$channelName' must be only alphabetic");
        }

        private function sanitizePayload ($data) {
            /* Payload data format: 
                array(
                    "name" => "dob", 
                    "typed" => true, 
                    "data-field" => "birthday", 
                    "required" => true
                    "priority" => 5, 
                    "validators" => ["alphabetic", "is-boolean"] 
                )
            */

            if (empty($data ['name'])) 
                throw new MalformedRequestDataException(
                    "Field's 'name' parameter cannot be empty");

            if (! ctype_alnum(str_replace(array('_', '.'), '', $data ['name']))) 
                throw new MalformedRequestDataException(
                    "Field's 'name' parameter must be an alphanumeric value with the exception of '_' and '.' symbols");

            if (! isset($data ['typed'])) 
                throw new MissingParametersException(
                    "Field's 'typed' parameter is missing");

            if (empty($data ['typed'])) 
                $data ['typed'] = false; // json_decode turns boolean false to blank

            if (! is_bool($data ['typed'])) 
                throw new MalformedRequestDataException(
                    "Field's 'typed' parameter must be a boolean value");

            if ($data ['typed']) { 
                if (! isset($data ['data_field'])) 
                    throw new MissingParametersException(
                        "Field is typed but 'data_field' parameter is missing");

                if (count (explode (' ', $data ['data_field'])) > 1) 
                    throw new MalformedRequestDataException(
                        "Field's 'data_field' parameter cannot contain whitespace");

                if (! ctype_alnum(str_replace(array('_', '.'), '', $data ['data_field']))) 
                    throw new MissingParametersException(
                        "Field's 'data_field' parameter must be an alphanumeric value with the exception of '_' and '.' symbols");            
            } else {
                unset ($data ['data_field']);
            }

            if (empty($data ['required'])) 
                $data ['required'] = false; // json_decode turns boolean false to blank

            if (! is_bool($data ['required'])) 
                throw new MalformedRequestDataException(
                    "Field's 'required' parameter must be a boolean value");

            if (! isset($data ['priority'])) 
                throw new MissingParametersException(
                    "Field's 'priority' parameter is missing");

            $priority = intval($data ['priority']);
            if (! $priority) 
                throw new MalformedRequestDataException(
                    "Field's 'priority' parameter must be an integer value");

            if (! isset ($data ['validators'])) 
                throw new MissingParametersException(
                    "Field's 'validators' parameter is missing");

            if (! is_array ($data ['validators'])) 
                throw new MalformedRequestDataException(
                    "Field's 'validators' parameter must be an array of validator-names");

            return $data;
        }
    }