<?php

    /**
     * @author Jessy James
     */
    require_once 'resources/Resource.interface.php';
    require_once 'dao/DAOFactory.class.php';
    require_once 'exceptions/MissingParametersException.class.php';
    require_once 'exceptions/customers/ConflictNotFoundException.class.php';

    class ConflictResource implements Resource
    {
        
        private $customerDAO;
        private $conflicts;
        
        public function __construct() {
            $DAOFactory = new DAOFactory();
            $this -> customerDAO = $DAOFactory -> getCustomerDAO();
        }
        
        public function checkIfRequestMethodValid($requestMethod) {
            return in_array($requestMethod, array('get'));
        }
        
        public function delete($resourceVals, $data) {
        }
        
        public function put($resourceVals, $data) {
        }
        
        public function post($resourceVals, $data) {
        }
        
        public function get($resourceVals, $data) {
            $conflicts = array();
            $conflictUuid = $resourceVals['conflicts'];
            
            if (isset($conflictUuid)) {
                $conflict = $this -> getConflictDetails($conflictUuid);
                $conflicts = array($conflict);
            } else {
                $conflicts = $this -> getListOfConflicts();
            }
            
            return array(
                'code' => '7800', 
                'data' => array(
                    'conflicts' => $conflicts
                )
            );
        }
        
        private function getConflictDetails($conflictUuid) {
            global $logger;
            
            $logger -> debug('CHECK - Fetch Conflict Details with uuid: ' . $conflictUuid);
            $conflict = $this -> customerDAO -> loadConflict($conflictUuid);
            $logger -> debug('CHECK - Fetched Conflict: ' . json_encode($conflict));
            
            if (! isset($conflict['id'])) 
                throw new ConflictNotFoundException('uuid', $uuid);            
            
            return $conflict;
        }
        
        private function getListOfConflicts() {
            global $logger;
            
            $logger -> debug('CHECK - Fetch All Conflict Details: ');
            $conflicts = $this -> customerDAO -> loadAllConflicts();
            $logger -> debug('CHECK - Fetched Conflict: ' . json_encode($conflicts));
            
            if (empty($conflicts)) 
                throw new ConflictNotFoundException();
            
            return $conflicts;
        }
        
        private function sanitize($data) {
        }
    }