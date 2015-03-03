<?php 

    /**
     * @author Jessy James
     */

	require_once 'ApiException.class.php';

    class DuplicateEntityException extends ApiException {

        function __construct ($customMessage = null, $previous = null) {

            parent::__construct(
                /* Code */              '1011', 
                /* Message */           $customMessage,
                /* Previous */          $previous
            );
        }
    }