<?php 

    /**
     * @author Jessy James
     */

	require_once 'ApiException.class.php';

    class UnsupportedResourceTypeException extends ApiException {

        function __construct ($customMessage = null, $previous = null) {
            
            parent::__construct(
                /* Code */              '1008', 
                /* Message */           $customMessage,
                /* Previous */          $previous
            );
        }
    }