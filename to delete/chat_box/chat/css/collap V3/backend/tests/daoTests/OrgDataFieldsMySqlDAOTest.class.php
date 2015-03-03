<?php
 
require_once 'dao/DAOFactory.class.php';
require_once 'models/OrgDataField.class.php';
require_once 'utils/ShopbookLogger.php';

class OrgDataFieldsMySqlDAOTest extends PHPUnit_Framework_TestCase{
    
    public function testInsertOrgChannelField(){

        global $logger;
        $logger = new ShopbookLogger();
        $logger -> enabled = true;
        $logger -> debug ("Setting up PHP Unit Testing ...");
        
        $orgDataField = new OrgDataField(4, 1, 2,"age", 4, 1, null, null, 2, $id = null);

        $arr = DAOFactory::getOrgDataFieldsDAO()->insertOrgChannelField($orgDataField);

        // Act
        //$b = $a->negate();

        // Assert
        //$this->assertEquals(-1, $b->getAmount());
    }

}
