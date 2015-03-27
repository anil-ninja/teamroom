<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class FieldValidatorNotFoundException extends ApiException {

        function __construct ($validatorAttributeType, $validatorAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '3004', 
                /* Message */           isset($validatorAttributeValue) ? "Data-Field-Validator with " . 
                                        "$validatorAttributeType '$validatorAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }