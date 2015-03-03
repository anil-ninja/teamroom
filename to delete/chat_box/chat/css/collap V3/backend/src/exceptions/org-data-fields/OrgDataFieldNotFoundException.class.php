<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class OrgDataFieldNotFoundException extends ApiException {

        function __construct ($orgDataFieldAttributeType = null, $orgDataFieldAttributeValue = null, $previous = null) {

            parent::__construct(
                /* Code */              '6204', 
                /* Message */           isset($orgDataFieldAttributeValue) ? "Org-channel-field with " . 
                                        "$orgDataFieldAttributeType '$orgDataFieldAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }