<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Project.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ProjectResource implements Resource {

    private $collapDAO;
    private $project;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getUserProjectsDAO();
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

        $projectId = $resourceVals ['project'];
        if (isset($projectId)) {
            $warnings_payload [] = 'POST call to /project must not have ' . 
                                        '/projectID appended i.e. POST /project';
            throw new UnsupportedResourceMethodException();
        }

        $timeStamp = date('Y-m-d H:i:s');
        $nowUpdateTimeStamp = date('0000-00-00 00:00:00');
        $projectObj = new Project(
                            $userId,
                            $data ['blob_id'], 
                            $data['project_title'],
                            $data ['stmt'], 
                            $data ['type'],
                            1,
                            0,
                            $timeStamp,
                            $data ['project_value'], 
                            $data ['fund_needed'],          
                            $nowUpdateTimeStamp
                        );

        $logger -> debug ("POSTed project Detail: " . $projectObj -> toString());

        $this -> collapDAO -> insert($projectObj);

        $projectDetail = $projectObj -> toArray();
        
        if(! isset($projectDetail ['id'])) 
            return array('code' => '2011');

        $this -> projectDetail[] = $projectDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'projectDetail' => $this -> projectDetail
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : to in table as userId
        $userId = 2;

        $projectId = $resourceVals ['project'];
        if (isset($projectId))
            $result = $this->getproject($projectId);
        else
            $result = $this -> getListOfAllprojects();

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getproject($projectId) {
    
        global $logger;
        $logger->debug('Fetch message...');

        $userId = 2;

        $projectObj = $this -> collapDAO -> load($projectId);

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

    private function getListOfAllprojects() {
    
        global $logger;
        $logger->debug('Fetch list of all messages...');

        $userId = 2;

        $listOfprojectObj = $this -> collapDAO -> queryAll();
        
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