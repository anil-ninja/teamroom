<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/ChallengeResponse.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ChallengeResponsesResource implements Resource {

    private $collapDAO;
    private $challengeResponse;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getChallengeResponsesDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 2;

        $challengeResponseId = $resourceVals ['responses'];
        if (isset($challengeResponseId)) {
            $warnings_payload [] = 'POST call to /challengeResponse must not have ' . 
                                        '/challengeResponseID appended i.e. POST /challengeResponse';
            throw new UnsupportedResourceMethodException();
        }

        $currentTimeStamp = date('Y-m-d H:i:s');
        $challengeResponseObj = new ChallengeResponse(
                            $userId,
                            $data ['challenge_id'], 
                            $data ['blob_id'], 
                            $data ['stmt'],
                            1,
                            $currentTimeStamp
                        );

        $logger -> debug ("POSTed Challenge Response Detail: " . $challengeResponseObj -> toString());

        $this -> collapDAO -> insert($challengeResponseObj);

        $challengeResponseDetail = $challengeResponseObj -> toArray();
        
        if(! isset($challengeResponseDetail ['id'])) 
            return array('code' => '2011');

        $this -> challengeResponseDetail[] = $challengeResponseDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'challengeResponseDetail' => $this -> challengeResponseDetail
                        )
        );
    }

    public function get($resourceVals, $data, $challengeId) {
        
    //$userId : to in table as userId
        $challengeId = 3;

        $challengeResponseId = $resourceVals ['responses'];
        if (isset($challengeResponseId))
            $result = $this->getchallengeResponse($challengeResponseId, $challengeId);
        else
            $result = $this -> getListOfAllResponses($challengeId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getchallengeResponse($challengeResponseID, $challengeId) {
    
        global $logger;
        $logger->debug('Fetch Response...');

        $challengeId = 3;

        $challengeResponseObj = $this -> collapDAO -> loadResponse($challengeResponseID, $challengeId);

        if(empty($challengeResponseObj)) 
                return array('code' => '2004');        
        
        $this -> challengeResponseDetail [] = $challengeResponseObj-> toArray();
        
        $logger -> debug ('Fetched challenge Response: ' . json_encode($this -> challengeResponseDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'challengeResponseDetail' => $this -> challengeResponseDetail
                            )
            );
    }

    private function getListOfAllResponses($challengeId) {
    
        global $logger;
        $logger->debug('Fetch list of all Responses...');

        $challengeId = 3;

        $listOfResponseObjs = $this -> collapDAO -> queryAllResponse($challengeId);
    
        if(empty($listOfResponseObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfResponseObjs as $responseObj) {
            $this -> responses [] = $responseObj -> toArray();
        }

        $logger -> debug ('Fetched list of responses: ' . json_encode($this -> responses));

        return array('code' => '2000', 
                     'data' => array(
                                'responses' => $this -> responses
                            )
        );
    }
}