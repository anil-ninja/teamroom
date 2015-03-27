<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class DataFieldTypeNotFoundInDataFieldEndpointException extends ApiException {

        function __construct ($dataFieldTypeAttributeType, $dataFieldTypeAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '5005', 
                /* Message */           isset($dataFieldTypeAttributeValue) ? "Base Data-Field-Type with " . 
                                        "$dataFieldTypeAttributeType '$dataFieldTypeAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }