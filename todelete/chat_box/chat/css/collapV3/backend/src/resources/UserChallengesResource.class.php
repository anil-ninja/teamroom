<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Challenge.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserChallengesResource implements Resource {

    private $collapDAO;
    private $userChallenge;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getChallengesDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload; 
        
        $userId = 2;
        
        $challengeId = $resourceVals ['user-challenges'];

        if (! isset($challengeId)) {
            $warnings_payload [] = 'DELETE call to /user-challenges must be succeeded ' .  
                                        'by /challengeId i.e. DELETE /user-challenges/challengeId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete challenge with Id: " . $challengeId);-
        
        $result = $this -> collapDAO -> deleteChallenge($challengeId);
        $logger -> debug ("Challenge Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : to in table as userId
        $userId = 2;

        $challengeId = $resourceVals ['user-challenges'];
        if (isset($challengeId))
            $result = $this->getUserChallenge($challengeId, $userId);
        else
            $result = $this -> getListOfAllUserChallenges($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getUserChallenge($challengeId, $userId) {
    
        global $logger;
        $logger->debug('Fetch challenge...');

        $userId = 2;

        $challengeObj = $this -> collapDAO -> loadUserChallenge($challengeId, $userId);

        if(empty($challengeObj)) 
                return array('code' => '2004');        
        
        $this -> challengeDetail [] = $challengeObj-> toArray();
        
        $logger -> debug ('Fetched challenge: ' . json_encode($this -> challengeDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'challengeDetail' => $this -> challengeDetail
                            )
            );
    }

    private function getListOfAllUserChallenges($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all challenges...');

        $userId = 2;

        $listOfchallengeObjs = $this -> collapDAO -> queryAllUserChallenges($userId);
        
        if(empty($listOfchallengeObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfchallengeObjs as $challengeObj) {
            $this -> challenges [] = $challengeObj -> toArray();
        }

        $logger -> debug ('Fetched list of challenges: ' . json_encode($this -> challenges));

        return array('code' => '2000', 
                     'data' => array(
                                'challenges' => $this -> challenges
                            )
        );
    }
}