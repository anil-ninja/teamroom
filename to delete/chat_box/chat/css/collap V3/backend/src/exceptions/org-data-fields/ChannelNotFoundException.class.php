<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class ChannelNotFoundInOrgDataFieldEndpointException extends ApiException {

        function __construct ($channelAttributeType, $channelAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '6206', 
                /* Message */           isset($channelAttributeValue) ? "Channel with " . 
                                        "$channelAttributeType '$channelAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }