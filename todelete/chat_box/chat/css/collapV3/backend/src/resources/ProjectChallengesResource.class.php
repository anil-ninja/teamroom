<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Challenge.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ProjectChallegesResource implements Resource {

    private $collapDAO;
    private $projectChallenge;

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
        
        $challengeId = $resourceVals ['project-challenges'];

        if (! isset($challengeId)) {
            $warnings_payload [] = 'DELETE call to /project-challenges must be succeeded ' .  
                                        'by /challengeId i.e. DELETE /project-challenges/challengeId';
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

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 2;

        $challengeId = $resourceVals ['project-challenges'];
        if (isset($challengeId)) {
            $warnings_payload [] = 'POST call to /project-challenges must not have ' . 
                                        '/challengeID appended i.e. POST /project-challenges';
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

    	$projectId = 2;

        $challengeId = $resourceVals ['project-challenges'];
        if (isset($challengeId))
            $result = $this->getProjectChallenge($challengeId, $projectId);
        else
            $result = $this -> getListOfAllProjectChallenges($projectId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getProjectChallenge($challengeID, $projectId) {
    
        global $logger;
        $logger->debug('Fetch challenge...');


        $challengeObj = $this -> collapDAO -> loadProjectChallenge($challengeID, $projectId);

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

    private function getListOfAllProjectChallenges($projectId) {
    
        global $logger;
        $logger->debug('Fetch list of all challenges...');


        $listOfchallengeObjs = $this -> collapDAO -> queryAllProjectChallenges($projectId);
        
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