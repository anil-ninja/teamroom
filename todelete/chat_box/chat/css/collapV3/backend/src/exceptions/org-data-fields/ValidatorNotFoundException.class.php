<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class ValidatorNotFoundInOrgDataFieldEndpointException extends ApiException {

        function __construct ($validatorAttributeType, $validatorAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '6208', 
                /* Message */           isset($validatorAttributeValue) ? "Validator with " . 
                                        "$validatorAttributeType '$validatorAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }