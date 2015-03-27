<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class ChannelNotFoundException extends ApiException {

        function __construct ($channelAttributeType, $channelAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '2004', 
                /* Message */           isset($channelAttributeValue) ? "Channel with " . 
                                        "$channelAttributeType '$channelAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }