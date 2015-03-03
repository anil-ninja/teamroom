<?php

/**
 * @author Jessy James
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Organization.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/MalformedRequestDataException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class OrganizationResource implements Resource
{
    
    private $orgDAO;
    private $organizations;
    
    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> orgDAO = $DAOFactory -> getOrganizationDAO();
    }
    
    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }
    
    public function delete($resourceVals, $data) {
        global $logger, $warnings_payload;
        $orgId = $resourceVals['organizations'];
        
        if (!isset($orgId)) {
            $warnings_payload[] = 'DELETE call to /organizations must be succeeded ' . 
                                        'by /org_id i.e. DELETE /organizations/org_id';
            throw new UnsupportedResourceMethodException();
        }
        
        $logger -> debug('Delete ORG with org_id: ' . $orgId);
        $result = $this -> orgDAO -> delete($orgId);
        $logger -> debug('ORG Deleted? ' . $result);
        
        if ($result) $result = array('code' => '6003');
        else $result = array('code' => '6004');
        
        return $result;
    }
    
    public function options() {
    }
    
    public function put($resourceVals, $data) {
        global $logger, $warnings_payload;
        $orgId = $resourceVals['organizations'];
        
        if (!isset($orgId)) {
            $warnings_payload[] = 'PUT call to /organizations must be succeeded ' . 
                                        'by /org_id i.e. PUT /organizations/org_id';
            throw new UnsupportedResourceMethodException();
        }
        if (!isset($data)) throw new MissingParametersException('No fields specified for updation');

        $logger -> debug('CHECK - Fetch ORG Details with org_id: ' . $orgId);
        $organizationObj = $this -> orgDAO -> read($orgId);

        if (! $organizationObj) 
            return array('code' => '6004');

        $update = false;
        $newOrgId = $data ['org_id'];
        $newName = $data ['name'];

        if ($newOrgId) 
            throw new MalformedRequestDataException("Org's 'org_id' parameter cannot be updated");

        if ($newName) {
            if ($organizationObj -> getName() != $newName) {
                $update = true;
                $organizationObj -> setName($newName);
            }
        }

        if ($update) {
            $logger -> debug('PUT ORG object: ' . $organizationObj -> toString());

            $result = $this -> orgDAO -> update($organizationObj);
            $logger -> debug('Update result: ' . $result);
        }
        
        $organization = $organizationObj -> toArray();
        if (!isset($organization['id'])) return array('code' => '6004');
        $this -> organizations[] = $organization;
        
        return array('code' => '6002', 'data' => array('organizations' => $this -> organizations));
    }
    
    public function post($resourceVals, $data) {
        global $logger, $warnings_payload;
        
        $orgId = $resourceVals['organizations'];
        if (isset($orgId)) {
            $warnings_payload[] = 'POST call to /organizations must not have ' . 
                                        '/org_id appended i.e. POST /organizations';
            throw new UnsupportedResourceMethodException();
        }
        
        $this -> sanitize($data);
        
        $organizationObj = new Organization($data['org_id'], $data['name']);
        $logger -> debug('POSTed ORG: ' . $organizationObj -> toString());
        
        $result = $this -> orgDAO -> create($organizationObj);
        $logger -> debug('Inserted entry: ' . $result);

        $organization = $organizationObj -> toArray();        
        if (!isset($organization['id'])) return array('code' => '6004');
        
        $this -> organizations[] = $organization;
        return array('code' => '6001', 'data' => array('organizations' => $this -> organizations));
    }
    
    public function get($resourceVals, $data) {
        $orgId = $resourceVals['organizations'];
        
        if (isset($orgId)) $result = $this -> getOrganizationDetails($orgId);
        else $result = $this -> getListOfAllOrganizations();
        
        if (!is_array($this -> organizations)) {
            return array('code' => '6004');
        }
        
        return $result;
    }
    
    private function getListOfAllOrganizations() {
        global $logger;
        $logger -> debug('Fetch list of organizations with their details...');
        
        $listOfOrganizationObjs = $this -> orgDAO -> readAll();
        
        if (empty($listOfOrganizationObjs)) return array('code' => '6004');
        
        foreach ($listOfOrganizationObjs as $organizationObj) {
            $this -> organizations[] = $organizationObj -> toArray();
        }
        $logger -> debug('Fetched list of ORGs: ' . json_encode($this -> organizations));
        
        return array('code' => '6000', 'data' => array('organizations' => $this -> organizations));
    }
    
    private function getOrganizationDetails($orgId) {
        global $logger;
        $logger -> debug('Fetch ORG Details with org_id: ' . $orgId);
        $organizationObj = $this -> orgDAO -> read($orgId);
        
        if (!is_object($organizationObj)) return array('6004');
        
        $organization = $organizationObj -> toArray();
        
        if (!$organization['id']) return array('6004');
        
        $this -> organizations[] = $organization;
        $logger -> debug('Fetched ORG: ' . json_encode($this -> organizations));
        
        return array('code' => '6000', 'data' => array('organizations' => $this -> organizations));
    }
    
    private function sanitize($data) {
        if (!isset($data['org_id'])) throw new MissingParametersException("'org_id' field is missing");
        
        if (!isset($data['name'])) throw new MissingParametersException("'name' field is missing");
    }
}
