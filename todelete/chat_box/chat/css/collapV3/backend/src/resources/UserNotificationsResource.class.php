<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Notification.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserNotificationsResource implements Resource {

    private $collapDAO;
    private $notification;

    public function __construct() {
		
        $DAOFactory = new DAOFactory();
		$this-> collapDAO = $DAOFactory-> getNotificationsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
	
    	return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {   }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;
        
        // $userId is set temporally, update it
        $userId = 2;

        $notificationId = $resourceVals ['notifications'];
        if (isset($notificationId)) {
            $warnings_payload [] = 'POST call to /notification must not have ' . 
                                        '/notificationId appended i.e. POST /notification';
            throw new UnsupportedResourceMethodException();
        }

        $nowFormat = date('Y-m-d H:i:s');
        $notificationObj = new Notification(
                                                $data ['notice_url'], 
                                                $userId, 
                                                $nowFormat
                                            );

        $logger -> debug ("POSTed notification: " . $notificationObj -> toString());

        $this -> collapDAO -> insert($notificationObj);

        $notifications = $notificationObj -> toArray();
//print_r($notifications);  exit;        
        if(! isset($notifications ['id'])) 
            return array('code' => '4011');

        $this -> notifications[] = $notifications;
        
        return array ('code' => '4001', 
                        'data' => array(
                            'notifications' => $this -> notifications
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {

        // $userId is set temporally, update it
        $userId = 2;
		
		$notificationId = $resourceVals ['notifications'];
		if (isset($notificationId))
			$result = $this->getNotification($notificationId, $userId);
		else
			$result = $this -> getListOfAllNotifications($userId);

		if (!is_array($result)) {
		    return array('code' => '4004');
		}

		return $result;
    }

    private function getNotification($notificationId, $userId) {
	
        $userId = 2;
    	global $logger;
		$logger->debug('Fetch notification...');

		$notificationObj = $this -> collapDAO -> load($notificationId, $userId);

        if(empty($notificationObj)) 
                return array('code' => '4004');        
             
        $this -> notifications [] = $notificationObj-> toArray();
        
        $logger -> debug ('Fetched list of Notifications: ' . json_encode($this -> notifications));

        return array('code' => '4000', 
                     'data' => array(
                                'notifications' => $this -> notifications
                            )
            );
    }

    private function getListOfAllNotifications($userId) {
	
    	global $logger;
		$logger->debug('Fetch list of all notifications...');

		$listOfNotificationObjs = $this -> collapDAO -> queryAll($userId);
        //print_r($listOfNotificationObjs); exit;

        if(empty($listOfNotificationObjs)) 
                return array('code' => '4004');

        foreach ($listOfNotificationObjs as $notificationObj) {
                $notification = $notificationObj -> toArray();
                $this -> notifications [] = $notification;
        }
        $logger -> debug ('Fetched list of Notifications: ' . json_encode($this -> notifications));

        return array('code' => '4000', 
                     'data' => array(
                                'notifications' => $this -> notifications
                            )
            );
    }

}