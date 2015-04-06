<?php
/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';

require_once 'models/Profession.class.php';
require_once 'models/UserProfession.class.php';

require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserProfessionsResource implements Resource {

    private $collapDAO;
    private $userProfession;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getProfessionsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload; 
        
        $userId = 2;
        
        $professionId = $resourceVals ['user-professions'];

        if (! isset($professionId)) {
            $warnings_payload [] = 'DELETE call to /user-professions must be succeeded ' .  
                                        'by /professionId i.e. DELETE /user-professions/professionId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete profession with Id: " . $professionId);-
        
        $result = $this -> collapDAO -> deleteProfession($professionId);
        $logger -> debug ("Profession Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {   }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 3;

        $professionId = $resourceVals ['user-professions'];
        if (isset($professionId)) {
            $warnings_payload [] = 'POST call to /user-professions must not have ' . 
                                        '/professionID appended i.e. POST /user-professions';
            throw new UnsupportedResourceMethodException();
        }

        if ($data['name'] != null) {

            $nameObj = $this -> collapDAO -> queryByName($data['name']);
            //print_r($nameObj); exit;
          

            //$nameId -> set($nameObj -> getId());
            //$nameObj[0]->getId();
            //print_r($nameObj[0]); exit;

            if(empty($nameObj)) {
             
                $professionObj = new Profession($data['name']);
                $logger -> debug ("POSTed Profession Detail: " . $professionObj -> toString());
                $this -> collapDAO -> insert($professionObj);
                $userProfessionDetail = $professionObj -> toArray();

                if(isset($userProfessionDetail ['id'])) {
                    $userProfessionObj = new UserProfession(
                                        $userId,
                                        $userProfessionDetail ['id']
                                    );
            
                    $logger -> debug ("POSTed User Profession Detail: " . $userProfessionObj -> toString());
            
                    $this -> collapDAO -> insertUserProfession($userProfessionObj);
                    $userProfessionDetail = $userProfessionObj -> toArray();
                }            
            }
        }
        else {
            $userProfessionObj = new UserProfession(
                                        $userId,
                                        $data ['profession_id']
                                    );
            
            $logger -> debug ("POSTed User Profession Detail: " . $userProfessionObj -> toString());
            
            $this -> collapDAO -> insertUserProfession($userProfessionObj);
            
            $userProfessionDetail = $userProfessionObj -> toArray(); 
        }
        
    
        if(! isset($userProfessionDetail ['id'])) 
            return array('code' => '2011');

        $this -> userProfessionDetail[] = $userProfessionDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'userProfessionDetail' => $this -> userProfessionDetail
                        )
        );    
    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : is to be updated
        $userId = 2;

        $professionId = $resourceVals ['user-professions'];
        if (isset($professionId))
            $result = $this->getProfession($professionId, $userId);
        else
            $result = $this -> getListOfAllProfessions($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getListOfAllProfessions($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all professions...');


        $listOfProfessionObj = $this -> collapDAO -> queryAllUserProfessions($userId);
        
        if(empty($listOfProfessionObj)) 
                return array('code' => '2004');

        foreach ($listOfProfessionObj as $professionObj) {
            $this -> professions [] = $professionObj -> toArray();
            
        }

        $logger -> debug ('Fetched list of professions: ' . json_encode($this -> professions));

        return array('code' => '2000', 
                     'data' => array(
                                'professions' => $this -> professions
                            )
        );
    }
}