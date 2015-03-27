<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class ConflictNotFoundException extends ApiException {

        function __construct ($conflictAttributeType, $conflictAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '7804', 
                /* Message */           isset($conflictAttributeValue) ? "Conflict with " . 
                                        "$conflictAttributeType '$conflictAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }