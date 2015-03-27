<?php 

    /**
     * @author Jessy James
     */

    require_once 'exceptions/DuplicateEntityException.class.php';

    class DuplicateCustomerException extends DuplicateEntityException {

        private $existingCustomerUuid;

        function __construct($existingCustomerUuid) {

            $this -> existingCustomerUuid = $existingCustomerUuid;
        }

        public function getExistingCustomerUuid() {
            return $this -> existingCustomerUuid;
        }
    }
