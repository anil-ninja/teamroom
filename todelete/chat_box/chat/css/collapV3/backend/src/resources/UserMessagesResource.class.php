<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Chat.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserMessagesResource implements Resource {

    private $collapDAO;
    private $message;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getChatDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $chatId = $resourceVals ['messages'];
        if (isset($chatId)) {
            $warnings_payload [] = 'POST call to /messages must not have ' . 
                                        '/chatID appended i.e. POST /user/messags';
            throw new UnsupportedResourceMethodException();
        }

        $nowFormat = date('Y-m-d H:i:s');
        $chatObj = new Chat(
                            $data ['from'], 
                            $data ['to'], 
                            $data ['message'],
                            $nowFormat,
                            0
                        );

        $logger -> debug ("POSTed Message Detail: " . $chatObj -> toString());

        $this -> collapDAO -> insert($chatObj);

        $messageDetail = $chatObj -> toArray();
        
        if(! isset($messageDetail ['id'])) 
            return array('code' => '2011');

        $this -> messageDetail[] = $messageDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'messageDetail' => $this -> messageDetail
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {
        
    //$userId : to in table as userId
        $userId = 3;

        $messageId = $resourceVals ['messages'];
        if (isset($messageId))
            $result = $this->getMessage($messageId, $userId);
        else
            $result = $this -> getListOfAllMessages($userId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getMessage($messageId, $userId) {
    
        global $logger;
        $logger->debug('Fetch message...');

        $messageObj = $this -> collapDAO -> load($messageId, $userId);

        if(empty($messageObj)) 
                return array('code' => '2004');        
             
        $this -> messages [] = $messageObj-> toArray();
        
        $logger -> debug ('Fetched list of Messages: ' . json_encode($this -> messages));

        return array('code' => '2000', 
                     'data' => array(
                                'messages' => $this -> messages
                            )
            );
    }

    private function getListOfAllMessages($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all messages...');

        $listOfmessageObjs = $this -> collapDAO -> queryAll($userId);
        
        if(empty($listOfmessageObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfmessageObjs as $messageObj) {
            $this -> messages [] = $messageObj -> toArray();
        }

        $logger -> debug ('Fetched list of messages: ' . json_encode($this -> messages));

        return array('code' => '2000', 
                     'data' => array(
                                'messages' => $this -> messages
                            )
        );
    }
}