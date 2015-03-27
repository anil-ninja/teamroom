<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class DataFieldNotFoundInOrgDataFieldEndpointException extends ApiException {

        function __construct ($dataFieldAttributeType, $dataFieldAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '6207', 
                /* Message */           isset($dataFieldAttributeValue) ? "Data-field with " . 
                                        "$dataFieldAttributeType '$dataFieldAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }