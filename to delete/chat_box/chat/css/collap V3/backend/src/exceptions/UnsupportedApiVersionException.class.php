<?php 

    /**
     * @author Jessy James
     */

	require_once 'ApiException.class.php';

    class UnsupportedApiVersionException extends ApiException {

        function __construct ($customMessage = null, $previous = null) {

            parent::__construct(
                /* Code */              '1007', 
                /* Message */           $customMessage, 
                /* Previous */          $previous
            );
        }
    }