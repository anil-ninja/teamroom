<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Keyword.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ChallengeKeywordsResource implements Resource {

    private $collapDAO;
    //private $challenge;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getKeywordsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload; 
        
        $challengeId = $resourceVals ['challenge-keywords'];

        if (! isset($challengeId)) {
            $warnings_payload [] = 'DELETE call to /challenge-keywords must be succeeded'. 
                                            'by /challengeId i.e. DELETE /challenge-keywords/challengeId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete challenge keywords with Id: " . $challengeId);-
        
        $result = $this -> collapDAO -> deleteByUPCId($challengeId);
        $logger -> debug ("Challenge Keywords Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $challengeId = $resourceVals ['challenge-keywords'];
        if (isset($challengeId)) {
            $warnings_payload [] = 'POST call to /challenge-keywords must not have ' . 
                                        '/challengeID appended i.e. POST /challenge-keywords';
            throw new UnsupportedResourceMethodException();
        }

        $nowFormat = date('Y-m-d H:i:s');
        $challengeKeywordsObj = new Keyword(
                                            $data ['u_p_c_id'], 
                                            $data ['type'],
                                            $data ['words'], 
                                            $data ['relevence'], 
                                            $nowFormat
                                        );

        $logger -> debug ("POSTed Challenge keywords Detail: " . $challengeKeywordsObj -> toString());

        $this -> collapDAO -> insert($challengeKeywordsObj);

        $challengeKeywordsDetail = $challengeKeywordsObj -> toArray();
        
        if(! isset($challengeKeywordsDetail ['id'])) 
            return array('code' => '2011');

        $this -> keywordsDetail[] = $challengeKeywordsDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'keywordsDetail' => $this -> keywordsDetail
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {

        $challengeId = $resourceVals ['challenge-keywords'];

        if (isset($challengeId))
            $result = $this->getChallengeKeywords($challengeId);
        else
            $result = $this -> getListOfAllchallengeKeywords();

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getChallengeKeywords($challengeId) {
    
        global $logger;
        $logger->debug('Fetch challenge keywords...'.$challengeId);

        $challengeKeywordObj = $this -> collapDAO -> loadChallengeKeywords($challengeId);
//print_r($challengeKeywordObj); exit;
        if(empty($challengeKeywordObj)) 
                return array('code' => '2004');        
        
        foreach ($challengeKeywordObj as $challengeObj) {
            $this -> challengeDetail [] = $challengeObj-> toArray();
        }

        
        $logger -> debug ('Fetched challenge keywords: ' . json_encode($this -> challengeDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'challengeDetail' => $this -> challengeDetail
                            )
            );
    }

    private function getListOfAllchallengeKeywords() {
    
        global $logger;
        $logger->debug('Fetch list of all challenges keywords...');


        $listOfchallengeObjs = $this -> collapDAO -> queryAllChallengeKeyword();
        
        if(empty($listOfchallengeObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfchallengeObjs as $challengeObj) {
            $this -> challenges [] = $challengeObj -> toArray();
        }

        $logger -> debug ('Fetched list of challenges keywords: ' . json_encode($this -> challenges));

        return array('code' => '2000', 
                     'data' => array(
                                'challenges' => $this -> challenges
                            )
        );
    }
}