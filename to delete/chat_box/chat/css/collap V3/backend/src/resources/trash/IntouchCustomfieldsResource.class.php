<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
//require_once 'dao/DAOFactory.class.php';
//require_once 'models/Organization.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class IntouchCustomfieldsResource implements Resource {

    //private $orgDAO;
   // private $organizations;

    public function __construct() {
		//$DAOFactory = new DAOFactory();
		//$this->orgDAO = $DAOFactory->getOrganizationDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'options'));
    }

    public function options() {    }

    public function delete($resourceVals, $data) {    }
        
    public function put($resourceVals, $data) {    }
    
    public function post($resourceVals, $data) {    }
    

    public function get($resourceVals, $data) {
		
		$orgId = $resourceVals ['intouch-customfields'];
		$result = $this->getListOfAllIntouchCustomfields($orgId);

		if (!is_array($result)) {
		    return array('code' => '6004');
		}

		return $result;
    }

    private function getListOfAllIntouchCustomfields($orgId) {
		global $logger;
		$logger->debug('Fetch list of intouch Customfields with their details...');

		$listOfCustomfieldsArray = array();

		$json = $this->intouchCustomFieldsDownload($orgId);

		$AllIntouchCustomfieldsArray = json_decode($json,TRUE);
		$logger->debug('Intouch response list of Customfields: ' . json_encode($AllIntouchCustomfieldsArray));

		$listOfCustomfieldsArray = $AllIntouchCustomfieldsArray["response"]["organization"]["custom_fields"]["0"]["field"];
		

		if (empty($listOfCustomfieldsArray))
	    	return array('code' => '600X');

		
		$logger->debug('Fetched list of Customfields: ' . json_encode($listOfCustomfieldsArray));
		//$logger->debug('Fetched list of Customfields: ' . json_encode($AllIntouchCustomfieldsArray["response"]["organization"]["custom_fields"]));
		
		return array('code' => '6000',
			'data' => array(
				'fields' => $listOfCustomfieldsArray
			)
		);
    }


	private function intouchCustomFieldsDownload($orgId){
		global $logger;
		global $configs;
	 	$url = $configs ['INTOUCH_BASE_URL']."organization/customfields?format=json";
	    if (!function_exists('curl_init')){
	        die('Sorry cURL is not installed!');
	    }
	    $ch = curl_init();
	 
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_REFERER, "http://nucleus.capillary.in/");
	    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    						'Authorization: Basic c2hpbHBhLnJAY2FwaWxsYXJ5LmNvLmluOg==',
	    						'X-CAP-API-AUTH-KEY: Qjc0M0ExMDE0MDBBMTUzRDVFRTVFNDI0N0Q5QzAxOEI=', 
	    						'X-CAP-API-AUTH-ORG-ID: '.$orgId));
	    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $output = curl_exec($ch);
	    curl_close($ch);
	 	$logger->debug('out by api call on '. $url . " : " . json_encode($output));
	    return $output;
	}


    private function sanitize($data) {
		if (!isset($data ['org_id']))
	    	throw new MissingParametersException("'org_id' field is missing");

		if (!isset($data ['name']))
	    	throw new MissingParametersException("'name' field is missing");
    }

}
