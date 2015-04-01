<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/UserInfo.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserResource implements Resource {

    private $collapDAO;
    //private $UserInfo;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getUserInfoDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;
        $update = false;
        
        $userId = $resourceVals ['user'];

        if (! isset($userId)) {
            $warnings_payload [] = 'PUT call to /user must be succeeded ' . 
                                    'by /userId i.e. PUT /user/userId';
            throw new UnsupportedResourceMethodException();
        }
        if (! isset($data))
            throw new MissingParametersException('No fields specified for updation');

        $userObj = $this -> collapDAO -> load($userId);
        
        if(! is_object($userObj)) 
            return array('code' => '2004');

        $newFirstName= $data ['first_name'];
        if (isset($newFirstName)) {
            if ($newFirstName != $userObj -> getFirstName()) {
                $update = true;
                $userObj -> setFirstName($newFirstName);
            }
        }

        $newLastName= $data ['last_name'];
        if (isset($newLastName)) {
            if ($newLastName != $userObj -> getLastName()) {
                $update = true;
                $userObj -> setLastName($newLastName);
            }
        }

        $newPhone= $data ['phone'];
        if (isset($newPhone)) {
            if ($newPhone != $userObj -> getPhone()) {
                $update = true;
                $userObj -> setPhone($newPhone);
            }
        }

        $newRank= $data ['rank'];
        if (isset($newRank)) {
            if ($newRank != $userObj -> getRank()) {
                $update = true;
                $userObj -> setRank($newRank);
            }
        }

        $newCapital= $data ['capital'];
        if (isset($newCapital)) {
            if ($newCapital != $userObj -> getCapital()) {
                $update = true;
                $userObj -> setCapital($newCapital);
            }
        }

        $newWorkingOrgName= $data ['working_org_name'];
        if (isset($newWorkingOrgName)) {
            if ($newWorkingOrgName != $userObj -> getWorkingOrgName()) {
                $update = true;
                $userObj -> setWorkingOrgName($newWorkingOrgName);
            }
        }

        $newLivingTown= $data ['living_town'];
        if (isset($newLivingTown)) {
            if ($newLivingTown != $userObj -> getLivingTown()) {
                $update = true;
                $userObj -> setLivingTown($newLivingTown);
            }
        }

        $newAboutUser= $data ['about_user'];
        if (isset($newAboutUser)) {
            if ($newAboutUser != $userObj -> getAboutUser()) {
                $update = true;
                $userObj -> setAboutUser($newAboutUser);
            }
        }

        $newLastLoginTime = date('Y-m-d H:i:s');
        if (isset($newLastLoginTime)) {
            $update = true;
            $userObj -> setLastlogintime($newLastLoginTime);
        }


        if ($update) {
            $logger -> debug('PUT User object: ' . $userObj -> toString());
            $result = $this -> collapDAO -> update($userObj);
            $logger -> debug('Updated entry: ' . $result);
        }

        $user = $userObj -> toArray();
        $this -> user [] = $user;

        //if(! isset($user ['id'])) 
        //    return array('code' => '2004');

        return array('code' => '2002', 
                        'data' => array(
                            'Updated User Details' => $this -> user
                        )
        );
    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $UserInfoId = $resourceVals ['user'];
        if (isset($UserInfoId)) {
            $warnings_payload [] = 'POST call to /user must not have ' . 
                                        '/userID appended i.e. POST /user';
            throw new UnsupportedResourceMethodException();
        }

        $userInfoObj = new UserInfo(
                                    $data ['first_name'], 
                                    $data ['last_name'], 
                                    $data ['email'], 
                                    $data ['phone'], 
                                    $data ['username'], 
                                    $data ['password'], 
                                    $data ['rank'], 
                                    $data ['user_type'], 
                                    $data ['org_id'], 
                                    $data ['capital'], 
                                    $data ['page_access'], 
                                    $data ['working_org_name'], 
                                    $data ['living_town'], 
                                    $data ['about_user'], 
                                    $data ['reg_time'], 
                                    $data ['last_login_time'] 
                                );
        $logger -> debug ("POSTed User Detail: " . $userInfoObj -> toString());
//print_r($userInfoObj); exit;
        $this -> collapDAO -> insert($userInfoObj);

        $userDetail = $userInfoObj -> toArray();
        
        if(! isset($userDetail ['id'])) 
            return array('code' => '2011');

        $this -> userDetail[] = $userDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'userDetail' => $this -> userDetail
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {

        $userId = 1;

        $UserInfoId = $resourceVals ['user'];
        if (isset($UserInfoId))
            return array('code' => '2004');
            //$result = $this->getUserDetail($userId);
            
        else
            $result = $this -> getUserDetail($userId);
        
        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getUserDetail($userId) {
    
        global $logger;
        $logger->debug('Fetch User Detail...');
        $userInfoObj = $this -> collapDAO -> load($userId);

        if(empty($userInfoObj)) 
                return array('code' => '2004');        
             
        $this -> userDetail [] = $userInfoObj-> toArray();
        $logger -> debug ('Fetched details: ' . json_encode($this -> userDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'user' => $this -> userDetail
                            )
            );
    }
}