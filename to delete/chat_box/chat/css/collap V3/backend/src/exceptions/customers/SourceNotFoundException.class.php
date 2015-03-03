<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class SourceNotFoundException extends ApiException {

        function __construct ($sourceName, $channelName, $previous = null) {

            parent::__construct(
                /* Code */              '7007', 
                /* Message */           "Source $sourceName is not registered against channel $channelName",
                /* Previous */          $previous
            );
        }
    }