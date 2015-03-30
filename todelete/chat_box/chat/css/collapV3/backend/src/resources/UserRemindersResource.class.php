<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Project.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserRemindersResource implements Resource {

    private $collapDAO;
    private $userReminder;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getRemindersDAO();
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

        $projectId = $resourceVals ['user-reminders'];
        if (isset($projectId)) {
            $warnings_payload [] = 'POST call to /user-reminders must not have ' . 
                                        '/reminderID appended i.e. POST /user-reminders';
            throw new UnsupportedResourceMethodException();
        }


        $time = strtotime($data['display_on_time']);

        $curtime = time();

        if($curtime > $time) {     //1800 seconds
            return array('code' => '903');
            //do stuff
        }
        else {
            $timeStamp = date('Y-m-d H:i:s');
            $reminderObj = new Reminder(
                                $userId,
                                $data ['remind_to'],
                                $data ['message'], 
                                $data ['display_on_time'],
                                $data ['status'],
                                $timeStamp
                            );

            $logger -> debug ("POSTed Reminder Detail: " . $reminderObj -> toString());

            $this -> collapDAO -> insert($reminderObj);

            $reminderDetail = $reminderObj -> toArray();
            
            if(! isset($reminderDetail ['id'])) 
                return array('code' => '2011');

            $this -> reminderDetail[] = $reminderDetail;
            return array ('code' => '2001', 
                            'data' => array(
                                'reminderDetail' => $this -> reminderDetail
                            )
            );    
        } 
    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : is to be updated
        $userId = 2;

        $reminderId = $resourceVals ['user-reminders'];
        if (isset($reminderId))
            $result = $this->getReminder($reminderId, $userId);
        else
            $result = $this -> getListOfAllreminders($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getReminder($reminderId, $userId) {
    
        global $logger;
        $logger->debug('Fetch reminder...');

        $reminderObj = $this -> collapDAO -> loadReminder($reminderId, $userId);

        if(empty($reminderObj)) 
                return array('code' => '2004');        
        
        $this -> reminderDetail [] = $reminderObj-> toArray();
        
        $logger -> debug ('Fetched reminder: ' . json_encode($this -> reminderDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'reminderDetail' => $this -> reminderDetail
                            )
            );
    }

    private function getListOfAllreminders($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all reminders...');


        $listOfreminderObj = $this -> collapDAO -> queryAllReminders($userId);
        
        if(empty($listOfreminderObj)) 
                return array('code' => '2004');
        
        foreach ($listOfreminderObj as $reminderObj) {
            $this -> reminders [] = $reminderObj -> toArray();
        }

        $logger -> debug ('Fetched list of reminders: ' . json_encode($this -> reminders));

        return array('code' => '2000', 
                     'data' => array(
                                'reminders' => $this -> reminders
                            )
        );
    }
}