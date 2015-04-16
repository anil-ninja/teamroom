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

    public function put ($resourceVals, $data, $userId) {    }

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
        
        $userId = 2;

        $linkId = $resourceVals ['user-links'];
        if (isset($linkId))
            $result = $this->getLink($linkId, $userId);
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

        $requestingId = 3;
        $listOfLinkObj = $this -> collapDAO -> queryAllLinks($userId, $userId, $requestingId, $userId, $requestingId, $userId, $requestingId);
        
        if(empty($listOfLinkObj)) 
                return array('code' => '2004');
        
        foreach ($listOfLinkObj as $linkObj) {
            $this -> links [] = $linkObj -> toArrayLinks();
        }

        $logger -> debug ('Fetched list of links: ' . json_encode($this -> links));

        return array('code' => '2000', 
                     'data' => array(
                                'links' => $this -> links
                            )
        );
    }
}