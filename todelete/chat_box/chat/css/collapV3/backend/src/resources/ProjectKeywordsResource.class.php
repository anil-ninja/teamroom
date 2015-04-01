<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Keyword.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class ProjectKeywordsResource implements Resource {

    private $collapDAO;
    //private $challenge;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getKeywordsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    
    public function delete ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload; 
        
        $projectId = $resourceVals ['project-keywords'];

        if (! isset($projectId)) {
            $warnings_payload [] = 'DELETE call to /project-keywords must be succeeded'. 
                                            'by /projectId i.e. DELETE /project-keywords/projectId';
            throw new UnsupportedResourceMethodException();
        }
        $logger -> debug ("Delete project keywords with Id: " . $projectId);-
        
        $result = $this -> collapDAO -> deleteByUPCId($projectId);
        $logger -> debug ("Project Keywords Deleted? " . $result);

        if ($result) 
            $result = array('code' => '2003');
        else 
            $result = array('code' => '2004');

        return $result;
    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {
        global $logger, $warnings_payload;

        $projectId = $resourceVals ['project-keywords'];
        if (isset($projectId)) {
            $warnings_payload [] = 'POST call to /project-keywords must not have ' . 
                                        '/projectID appended i.e. POST /project-keywords';
            throw new UnsupportedResourceMethodException();
        }

        $nowFormat = date('Y-m-d H:i:s');
        $projectKeywordsObj = new Keyword(
                            $data ['u_p_c_id'], 
                            $data ['type'],
                            $data ['words'], 
                            $data ['relevence'], 
                            $nowFormat
                        );

        $logger -> debug ("POSTed project keywords Detail: " . $projectKeywordsObj -> toString());

        $this -> collapDAO -> insert($projectKeywordsObj);

        $projectKeywordsDetail = $projectKeywordsObj -> toArray();
        
        if(! isset($projectKeywordsDetail ['id'])) 
            return array('code' => '2011');

        $this -> keywordsDetail[] = $projectKeywordsDetail;
        return array ('code' => '2001', 
                        'data' => array(
                            'keywordsDetail' => $this -> keywordsDetail
                        )
        );
    }

    public function get($resourceVals, $data, $userId) {

        $projectId = $resourceVals ['project-keywords'];

        if (isset($projectId))
            $result = $this->getProjectKeywords($projectId);
        else
            $result = $this -> getListOfAllProjectKeywords();

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getProjectKeywords($projectId) {
    
        global $logger;
        $logger->debug('Fetch project keywords...'.$projectId);

        $projectKeywordObj = $this -> collapDAO -> loadProjectKeywords($projectId);

        if(empty($projectKeywordObj)) 
                return array('code' => '2004');        
        
        foreach ($projectKeywordObj as $projectObj) {
            $this -> projectDetail [] = $projectObj-> toArray();
        }

        
        $logger -> debug ('Fetched project keywords: ' . json_encode($this -> projectDetail));

        return array('code' => '2000', 
                     'data' => array(
                                'projectKeywords' => $this -> projectDetail
                            )
            );
    }

    private function getListOfAllProjectKeywords() {
    
        global $logger;
        $logger->debug('Fetch list of all project keywords...');


        $listOfProjectKeywordsObjs = $this -> collapDAO -> queryAllProjectKeyword();
        
        if(empty($listOfProjectKeywordsObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfProjectKeywordsObjs as $projectKeywords) {
            $this -> projectKeywords [] = $projectKeywords -> toArray();
        }

        $logger -> debug ('Fetched list of project keywords: ' . json_encode($this -> projectKeywords));

        return array('code' => '2000', 
                     'data' => array(
                                'projectKeywords' => $this -> projectKeywords
                            )
        );
    }
}