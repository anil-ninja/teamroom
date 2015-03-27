<?php 

    /**
     * @author Jessy James
     */

	require_once 'exceptions/ApiException.class.php';

    class DataFieldTiedToOtherEntitiesException extends ApiException {

        /* isParent is a boolean to identify if DataField was complex_type or parent_type */
        function __construct ($dataFieldAttributeType, $dataFieldAttributeValue, $entityName = null, $actionBeingPerformed = 'updation', $previous = null) {
    
            $entityName = isset($entityName) ? "- $entityName" : '';
            $statusCode = (($actionBeingPerformed === 'updation') ? '5012' : 
                                (($actionBeingPerformed === 'deletion') ? '5013' : '5004'));

            parent::__construct(
                /* Code */              $statusCode, 
                /* Message */           "Data-field with $dataFieldAttributeType '$dataFieldAttributeValue' " . 
                                        "is references by other entities $entityName", 
                /* Previous */          $previous
            );
        }
    }