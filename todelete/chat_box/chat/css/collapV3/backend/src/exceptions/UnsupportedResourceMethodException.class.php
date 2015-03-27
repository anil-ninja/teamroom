<?php 

    /**
     * @author Jessy James
     */

	require_once 'ApiException.class.php';

    class UnsupportedResourceMethodException extends ApiException {

        function __construct ($customMessage = null, $previous = null) {
            
            parent::__construct(
                /* Code */              '1009', 
                /* Message */           $customMessage, 
                /* Previous */          $previous
            );
        }
    }