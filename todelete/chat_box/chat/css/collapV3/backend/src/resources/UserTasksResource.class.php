<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Challenge.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserTasksResource implements Resource {

    private $collapDAO;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getChallengesDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {	}

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {    }

    public function get($resourceVals, $data, $userId) {

    	$userId = 2;
        $result = $this -> getListOfAlltasks($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }


    private function getListOfAlltasks($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all tasks to do and get done ...');

        $listOftasksObjs = $this -> collapDAO -> queryAllTasks($userId);
        
        if(empty($listOftasksObjs)) 
                return array('code' => '2004');
        
        foreach ($listOftasksObjs as $taskObj) {
            $this -> userTasks [] = $taskObj -> toArrayTeamDashboard();
        }

        $logger -> debug ('Fetched list of userTasks: ' . json_encode($this -> userTasks));

        return array('code' => '2000', 
                     'data' => array(
                                'userTasks' => $this -> userTasks
                            )
        );
    }
}