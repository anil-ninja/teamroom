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
        $this -> collapDAO = $DAOFactory -> getProjectsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;
        $update = false;
        
        $projectId = $resourceVals ['project'];

        if (! isset($projectId)) {
            $warnings_payload [] = 'PUT call to /project must be succeeded ' . 
                                    'by /challengeId i.e. PUT /project/projectId';
            throw new UnsupportedResourceMethodException();
        }
        if (! isset($data))
            throw new MissingParametersException('No fields specified for updation');

        $projectObj = $this -> collapDAO -> load($projectId);
        
        if(! is_object($projectObj)) 
            return array('code' => '2004');

        $newProjectTitle= $data ['project_title'];
        if (isset($newProjectTitle)) {
            if ($newProjectTitle != $projectObj -> getProjectTitle()) {
                $update = true;
                $projectObj -> setProjectTitle($newProjectTitle);
            }
        }

        $newStmt= $data ['stmt'];
        if (isset($newStmt)) {
            if ($newStmt != $projectObj -> getStmt()) {
                $update = true;
                $projectObj -> setStmt($newStmt);
            }
        }

        $newType= $data ['type'];
        if (isset($newType)) {
            if ($newType != $projectObj -> getType()) {
                $update = true;
                $projectObj -> setType($newType);
            }
        }

        $newOrder= $data ['order'];
        if (isset($newOrder)) {
            if ($newOrder != $projectObj -> getOrder()) {
                $update = true;
                $projectObj -> setOrder($newOrder);
            }
        }

        $newFundNeeded= $data ['fund_needed'];
        if (isset($newFundNeeded)) {
            if ($newFundNeeded != $projectObj -> getFundNeeded()) {
                $update = true;
                $projectObj -> setFundNeeded($newFundNeeded);
            }
        }

        $newProjectValue= $data ['project_value'];
        if (isset($newProjectValue)) {
            if ($newProjectValue != $projectObj -> getProjectValue()) {
                $update = true;
                $projectObj -> setProjectValue($newProjectValue);
            }
        }

        $newLastUpdateTime = date('Y-m-d H:i:s');
        if (isset($newLastUpdateTime)) {
            $update = true;
            $projectObj -> setLastUpdateTime($newLastUpdateTime);
        }


        if ($update) {
            $logger -> debug('PUT Project object: ' . $projectObj -> toString());
            $result = $this -> collapDAO -> update($projectObj);
            $logger -> debug('Updated entry: ' . $result);
        }

        $project = $projectObj -> toArray();
        $this -> project [] = $project;

        //if(! isset($project ['id'])) 
        //    return array('code' => '2004');

        return array('code' => '2002', 
                        'data' => array(
                            'Updated project' => $this -> project
                        )
        );
    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 3;

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
        $logger->debug('Fetch project...');

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
        $logger->debug('Fetch list of all projects...');


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