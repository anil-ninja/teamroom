<?php 

    /**
     * @author Jessy James
     */

	require_once 'ApiException.class.php';

    class MissingParametersException extends ApiException {

        function __construct ($customMessage = null, $previous = null) {

            parent::__construct(
                /* Code */              '1010', 
                /* Message */           $customMessage, 
                /* Previous */          $previous
            );
        }
    }