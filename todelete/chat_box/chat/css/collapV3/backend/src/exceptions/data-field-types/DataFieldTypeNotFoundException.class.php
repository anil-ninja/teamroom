<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class DataFieldTypeNotFoundException extends ApiException {

        function __construct ($dataFieldTypeAttributeType, $dataFieldTypeAttributeValue, $previous = null) {

            parent::__construct(
                /* Code */              '4004', 
                /* Message */           isset($dataFieldTypeAttributeValue) ? "Data-Field-Type with " . 
                                        "$dataFieldTypeAttributeType '$dataFieldTypeAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }