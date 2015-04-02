<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/KnownPeople.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserLinksResource implements Resource {

    private $collapDAO;
    private $knownPeople;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getKnownPeoplesDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload; 
        
        $userId = 2;
        
        $linkId = $resourceVals ['user-links'];

        if (! isset($linkId)) {
            $warnings_payload [] = 'DELETE call to /user-links must be succeeded ' .  
                                        'by /linkId i.e. DELETE /user-links/linkId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete link with Id: " . $linkId);-
        
        $result = $this -> collapDAO -> deleteLink($linkId);
        $logger -> debug ("Link Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;
        $update = false;
        
        $reminderId = $resourceVals ['user-reminders'];

        if (! isset($reminderId)) {
            $warnings_payload [] = 'PUT call to /user-reminders must be succeeded ' . 
                                    'by /reminderId i.e. PUT /user-reminders/reminderId';
            throw new UnsupportedResourceMethodException();
        }
        if (! isset($data))
            throw new MissingParametersException('No fields specified for updation');

        $reminderObj = $this -> collapDAO -> load($reminderId);
        
        if(! is_object($reminderObj)) 
            return array('code' => '2004');

        $newRemindTo= $data ['remind_to'];
        if (isset($newRemindTo)) {
            if ($newRemindTo != $reminderObj -> getRemindTo()) {
                $update = true;
                $reminderObj -> setRemindTo($newRemindTo);
            }
        }

        $newMessage = $data ['message'];
        if (isset($newMessage)) {
            if ($newTitle != $reminderObj -> getMessage()){
                $update = true;
                $reminderObj -> setMessage($newMessage);
            }
        }

        
        $newDisplayOnTime = $data ['display_on_time'];
        if (isset($newDisplayOnTime)) {

            $time = strtotime($data['display_on_time']);
            $curtime = time();

            if($curtime > $time) {
                $update = false;
                //return array('code' => '903');
                //do stuff
            } 

            else {
                if ($newDisplayOnTime != $reminderObj -> getDisplayOnTime()){
                    $update = true;
                    $reminderObj -> setDisplayOnTime($newDisplayOnTime);
                }
            }
        }


        if ($update) {
            $logger -> debug('PUT Reminder object: ' . $reminderObj -> toString());
            $result = $this -> collapDAO -> update($reminderObj);
            $logger -> debug('Updated entry: ' . $result);
        }

        $reminder = $reminderObj -> toArray();
        $this -> reminder [] = $reminder;

        //if(! isset($reminder ['id'])) 
        //    return array('code' => '2004');

        return array('code' => '2002', 
                        'data' => array(
                            'reminder' => $this -> reminder
                        )
        );
    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 2;

        $linkId = $resourceVals ['user-links'];
        if (isset($linkId)) {
            $warnings_payload [] = 'POST call to /user-links must not have ' . 
                                        '/linkID appended i.e. POST /user-links';
            throw new UnsupportedResourceMethodException();
        }

        $timeStamp = date('Y-m-d H:i:s');
        $lastActingTime = date('Y-m-d H:i:s');
        $linkObj = new KnownPeople(
                            $userId,
                            $data ['knowing_id'], 
                            $data ['status'],
                            $timeStamp,
                            $lastActingTime
                        );

        $logger -> debug ("POSTed Link Detail: " . $linkObj -> toString());

        $this -> collapDAO -> insert($linkObj);

        $linkDetail = $linkObj -> toArray();
        
        if(! isset($linkDetail ['id'])) 
            return array('code' => '2011');

        $this -> linkDetail[] = $linkDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'linkDetail' => $this -> linkDetail
                        )
        );    
    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : is to be updated
        $userId = 2;

        $linkId = $resourceVals ['user-links'];
        if (isset($linkId))
            //$result = $this->getLink($linkId, $userId);
        else
            $result = $this -> getListOfAllLinks($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getListOfAllLinks($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all links...');


        $listOfLinkObj = $this -> collapDAO -> queryAllLinks($userId);
        
        if(empty($listOfLinkObj)) 
                return array('code' => '2004');
        
        foreach ($listOfLinkObj as $linkObj) {
            $this -> links [] = $linkObj -> toArray();
        }

        $logger -> debug ('Fetched list of links: ' . json_encode($this -> links));

        return array('code' => '2000', 
                     'data' => array(
                                'links' => $this -> links
                            )
        );
    }
}