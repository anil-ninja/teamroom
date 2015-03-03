<?php

	/**
     * @author Jessy James
     */
    require_once 'resources/Resource.interface.php';
    require_once 'dao/DAOFactory.class.php';
    require_once 'models/FieldValidator.class.php';
    require_once 'exceptions/MissingParametersException.class.php';
    require_once 'exceptions/MalformedRequestDataException.class.php';
    require_once 'exceptions/UnsupportedResourceMethodException.class.php';
    require_once 'exceptions/validators/FieldValidatorNotFoundException.class.php';

    class ValidatorResource implements Resource {

        private $validatorDAO;
        private $validators;

        public function __construct () {
            $DAOFactory     = new DAOFactory();
            $this -> validatorDAO = $DAOFactory -> getFieldValidatorsDAO();
        }
        
        public function checkIfRequestMethodValid ($requestMethod) {
            return in_array($requestMethod, array ('get', 'put', 'post', 'delete'));
        }

        public function delete ($resourceVals, $data) {
            global $logger, $warnings_payload; 
            $validatorName = $resourceVals ['validators'];

            if (! isset($validatorName)) {
                $warnings_payload [] = 'DELETE call to /validators must be succeeded ' .  
                                            'by /validator_name i.e. DELETE /validators/validator_name';
                throw new UnsupportedResourceMethodException();
            }
            $logger -> debug ("Delete validator with name: " . $validatorName);-
            
            $result = $this -> validatorDAO -> delete($validatorName);
            $logger -> debug ("Validator Deleted? " . $result);

            if ($result) 
                $result = array('code' => '3003');
            else 
                throw new FieldValidatorNotFoundException('name', $validatorName);

            return $result;
        }

        public function put ($resourceVals, $data) {
            global $logger, $warnings_payload;
            
            $validatorName = $resourceVals ['validators'];
            if (! isset($validatorName)) {
                $warnings_payload [] = 'PUT call to /validators must be succeeded ' . 
                                        'by /validator_name i.e. PUT /validators/validator_name';
                throw new UnsupportedResourceMethodException();
            }
            if (! isset($data))
                throw new MissingParametersException('No fields specified for updation');

            $logger -> debug('Load Validators Details of validator_name passes: ' . $validatorName);
            $validatorObj = $this -> validatorDAO -> read('name', $validatorName);
            $logger -> debug('Validator Loaded: ' . $validatorObj -> toString());

            if(! $validatorObj) 
                throw new FieldValidatorNotFoundException('name', $validatorName);

            /*replace ValidatorObj Values With Payload Values*/
            $newName = $data ['name'];
            $newNamespace = $data ['namespace'];
            $newIsActive  = ($data ['is_active']) ? 1 : 0;
            $newDescription = $data ['description'];

            if (isset ($newName)) {
                throw new MalformedRequestDataException(
                    "Validator's 'name' cannot be updated");
            }
            if (isset ($newNamespace)) {
                if ($newNamespace != $validatorObj -> getNamespace())
                    $validatorObj -> setNamespace($newNamespace);
            }
            if (isset ($newIsActive)) {
                if ($newIsActive != $validatorObj -> getIsActive())
                    $validatorObj -> setIsActive($newIsActive);
            }
            if (isset ($newDescription)) {
                if ($newDescription != $validatorObj -> getDescription())
                    $validatorObj -> setDescription($newDescription);
            }
            $logger -> debug('PUT Validator object: ' . $validatorObj -> toString());

            $result = $this -> validatorDAO -> update($validatorObj);
            $logger -> debug('Updated entry: ' . $result);

            if (! $result)
                return array('code' => '3012');

            $validator = $validatorObj -> toArray();
            $this -> validators [] = $validator;

            return array('code' => '3002', 
                            'data' => array(
                                'validators' => $this -> validators
                            )
            );
        }

        public function post ($resourceVals, $data) {
            global $logger, $warnings_payload;

            $validatorName = $resourceVals ['validators'];
            if (isset($validatorName)) {
                $warnings_payload [] = 'POST call to /validators must not have ' . 
                    '/validator_name appended i.e. POST /validators/validator-name';
                throw new UnsupportedResourceMethodException();
            }

            $this -> sanitize($data);
            //TO-DO: Refactor sanitize() to return &data
            $data ['is_active'] = ($data ['is_active']) ? 1 : 0;

            $validatorObj = new FieldValidator($data ['name'], $data ['namespace'], 
                                            $data ['is_active'], $data ['description']);
            $logger -> debug ("POSTed Validator: " . $validatorObj -> toString());

            $result = $this -> validatorDAO -> create($validatorObj);
            $logger -> debug ("Inserted Entry: " . $result);
            
            $validator = $validatorObj -> toArray();

            if(! isset($validator ['id'])) 
                return array('code' => '3011');

            $this -> validators[] = $validator;
            return array ('code' => '3001', 
                            'data' => array(
                                'validators' => $this -> validators
                            )
            );
        }

        public function get ($resourceVals, $data) {
            $validatorName = $resourceVals ['validators'];

            if (isset ($validatorName)) 
                $result = $this -> getValidatorDetails($validatorName);
            else 
                $result = $this -> getListOfAllValidators();

            return $result;
        }

        private function getListOfAllValidators() {
            global $logger;
            $logger -> debug ('Fetch list of validators with their details...');
            
            $listOfValidatorObjs = $this -> validatorDAO -> readAll();

            if(empty($listOfValidatorObjs)) 
                throw new FieldValidatorNotFoundException(null, null, 'No validators defined so far');

            foreach ($listOfValidatorObjs as $validatorObj) {
                $validator = $validatorObj -> toArray();
                $this -> validators [] = $validator;
            }
            $logger -> debug ('Fetched list of Validators: ' . json_encode($this -> validators));

            return array('code' => '3000', 
                            'data' => array(
                                'validators' => $this -> validators
                            )
            );
        }

        private function getValidatorDetails($validatorName) {
            global $logger; 
            $logger -> debug ('Fetch Validator Details with validator_name: ' . $validatorName);
            $validatorObj = $this -> validatorDAO -> read('name', $validatorName);
            
    	    if (! is_object($validatorObj)) {
                throw new FieldValidatorNotFoundException('name', $validatorName);
            }
    	    $validator = $validatorObj -> toArray();

            $this -> validators [] = $validator;
            $logger -> debug ('Fetched Validator: ' . json_encode($this -> validators));

            return array('code' => '3000', 
                            'data' => array(
                                'validators' => $this -> validators
                            )
            );
        }

        private function sanitize ($data) {
            global $warnings_payload;

            if (! isset($data ['name'])) 
                throw new MissingParametersException(
                    "Validator's 'name' field is missing");

            if (empty($data ['name'])) 
                throw new MalformedRequestDataException(
                    "Validator's 'name' field cannot be empty");

            if (! ctype_alnum(str_replace(array('_'), '', $data ['name']))) 
                throw new MalformedRequestDataException(
                    "Validator's 'name' field must be an alphanumeric value with the exception of '_'");

            if (! isset($data ['namespace'])) 
                throw new MissingParametersException(
                    "Validator's 'namespace' field is missing");

            if (empty($data ['namespace'])) 
                throw new MalformedRequestDataException(
                    "Validator's 'namespace' field cannot be empty");

            if (count (explode (' ', $data ['namespace'])) > 1) 
                throw new MalformedRequestDataException(
                    "Validator's 'namespace' field cannot contain whitespace; 
                    must be separated by '_' symbol");

            if (! isset($data ['is_active'])) 
                throw new MissingParametersException(
                    "Validator's 'is_active' field is missing");

            if (! is_bool($data ['is_active'])) 
                throw new MalformedRequestDataException(
                    "Validator's 'is_active' field must be a boolean value");
        
            if (! isset($data ['description'])) 
                $warnings_payload [] = "Validator's 'description' field is missing";
        }
    }
