<?php 

    /**
     * @author Jessy James
     */

	require_once 'ApiException.class.php';

    class MalformedRequestDataException extends ApiException {

        function __construct ($customMessage = null, $previous = null) {

            parent::__construct(
                /* Code */              '1006', 
                /* Message */           $customMessage, 
                /* Previous */          $previous
            );
        }
    }