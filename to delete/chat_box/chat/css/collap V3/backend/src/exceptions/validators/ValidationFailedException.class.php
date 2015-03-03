<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class ValidationFailedException extends ApiException {

        function __construct ($validatorName, $value, $previous = null) {

            parent::__construct(
                /* Code */              '3015', 
                /* Message */           "Validator $validatorName invalidated '$value'",
                /* Previous */          $previous
            );
        }
    }