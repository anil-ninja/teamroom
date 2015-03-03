<?php

    /**
     * @author Jessy James
     */
    require_once 'resources/Resource.interface.php';
    require_once 'dao/DAOFactory.class.php';
    require_once 'exceptions/MissingParametersException.class.php';
    require_once 'exceptions/customers/CustomerInConflictNotFoundException.class.php';

    class CustomerInConflictResource implements Resource
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
            $customerInConflicts = array();
            $customerInConflictUuid = $resourceVals['customers-in-conflict'];
            
            if (isset($customerInConflictUuid)) {
                $customerInConflict = $this -> getCustomerInConflictDetails($customerInConflictUuid);
                $customerInConflicts = array($customerInConflict);
            } else {
                $customerInConflicts = $this -> getListOfCustomersInConflict();
            }
            
            return array(
                'code' => '7900', 
                'data' => array(
                    'conflicts' => $customerInConflicts
                )
            );
        }
        
        private function getCustomerInConflictDetails($customerInConflictUuid) {
            global $logger;
            
            $logger -> debug('CHECK - Fetch CustomerInConflict Details with uuid: ' . $customerInConflictUuid);
            $customerInConflictObj = $this -> customerDAO -> loadCustomerInConflict($customerInConflictUuid);
            $logger -> debug('CHECK - Fetched CustomerInConflict: ' . json_encode($customerInConflict));
            
            if (! isset($customerInConflictObj)) 
                throw new CustomerInConflictNotFoundException('uuid', $customerInConflictUuid); 
            $customerInConflict = $customerInConflictObj -> toArray();
            
            return $customerInConflict;
        }
        
        private function getListOfCustomersInConflict() {
            global $logger;
            
            $logger -> debug('CHECK - Fetch All CustomerInConflict Details: ');
            $customerInConflictObjs = $this -> customerDAO -> loadAllCustomersInConflict();
            $logger -> debug('CHECK - Fetched CustomerInConflicts: ' . json_encode($customerInConflictObjs));
            
            if (empty($customerInConflictObjs)) 
                throw new CustomerInConflictNotFoundException();
            
            $customersInConflict = array();
            foreach ($customerInConflictObjs as $customerInConflictObj) {
                $customersInConflict [] = $customerInConflictObj -> toArray();
            }

            return $customersInConflict;
        }
        
        private function sanitize($data) {
        }
    }