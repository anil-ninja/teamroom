<?php

/**
 * @author rajnish
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/Project.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';

class UserRecommendationResource implements Resource {

    private $collapDAO;

    public function __construct() {
        $DAOFactory = new DAOFactory();
        $this -> collapDAO = $DAOFactory -> getProjectsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
        return in_array($requestMethod, array('get', 'put', 'post', 'delete', 'options'));
    }

    public function options() {    }

    public function delete ($resourceVals, $data, $userId) {    }

    public function put ($resourceVals, $data, $userId) {    }

    public function post ($resourceVals, $data, $userId) {    }

    public function get($resourceVals, $data, $userId) {
        
        $userId = 2;
        foreach ($data as $key => $value) {
            $link_project = $key;
        }
 
        if (isset($link_project)) {
            switch ($link_project) {
                case 'links':
                    $result = $this->getLinksRecommendation($userId);    
                    break;

                case 'projects':
                    $result = $this->getProjectsRecommendation($userId);
                    break;
                
                default:
                    return array('code' => '2004');
                    break;
            }
        }

        if (!is_array($result)) {
            return array('code' => '2004');
        }

        return $result;
    }

    private function getLinksRecommendation($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all recommended user Links...');


        $listOfLinksRecommendObjs = $this -> collapDAO -> queryAllLinksRecommend($userId, $userId, $userId, $userId);
        
        if(empty($listOfLinksRecommendObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfLinksRecommendbjs as $linkObj) {
            $this -> recommendedLinks [] = $linkObj -> toArrayUserProjects();
        }
        
        $logger -> debug ('Fetched challenge: ' . json_encode($this -> recommendedLinks));

        return array('code' => '2000', 
                     'data' => array(
                                'recommendedLinks' => $this -> recommendedLinks
                            )
            );
    }

    private function getProjectsRecommendation($userId) {
    
        global $logger;
        $logger->debug('Fetch list of all recommended user projects...');


        $listOfProjectsRecommendObjs = $this -> collapDAO -> queryAllProjectsRecommend($userId);
        
        if(empty($listOfProjectsRecommendObjs)) 
                return array('code' => '2004');
        
        foreach ($listOfProjectsRecommendObjs as $projectObj) {
            $this -> recommendedProjects [] = $projectObj -> toArrayUserProjects();
        }
//print_r($listOfProjectsRecommendObjs); exit;
        $logger -> debug ('Fetched list of recommendedProjects: ' . json_encode($this -> recommendedProjects));

        return array('code' => '2000', 
                     'data' => array(
                                'recommendedProjects' => $this -> recommendedProjects
                            )
        );
    }
}