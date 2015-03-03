<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Organization.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';
include_once 'registrar-php-sdk/RegistrarService.php';

use RegistrarSdk\RegistrarService;

class IntouchOrganizationResource implements Resource {

    private $orgDAO;
    private $organizations;

    public function __construct() {
		$DAOFactory = new DAOFactory();
		$this->orgDAO = $DAOFactory->getOrganizationDAO();

    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'options'));
    }

    public function options() {

    }
    public function delete($resourceVals, $data) {
    }
        
    public function put($resourceVals, $data) {
    }
    
    public function post($resourceVals, $data) {
    }
    


    public function get($resourceVals, $data) {
		$orgId = $resourceVals ['organizations'];


		if (isset($orgId))
		    $result = $this->getOrganizationDetails($orgId);
		else
		    $result = $this->getListOfAllIntouchOrganizations();

		if (!is_array($result)) {
		    return array('code' => '6004');
		}

		return $result;
    }

    private function getListOfAllIntouchOrganizations() {
		global $logger;
		$logger->debug('Fetch list of intouch organizations with their details...');

		/* Commenting this out since common.php is being picked up from cd-libcheetah to set $GLOBALS['cfg']
        $config = parse_ini_file("/etc/capillary/php-config-util/services-config.ini", true);
		$GLOBALS['cfg']['srv']['java-lb'] = $config['srv/java-lb'];
		
		//var_dump($GLOBALS['cfg']['srv']['java-lb']);
		//break; */

		$registrarService = new RegistrarService();
		$listOfOrganizationObjs = $registrarService->getAllOrgs(true);
		$listOfOrganizationArray = array();
		
		foreach ($listOfOrganizationObjs as $org) {

			$orgId =$org->getId();
			$orgName = $org->getName();

			$organizationObj = $this->orgDAO->queryByOrgId($orgId);

			if (!is_object($organizationObj)) 
		    	$listOfOrganizationArray [] = array("org_id" => $orgId,"name" => $orgName,"active" => false);
			else
				$listOfOrganizationArray [] = array("org_id" => $orgId,"name" => $orgName,"active" => true);

		}


		if (empty($listOfOrganizationArray))
	    	return array('code' => '600X');

		
		$logger->debug('Fetched list of ORGs: ' . json_encode($listOfOrganizationArray));
		
		return array('code' => '6000',
			'data' => array(
				'organizations' => $listOfOrganizationArray
			)
		);
    }


    private function sanitize($data) {
		if (!isset($data ['org_id']))
	    	throw new MissingParametersException("'org_id' field is missing");

		if (!isset($data ['name']))
	    	throw new MissingParametersException("'name' field is missing");
    }

}
