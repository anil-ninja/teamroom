<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class OrgDataFieldNotFoundException extends ApiException {

        function __construct ($orgId, $channelName, 
                                $customMessage = null, $previous = null) {

            parent::__construct(
                /* Code */      '7008', 
                /* Message */   empty($customMessage) ? 
                                    "Fields for org '$orgId' and channel '$channelName' not defined" : 
                                    $customMessage,
                /* Previous */  $previous
            );
        }
    }