<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';

require_once 'models/Team.class.php';

require_once 'models/Challenge.class.php';

require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ProjectTeamNameDashboardResource implements Resource {

    private $collapDAO;
    
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

    public function post ($resourceVals, $data, $userId) {    }

    public function get($resourceVals, $data, $userId) {
        
        $projectId = (int)$data['project'];
        $teamName = $data['team'];

        if (isset($projectId) AND isset($teamName))
            $result = $this->getTeamDashboard($projectId, $teamName);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getTeamDashboard($projectId, $teamName) {
    
        global $logger;
        $logger->debug('Fetch team Dashboard...');

        $listOfAllteamDashboardObj = $this -> collapDAO -> queryAllTeamDasboard($projectId,$projectId,$projectId, $teamName, $projectId, $teamName, $projectId, $teamName);

        if(empty($listOfAllteamDashboardObj)) 
                return array('code' => '2004');        
        
        foreach ($listOfAllteamDashboardObj as $teamDashboardObj) {
            $this -> teamDashboard [] = $teamDashboardObj-> toArrayTeamDashboard();
        }
        
        $logger -> debug ('Fetched teams: ' . json_encode($this -> teamDashboard));

        return array('code' => '2000', 
                     'data' => array(
                                'teamDashboard' => $this -> teamDashboard
                            )
            );
    }
}