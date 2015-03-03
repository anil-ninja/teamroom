<?php
 
require_once 'dao/DAOFactory.class.php';
require_once 'models/DataField.class.php';
require_once 'utils/ShopbookLogger.php';

class DataFieldsMySqlDAOTest extends PHPUnit_Framework_TestCase{
    
    public function testInsertOrgChannelField(){

        global $logger;
        $logger = new ShopbookLogger();
        $logger -> enabled = true;
        $logger -> debug ("Setting up PHP Unit Testing ...");
        
        $dataField = new DataField("age", 1, 0,"2014-12-1 12:12:12", "", "nothg", array(4, 1, 3));
        //$dataFieldName, $dataFieldsTypeId, $defaultValue, $addedOn, $lastUpdate, $description, $fieldValidators, $id = null

        $arr = DAOFactory::getDataFieldsDAO()->insertDataField($dataField);

        // Act
        //$b = $a->negate();

        // Assert
        //$this->assertEquals(-1, $b->getAmount());
    }

}