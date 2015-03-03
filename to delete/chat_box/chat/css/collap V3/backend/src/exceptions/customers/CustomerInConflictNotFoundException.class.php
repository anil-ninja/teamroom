<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class CustomerInConflictNotFoundException extends ApiException {

        function __construct ($customerInConflictAttributeType, $customerInConflictAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '7904', 
                /* Message */           isset($customerInConflictAttributeValue) ? 
                                            "Customer-in-conflict with $customerInConflictAttributeType " . 
                                            "'$customerInConflictAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }