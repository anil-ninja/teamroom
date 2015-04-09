<?php
/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/ChallengeOwnership.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ChallengeOwnershipResource implements Resource {

    private $collapDAO;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getChallengeOwnershipDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $userId = 5;

        $ownedId = $resourceVals ['ChallengeOwnership'];
        if (isset($ownedId)) {
            $warnings_payload [] = 'POST call to /ChallengeOwnership must not have ' . 
                                        '/ownedId appended i.e. POST /ChallengeOwnership';
            throw new UnsupportedResourceMethodException();
        }

        $nowFormat = date('Y-m-d H:i:s');
        //$nowUpdateFormat = date('0000-00-00 00:00:00');
        $challengeOwnedObj = new ChallengeOwnership(
                            $userId,
                            $data ['challenge_id'],
                            $nowFormat,
                            $data ['status'], 
                            $data ['submission_time']
                        );
//print_r($challengeOwnedObj); exit;
        $logger -> debug ("POSTed Challenge Ownership Post Detail: " . $challengeOwnedObj -> toString());

        $this -> collapDAO -> insert($challengeOwnedObj);

        $challengeOwnerDetail = $challengeOwnedObj -> toArray();
        
        if(! isset($challengeOwnerDetail ['id'])) 
            return array('code' => '2011');

        $this -> challengeOwnerDetail[] = $challengeOwnerDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'challengeOwnershipDetail' => $this -> challengeOwnerDetail
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {    }
}
?>