<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Project.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserProjectsResource implements Resource {

    private $collapDAO;
    private $userProject;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getProjectsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : is to be updated
        $userId = 2;

        $projectId = $resourceVals ['user-projects'];
        
        if (isset($projectId))
            $result = $this->getUserProject($projectId, $userId);
        else
            $result = $this -> getListOfAllUserProjects($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getUserProject($projectId, $userId) {
    
        global $logger;
        $logger->debug('Fetch project...');

        $userId = 2;

        $projectObj = $this -> collapDAO -> loadProject($projectId, $userId);

        if(empty($projectObj)) 
                return array('code' => '2004');        
        
        $this -> projectDetail [] = $projectObj-> toArray();
        
        $logger -> debug ('Fetched project: ' . json_encode($this -> projectDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'projectDetail' => $this -> projectDetail
                            )
            );
    }

    private function getListOfAllUserProjects($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all projects...');

        $userId = 2;

        $listOfprojectObj = $this -> collapDAO -> queryAllProjects($userId);
        
        if(empty($listOfprojectObj)) 
                return array('code' => '2004');
        
        foreach ($listOfprojectObj as $projectObj) {
            $this -> projects [] = $projectObj -> toArray();
        }

        $logger -> debug ('Fetched list of projects: ' . json_encode($this -> projects));

        return array('code' => '2000', 
                     'data' => array(
                                'projects' => $this -> projects
                            )
        );
    }
}