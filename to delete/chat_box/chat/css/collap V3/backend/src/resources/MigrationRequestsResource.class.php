<?php

/**
 * @author Rahul Lahoria (rahul.lahoria@capillarytech.com)
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
//require_once 'migrations/social/SocialToNucleusMigrationsSdk.class.php';
//require_once 'migrations/intouch/IntouchToNucleusMigrationSdk.class.php';
require_once 'exceptions/MissingParametersException.class.php';
require_once 'exceptions/UnsupportedResourceMethodException.class.php';
require_once 'models/MigrationRequest.class.php';
require_once 'exceptions/org-data-fields/OrganizationNotFoundException.class.php';

class MigrationRequestsResource implements Resource {

    private $orgMigrationdDAO;
    private $organization;
    private $channel;

    public function __construct() {
		$DAOFactory = new DAOFactory();

        $this -> orgMigrationdDAO = $DAOFactory -> getMigrationRequestsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
		return in_array($requestMethod, array('get', 'options'));
    }

    public function options() {    }

    public function delete($resourceVals, $data) {    }
        
    public function put($resourceVals, $data) {    }
    
    public function post($resourceVals, $data) {  

    	global $logger, $warnings_payload;

        /* Sanitize the resource vals as well as the payload data */
        //$this -> sanitizeResourceVals($resourceVals);
        //$this -> sanitizePayload($data);

        $orgId = $resourceVals ['organizations'];
        $channelName = $resourceVals ['channels'];
            

        try {
            /* To check if the orgId exists, load org from organizations relation */
            $this -> setOrganization($orgId);
            /* To check if the channel exists, load channel from channels relation */
            $this -> setChannel($channelName);

            //($orgId, $channelName, $status, $addedOn, $id = null)
            
            $migrationRequestobj = new MigrationRequest(
            											$this -> organization, 
            											$this -> channel, 
            											0,
                                                 		date('Y-m-d H:i:s')
                                                 		);
            $logger -> debug ("POSTed OrgDataField: " . $migrationRequestobj -> toString()); 

            /* Insert into db */
            $result = $this -> orgMigrationdDAO -> insert($migrationRequestobj);
            $logger -> debug ("Inserted ID: " . $result);
            
            $migrationRequestArray = $migrationRequestobj -> toArray();
        } catch (MySqlDbException $e) {
            $odfName = $data ['name'];
            $mySqlErrNo = $e -> getErrNo();

            if ($mySqlErrNo == 1062) 
                throw new DuplicateEntityException("Field with name '$odfName' exists", $e);
            else 
                throw $e;
        } catch (Exception $e) {
                throw $e;
        }

        /* Set into '$this -> orgDataFields' */
        /*$this -> setIntoOrgDataFields ($orgDataField);*/
        $this -> migrationRequest [] = $migrationRequestArray;
        
        return array('code' => '6201', 
                        'data' => array(
                            'data-fields' => $this -> orgDataFields
                        )
        );


    }
    

    public function get($resourceVals, $data) {
		
		//$orgId = $resourceVals ['organizations'];
		//$channelName = $resourceVals ['channels'];
		//$name = $resourceVals ['fields'];

		/* To check if the orgId exists, load org from organizations relation */
		//$this -> setOrganization($orgId);
		/* To check if the channel exists, load channel from channels relation */
		//$this -> setChannel($channelName);

		
		   
		$result = $this -> getMigrationRequestingChannels();
		

		return $result;
    }

    private function getMigrationRequestingChannels() {
            global $logger;

            $logger -> debug ("Fetch details of all OrgDataFields");
            $listOfOrgMigrationObjs = $this -> orgMigrationdDAO -> queryByStatus(0);

            //if (empty ($listOfOrgDataFieldObjs)) 
            //    throw new OrgDataFieldNotFoundException();

            foreach ($listOfOrgMigrationObjs as $orgMigrationObjs) {
                $orgMigration = $orgMigrationObjs -> toArray();

                /* Set into '$this -> orgDataFields' */
                /*$this -> setIntoOrgDataFields ($orgDataField, 'name');*/
                $this -> orgMigrations [] = $orgMigration;

            }

            return array('code' => '62XX', 
                            'data' => array(
                                'fields' => $this -> orgMigrations
                            )
            );
    }

 	private function setOrganization($orgId) {
            /*global $logger;

            $logger -> debug ('CHECK - Fetch ORG Details with org_id: ' . $orgId);
            $organizationObj = ResourceUtil :: loadOrganization($orgId);

            if (! isset($organizationObj)) {
                $logger -> debug ('CHECK - Fetched ORG: ' . $organizationObj);
                throw new OrganizationNotFoundException($orgId);
            }
            $logger -> debug ('CHECK - Fetched ORG: ' . $organizationObj -> toString());
            
            /*$organization = $organizationObj -> toArray();*/

            $this -> organization = $orgId;
        }

        private function setChannel($channelName) {
            /*global $logger;

            $logger -> debug ('CHECK - Fetch Channel Details with channel_name: ' . $channelName);
            $channelObj = ResourceUtil :: loadChannel('name', $channelName);

            if(! isset($channelObj)) {
                $logger -> debug ('CHECK - Fetched Channel: ' . $channelObj);
                throw new ChannelNotFoundException('name', $channelName);
            }
            $logger -> debug ('CHECK - Fetched Channel: ' . $channelObj -> toString());
            
            /*$channel = $channelObj -> toArray();*/

            $this -> channel = $channelName;
        }   

}
