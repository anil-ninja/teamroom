<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';

require_once 'models/Team.class.php';

require_once 'models/TeamMembers.class.php';

require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ProjectTeamMembersResource implements Resource {

    private $collapDAO;
    
    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getTeamsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    
    	global $logger, $warnings_payload; 
                
        $teamMemberId = $resourceVals ['project-team-members'];

        if (! isset($teamMemberId)) {
            $warnings_payload [] = 'DELETE call to /project-team-members must be succeeded ' .  
                                        'by /teamMemberId i.e. DELETE /project-team-members/teamMemberId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete team member with Id: " . $teamMemberId);-
        
        $result = $this -> collapDAO -> deleteTeamMember($teamMemberId);
        $logger -> debug ("Team Member Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {    }

    public function get($resourceVals, $data, $userId) {
        
        $userId = 2;

        $projectId = (int)$data['project'];
        $teamName = $data['team'];

        if (isset($projectId) AND isset($teamName))
            $result = $this->getAllTeamMembers($projectId, $teamName);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getAllTeamMembers($projectId, $teamName) {
    
        global $logger;
        $logger->debug('Fetch team Members...');

        $listOfAllteamMembersObj = $this -> collapDAO -> queryAllTeamMembers($projectId, $teamName);
//print_r($listOfAllteamsObj); exit;
        if(empty($listOfAllteamMembersObj)) 
                return array('code' => '2004');        
        
        foreach ($listOfAllteamMembersObj as $teamMemberObj) {
            $this -> teamMembers [] = $teamMemberObj-> toArray();
        }
        
        $logger -> debug ('Fetched teams: ' . json_encode($this -> teamMembers));

        return array('code' => '2000', 
                     'data' => array(
                                'teamMembers' => $this -> teamMembers
                            )
            );
    }
}