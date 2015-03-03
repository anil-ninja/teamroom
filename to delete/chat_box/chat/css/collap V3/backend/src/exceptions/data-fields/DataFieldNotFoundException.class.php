<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class DataFieldNotFoundException extends ApiException {

        /* isParent is a boolean to identify if DataField was complex_type or parent_type */
        function __construct ($dataFieldAttributeType, $dataFieldAttributeValue, $isParent = null, $previous = null) {

            $type = ($isParent) ? 'ParentType' : 'ComplexType';
            
            parent::__construct(
                /* Code */              '5004', 
                /* Message */           isset($dataFieldAttributeValue) ? "$type Data-field with " . 
                                        "$dataFieldAttributeType '$dataFieldAttributeValue' does not exist" : "",
                /* Previous */          $previous
            );
        }
    }