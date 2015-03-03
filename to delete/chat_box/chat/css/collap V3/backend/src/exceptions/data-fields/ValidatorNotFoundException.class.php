<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class ValidatorNotFoundInDataFieldEndpointException extends ApiException {

        function __construct ($validatorAttributeType, $validatorAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '5006', 
                /* Message */           isset($validatorAttributeValue) ? "Data-Field-Validator with " . 
                                        "$validatorAttributeType '$validatorAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }