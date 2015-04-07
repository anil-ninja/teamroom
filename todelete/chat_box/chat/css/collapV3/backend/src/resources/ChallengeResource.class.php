<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Challenge.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ChallengeResource implements Resource {

    private $collapDAO;

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
        
        $challengeId = $resourceVals ['challenges'];

        if (! isset($challengeId)) {
            $warnings_payload [] = 'DELETE call to /challenges must be succeeded ' .  
                                        'by /challengeId i.e. DELETE /challenges/challengeId';
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

    public function put ($resourceVals, $data, $userId) {    
        global $logger, $warnings_payload;
        $update = false;
        
        $challengeId = $resourceVals ['challenge'];

        if (! isset($challengeId)) {
            $warnings_payload [] = 'PUT call to /challenge must be succeeded ' . 
                                    'by /challengeId i.e. PUT /challenge/challengeId';
            throw new UnsupportedResourceMethodException();
        }
        if (! isset($data))
            throw new MissingParametersException('No fields specified for updation');

        $challengeObj = $this -> collapDAO -> load($challengeId);
        
        if(! is_object($challengeObj)) 
            return array('code' => '2004');

        $newTitle= $data ['title'];
        if (isset($newTitle)) {
            if ($newTitle != $challengeObj -> getTitle()) {
                $update = true;
                $challengeObj -> setTitle($newTitle);
            }
        }

        $newStmt = $data ['stmt'];
        if (isset($newStmt)) {
            if ($newStmt != $challengeObj -> getStmt()){
                $update = true;
                $challengeObj -> setStmt($newStmt);
            }
        }

        $newStatus = $data ['status'];
        if (isset($newStatus)) {
            if ($newStmt != $challengeObj -> getStatus()){
                $update = true;
                $challengeObj -> setStatus($newStatus);
            }
        }

        $newLikes= $data ['likes'];
        if (isset($newLikes)) {
            if ($newLikes != $challengeObj -> getLikes()) {
                $update = true;
                $challengeObj -> setLikes($newLikes);
            }
        }

        $newDislikes= $data ['dislikes'];
        if (isset($newDislikes)) {
            if ($newDislikes != $challengeObj -> getDislikes()) {
                $update = true;
                $challengeObj -> setDislikes($newDislikes);
            }
        }

        $newLastUpdateTime = date('Y-m-d H:i:s');
        if (isset($newLastUpdateTime)) {
            $update = true;
            $challengeObj -> setLastUpdateTime($newLastUpdateTime);
        }


        if ($update) {
            $logger -> debug('PUT Challenge object: ' . $challengeObj -> toString());
            $result = $this -> collapDAO -> update($challengeObj);
            $logger -> debug('Updated entry: ' . $result);
        }

        $challenge = $challengeObj -> toArray();
        $this -> challenge [] = $challenge;

        //if(! isset($challenge ['id'])) 
        //    return array('code' => '2004');

        return array('code' => '2002', 
                        'data' => array(
                            'Updated challenge' => $this -> challenge
                        )
        );
    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 2;

        $challengeId = $resourceVals ['challenge'];
        if (isset($challengeId)) {
            $warnings_payload [] = 'POST call to /challenge must not have ' . 
                                        '/challengeID appended i.e. POST /challenge';
            throw new UnsupportedResourceMethodException();
        }

        $nowFormat = date('Y-m-d H:i:s');
        $nowUpdateFormat = date('0000-00-00 00:00:00');
        $challengeObj = new Challenge(
                            $userId,
                            $data ['project_id'], 
                            $data ['blob_id'], 
                            1,
                            $data ['title'], 
                            $data ['stmt'], 
                            $data ['type'],
                            1,
                            $data ['likes'], 
                            $data ['dislikes'],
                            $nowFormat,
                            $nowUpdateFormat
                        );

        $logger -> debug ("POSTed Challenge Post Detail: " . $challengeObj -> toString());

        $this -> collapDAO -> insert($challengeObj);

        $challengeDetail = $challengeObj -> toArray();
        
        if(! isset($challengeDetail ['id'])) 
            return array('code' => '2011');

        $this -> challengeDetail[] = $challengeDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'challengeDetail' => $this -> challengeDetail
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : to in table as userId
        //$userId = 2;

        $challengeId = $resourceVals ['challenge'];
        if (isset($challengeId))
            $result = $this->getchallenge($challengeId);
        else
            $result = $this -> getListOfAllchallenges();

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getchallenge($challengeID) {
    
        global $logger;
        $logger->debug('Fetch challenge...');


        $challengeObj = $this -> collapDAO -> loadChallenge($challengeID);

        if(empty($challengeObj)) 
                return array('code' => '2004');        
        
        $this -> challengeDetail [] = $challengeObj-> toArrayUserChallenges();
        
        $logger -> debug ('Fetched challenge: ' . json_encode($this -> challengeDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'challengeDetail' => $this -> challengeDetail
                            )
            );
    }

    private function getListOfAllchallenges() {
    
        global $logger;
        $logger->debug('Fetch list of all challenges...');


        $listOfchallengeObjs = $this -> collapDAO -> queryAllChallenges();
        
        if(empty($listOfchallengeObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfchallengeObjs as $challengeObj) {
            $this -> challenges [] = $challengeObj -> toArrayUserChallenges();
        }

        $logger -> debug ('Fetched list of challenges: ' . json_encode($this -> challenges));

        return array('code' => '2000', 
                     'data' => array(
                                'challengesDetails' => $this -> challenges
                            )
        );
    }
}