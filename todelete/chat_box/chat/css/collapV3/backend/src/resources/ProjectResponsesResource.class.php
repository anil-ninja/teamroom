<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/ProjectResponse.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ProjectResponsesResource implements Resource {

    private $collapDAO;
    private $ProjectResponse;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getProjectResponsesDAO();
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

        $projectResponseId = $resourceVals ['project-responses'];
        if (isset($projectResponseId)) {
            $warnings_payload [] = 'POST call to /projectResponse must not have ' . 
                                        '/projectResponseID appended i.e. POST /projectResponse';
            throw new UnsupportedResourceMethodException();
        }

        $currentTimeStamp = date('Y-m-d H:i:s');
        $projectResponseObj = new ProjectResponse(
                            $userId,
                            $data ['project_id'],
                            $data ['status'], 
                            $data ['stmt'],
                            $currentTimeStamp
                        );

        $logger -> debug ("POSTed Project Response Detail: " . $projectResponseObj -> toString());

        $this -> collapDAO -> insert($projectResponseObj);

        $projectResponseDetail = $projectResponseObj -> toArray();
        
        if(! isset($projectResponseDetail ['id'])) 
            return array('code' => '2011');

        $this -> projectResponseDetail[] = $projectResponseDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'projectResponseDetail' => $this -> projectResponseDetail
                        )
        );
    }

    public function get($resourceVals, $data, $projectId) {
        
    //$userId : to in table as userId
        $projectId = 3;

        $projectResponseId = $resourceVals ['project-responses'];
        if (isset($projectResponseId))
            $result = $this->getprojectResponse($projectResponseId, $projectId);
        else
            $result = $this -> getListOfAllResponses($projectId);

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getprojectResponse($projectResponseID, $projectId) {
    
        global $logger;
        $logger->debug('Fetch Response...');

        $projectId = 3;

        $projectResponseObj = $this -> collapDAO -> loadResponse($projectResponseID, $projectId);

        if(empty($projectResponseObj)) 
                return array('code' => '2004');        
        
        $this -> projectResponseDetail [] = $projectResponseObj-> toArray();
        
        $logger -> debug ('Fetched project Response: ' . json_encode($this -> projectResponseDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'projectResponseDetail' => $this -> projectResponseDetail
                            )
            );
    }

    private function getListOfAllResponses($projectId) {
    
        global $logger;
        $logger->debug('Fetch list of all Responses...');

        $projectId = 3;

        $listOfResponseObjs = $this -> collapDAO -> queryAllResponse($projectId);
    
        if(empty($listOfResponseObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfResponseObjs as $responseObj) {
            $this -> responses [] = $responseObj -> toArray();
        }

        $logger -> debug ('Fetched list of responses: ' . json_encode($this -> responses));

        return array('code' => '2000', 
                     'data' => array(
                                'responses' => $this -> responses
                            )
        );
    }
}