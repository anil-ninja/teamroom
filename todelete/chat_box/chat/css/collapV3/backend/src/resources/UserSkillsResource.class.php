<?php
/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';

require_once 'models/Skill.class.php';
require_once 'models/UserSkill.class.php';

require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserSkillsResource implements Resource {

    private $collapDAO;
    private $userSkill;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getSkillsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload; 
        
        $userId = 2;
        
        $skillId = $resourceVals ['user-skills'];

        if (! isset($skillId)) {
            $warnings_payload [] = 'DELETE call to /user-skills must be succeeded ' .  
                                        'by /skillId i.e. DELETE /user-skills/skillId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete skill with Id: " . $skillId);-
        
        $result = $this -> collapDAO -> deleteSkill($skillId);
        $logger -> debug ("Skill Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {   }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 2;

        $skillId = $resourceVals ['user-skills'];
        if (isset($skillId)) {
            $warnings_payload [] = 'POST call to /user-skills must not have ' . 
                                        '/skillID appended i.e. POST /user-skills';
            throw new UnsupportedResourceMethodException();
        }

        if ($data['name'] != null) {

            $nameObj = $this -> collapDAO -> queryByName($data['name']);
            //print_r($nameObj); exit;
          

            //$nameId -> set($nameObj -> getId());
            //$nameObj[0]->getId();
            //print_r($nameObj[0]); exit;

            if(empty($nameObj)) {
             
                $skillObj = new Skill($data['name']);
                $logger -> debug ("POSTed Skill Detail: " . $skillObj -> toString());
                $this -> collapDAO -> insert($skillObj);
                $userSkillDetail = $skillObj -> toArray();

                if(isset($userSkillDetail ['id'])) {
                    $userSkillObj = new UserSkill(
                                        $userId,
                                        $userSkillDetail ['id']
                                    );
            
                    $logger -> debug ("POSTed User Skill Detail: " . $userSkillObj -> toString());
            
                    $this -> collapDAO -> insertUserSkill($userSkillObj);
                    $userSkillDetail = $userSkillObj -> toArray();
                }            
            }
        }
        else {
            $userSkillObj = new UserSkill(
                                        $userId,
                                        $data ['skill_id']
                                    );
            
            $logger -> debug ("POSTed User Skill Detail: " . $userSkillObj -> toString());
            
            $this -> collapDAO -> insertUserSkill($userSkillObj);
            
            $userSkillDetail = $userSkillObj -> toArray(); 
        }
        
    
        if(! isset($userSkillDetail ['id'])) 
            return array('code' => '2011');

        $this -> userSkillDetail[] = $userSkillDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'userSkillDetail' => $this -> userSkillDetail
                        )
        );    
    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : is to be updated
        $userId = 2;

        $skillId = $resourceVals ['user-skills'];
        if (isset($skillId))
            $result = $this->getSkill($skillId, $userId);
        else
            $result = $this -> getListOfAllSkills($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getListOfAllSkills($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all skills...');


        $listOfSkillObj = $this -> collapDAO -> queryAllUserSkills($userId);
        
        if(empty($listOfSkillObj)) 
                return array('code' => '2004');

        foreach ($listOfSkillObj as $skillObj) {
            $this -> skills [] = $skillObj -> toArray();
            
        }

        $logger -> debug ('Fetched list of skills: ' . json_encode($this -> skills));

        return array('code' => '2000', 
                     'data' => array(
                                'skills' => $this -> skills
                            )
        );
    }
}