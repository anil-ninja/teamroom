<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class CustomerNotFoundException extends ApiException {

        function __construct ($customerAttributeType, $customerAttributeValue, $orgId = null, $previous = null) {

            parent::__construct(
                /* Code */              '7004', 
                /* Message */           isset($customerAttributeValue) ? "Customer with " . 
                                        "$customerAttributeType '$customerAttributeValue' does not exist" . 
                                        (isset($orgId) ? " in org '$orgId'" : "") : "",
                /* Previous */          $previous
            );
        }
    }