<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class FacebookFieldsResource implements Resource {

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
		
		//$orgId = $resourceVals ['intouch-customfields'];
		$result = $this->getListOfAllFacebookFields();

		if (!is_array($result)) {
		    return array('code' => '60xx');
		}

		return $result;
    }

    private function getListOfAllFacebookFields() {
		global $logger;
		$logger->debug('Fetch list of Facebook Fields with their details...');

		$listOfFacebookFieldsArray = array();

		$file = file_get_contents('utils/facebookFields.txt', true);


		$listOfFacebookFieldsArray = json_decode($file,TRUE);
		$logger->debug('Intouch response list of Customfields: ' . json_encode($listOfFacebookFieldsArray));

		if (empty($listOfFacebookFieldsArray))
	    	return array('code' => '600X');

		return array('code' => '6000',
			'data' => array(
				'fields' => $listOfFacebookFieldsArray
			)
		);
    }



}
