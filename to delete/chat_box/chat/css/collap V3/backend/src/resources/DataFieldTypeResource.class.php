<?php

/**
 * @author Jessy James
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/DataFieldsType.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/MalformedRequestDataException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class DataFieldTypeResource implements Resource
{
    
    private $dataFieldTypeDAO;
    private $dataFieldTypes;
    
    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> dataFieldTypeDAO = $DAOFactory -> getDataFieldsTypeDAO();
    }
    
    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'post', 'delete'));
    }
    
    public function delete($resourceVals, $data) {
        global $logger, $warnings_payload;
        $dataFieldType = $resourceVals['data-field-types'];
        
        if (!isset($dataFieldType)) {
            $warnings_payload[] = 'DELETE call to /data-field-types must be succeeded ' . 
                                    'by /type i.e. DELETE /data-field-types/type';
            throw new UnsupportedResourceMethodException();
        }
        
        $logger -> debug("Delete DataFieldType with name: " . $dataFieldType);
        $result = $this -> dataFieldTypeDAO -> delete($dataFieldType);
        $logger -> debug("DataFieldType Deleted? " . $result);
        
        if ($result) $result = array('code' => '4003');
        else $result = array('code' => '4004');
        
        return $result;
    }

    
    /* No updating since there is only one field; To update, delete and then post again */
    public function put($resourceVals, $data) {}

    
    public function post($resourceVals, $data) {
        global $logger, $warnings_payload;
        
        $dataFieldTypeName = $resourceVals['data-field-types'];
        if (isset($dataFieldTypeName)) {
            $warnings_payload[] = 'POST call to /data-field-types must not have ' . 
                                    '/type appended i.e. POST /data-field-types';
            throw new UnsupportedResourceMethodException();
        }
        
        $this -> sanitize($data);
        
        $dataFieldType = new DataFieldsType($data['type']);
        $logger -> debug("POSTed DataFieldType: " . json_encode($dataFieldType));
        
        $result = $this -> dataFieldTypeDAO -> create($dataFieldType);
        $logger -> debug("Inserted Entry: " . $result);
        
        $this -> dataFieldTypes[] = $dataFieldType -> toArray();
        
        return array('code' => '4001', 'data' => $this -> dataFieldTypes);
    }
    
    public function get($resourceVals, $data) {
        $type = $resourceVals['data-field-types'];
        
        if (isset($type)) $this -> getDataFieldTypeDetails($type);
        else $this -> getListOfAllDataFieldTypes();
        
        if (!is_array($this -> dataFieldTypes)) {
            return array('code' => '4004');
        }
        return array('code' => '4000', 'data' => $this -> dataFieldTypes);
    }
    
    private function getListOfAllDataFieldTypes() {
        global $logger;
        $logger -> debug('Fetch list of DataFieldTypes with their details...');
        
        $dataFieldTypes = $this -> dataFieldTypeDAO -> readAll();
        foreach ($dataFieldTypes as $dataFieldType) {
            $this -> dataFieldTypes[] = $dataFieldType -> toArray();
        }
        $logger -> debug('Fetched list of DataFieldTypes: ' . json_encode($this -> dataFieldTypes));
    }
    
    private function getDataFieldTypeDetails($type) {
        global $logger;
        $logger -> debug('Fetch DataFieldType Details with channel_name: ' . $type);
        $dataFieldType = $this -> dataFieldTypeDAO -> read('name', $type);
        
        if (!is_object($dataFieldType)) {
            return;
        }
        
        $this -> dataFieldTypes[] = $dataFieldType -> toArray();
        $logger -> debug('Fetched DataFieldType: ' . json_encode($this -> dataFieldTypes));
    }
    
    private function sanitize($data) {
        if (!isset($data['type'])) throw new MissingParametersException("'type' field is missing");
        
        if (empty($data['type'])) throw new MissingParametersException("'type' field cannot be empty");
        
        if (!ctype_alpha($data['type'])) throw new MalformedRequestDataException("'type' field must be an alphabetic value");
    }
}
