<?php 

    /**
     * @author Jessy James
     */

	require_once 'ApiException.class.php';

    class DataInUnsupportedFormatException extends ApiException {

        function __construct ($customMessage = null, $previous = null) {

            parent::__construct(
                /* Code */              '1005', 
                /* Message */           $customMessage,
                /* Previous */          $previous
            );
        }
    }