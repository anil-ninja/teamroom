<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Team.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ProjectTeamsResource implements Resource {

    private $collapDAO;
    private $team;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getTeamsDAO();
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

        $teamId = $resourceVals ['project-team'];
        if (isset($teamId)) {
            $warnings_payload [] = 'POST call to /project-team must not have ' . 
                                        '/teamID appended i.e. POST /project-team';
            throw new UnsupportedResourceMethodException();
        }

        $timeStamp = date('Y-m-d H:i:s');
        $leaveTime = date('0000-00-00 00:00:00');
        $teamObj = new Team(
                            $userId,
                            $data ['project_id'], 
                            $data ['team_name'],
                            $data ['team_owner'], 
                            $timeStamp,
                            $data ['member_status'], 
                            $leaveTime,
                            $data ['status']        
                        );

        $logger -> debug ("POSTed team Detail: " . $teamObj -> toString());

        $this -> collapDAO -> insert($teamObj);

        $teamDetail = $teamObj -> toArray();
        
        if(! isset($teamDetail ['id'])) 
            return array('code' => '2011');

        $this -> teamDetail[] = $teamDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'teamDetail' => $this -> teamDetail
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