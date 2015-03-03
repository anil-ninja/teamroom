<?php

    /**
     * @author Jessy James
     */

    require_once 'resources/Resource.interface.php';
    require_once 'resources/ResourceUtil.class.php';
    require_once 'models/IdentifierTypes.class.php';
    require_once 'models/customer/Customer.class.php';
    require_once 'models/customer/CustomerOrganizationProfile.class.php';
    require_once 'models/customer/ChannelSources.class.php';
    require_once 'models/customer/ExternalProfilesFromSource.class.php';
    require_once 'models/customer/ExternalProfile.class.php';
    require_once 'models/customer/ExternalProfileAttribute.class.php';
    require_once 'resources/CustomerUnifier.class.php';
    require_once 'validators/ValidatorFactory.class.php';
    require_once 'exceptions/MissingParametersException.class.php';
    require_once 'exceptions/MalformedRequestDataException.class.php';
    require_once 'exceptions/UnsupportedResourceMethodException.class.php';
    require_once 'exceptions/MySqlDbException.class.php';
    require_once 'exceptions/DuplicateEntityException.class.php';
    require_once 'exceptions/customers/CustomerNotFoundException.class.php';

    class CustomerResource implements Resource {

        private $customerDAO;

        private $orgObj;
        private $modifiedTime;

        public function __construct () {
            $date = new DateTime();
            $this -> modifiedTime = $date -> getTimestamp();

            $this -> customerDAO = DAOFactory :: getCustomerDAO();
        }
        
        public function checkIfRequestMethodValid ($requestMethod) {
            return in_array($requestMethod, array ('get', 'put', 'post', 'delete'));
            }

        public function delete ($resourceVals, $data) {
            global $logger; 
            $idType = $idValue = $customer = null;

            if (empty($data)) {
                $warnings_payload [] = "DELETE call to /customers must be provided an identifier type " . 
                                        "and value via query parameters " . 
                                        "i.e. DELETE /customers?idType=idValue where 'idType' must be one of " . 
                                        "uuid, '" . join(', ', IdentifierTypes::getConstants() . "'"); 
                throw new UnsupportedResourceMethodException();
            } else {
                foreach ($data as $key => $value) {
                    if ($key == 'uuid') {
                        $logger -> debug("Load customer by UUID: $value");
                        $result = $this -> customerDAO -> delete($value);

                        if (! $result) 
                            throw new CustomerNotFoundException('uuid', $value);

                    } else {
                        $isValid = IdentifierTypes::isValidName($key);

                        if ($isValid) {
                            $idType = $key;
                            $idValue = $value;
                        } else {
                            throw new MissingParametersException(
                                "Invalid identifier-type specified for fetching a customer; " . 
                                "Must be one of '" . join(', ', IdentifierTypes::getConstants()) . "'");
                        }

                        $logger -> debug("Load customer by $idType = $idValue");
                        $result = $this -> customerDAO -> deleteByOtherIdentifier($idType, $idValue);

                        if (! $result) 
                            throw new CustomerNotFoundException($idType, $idValue);
                    }
                }
            }

            return array('code' => '7003');
        }

        public function put ($resourceVals, $data) {
            global $logger, $warnings_payload;
            $idType = $idValue = $customerObj = $customer = null;

            $key = key($resourceVals ['get']);
            $value = $resourceVals ['get'] [$key];

            if ($key == 'uuid') {
                $logger -> debug("Load customer by UUID: $value");
                $customerObj = $this -> customerDAO -> load($value);

                if (empty($customerObj)) 
                    throw new CustomerNotFoundException('uuid', $value);

            } else {
                $isValid = IdentifierTypes::isValidName($key);

                if (! $isValid) {
                    throw new MissingParametersException(
                        "Invalid identifier-type specified for fetching a customer; " . 
                        "Must be one of 'uuid, " . join(', ', IdentifierTypes::getConstants()) . "'");
                }

                $logger -> debug("Load customer by $key = $value");
                $customerObj = $this -> customerDAO -> loadByOtherIdentifier($key, $value);

                if (empty($customerObj)) 
                    throw new CustomerNotFoundException($key, $value);
            }
            
            /* Sanitize and transform the payload data */
            $raw ['time'] = '' . $this -> modifiedTime;
            $raw ['customerUUID'] = $customerObj -> getUuid();
            $raw ['request_id'] = $resourceVals ['request_id'];
            $raw ['method'] = 'PUT';
            $raw ['data'] = $data;
            $result = $this -> transform($data);

            $this -> mergeUpdatesIntoOldCustomerObject ($customerObj, $result);
            $logger -> debug ("PUT Customer: " . $customerObj -> toString()); 

            try {
                $customerObj = $this -> customerDAO -> update($customerObj, $raw);
            } catch (CustomerNotFoundException $e) {
                /* In case of an entry in the `customer_id_mapping` table but 
                    not in the `customers` collection */
                throw new CustomerNotFoundException($key, $value, null, $e);
            } catch (Exception $e) {
                throw $e;
            }

            $customer = $customerObj -> toArray();
            
            /* This is a hack for ORG 0 since 0 vanishes when ResponseHandler does a json_encode() and 
            don't want the entire object representation with json_encode($response, JSON_FORCE_OBJECT) */
            $count = count($customer ['profiles']); 
            if ($count = 1) {
                $orgId = key($customer ['profiles']);
                if ($orgId === 0) {
                    $customer ['profiles'] ['00'] = $custOrgProfile;
                    unset ($customer ['profiles'] [0]);
                }
            }

            return array(
                'code' => '7002', 
                'data' => array(
                    'customers' => array(
                        $customer
                    )
                )
            );
        }

        public function post ($resourceVals, $data) {
            global $logger, $warnings_payload;

            $uuid = $resourceVals ['customers'];
            if (isset($uuid)) {
                $warnings_payload [] = 'POST call to /customers must not be succeeded <customer_uuid>' . 
                                        'i.e. POST /customers not POST /customers/<customer_uuid>'; 
                throw new UnsupportedResourceMethodException();
            }

            if (! isset($data))
                throw new MissingParametersException('No fields specified for creating a customer');

            $raw ['time'] = '' . $this -> modifiedTime;
            $raw ['request_id'] = $resourceVals ['request_id'];
            $raw ['method'] = 'POST';
            $raw ['data'] = $data;

            $customers = array();
            if (is_array($data ['profiles'])) 
                $customers [] = $this -> insertSingleCustomer($data, $raw);
            else 
                $customers = $this -> insertMultipleCustomers($data, $raw);

            /* This is a hack for ORG 0 since 0 vanishes when ResponseHandler does a json_encode() and 
            don't want the entire object representation with json_encode($response, JSON_FORCE_OBJECT) */
            foreach ($customers as &$customer) {
                $count = count($customer ['profiles']); 
                if ($count = 1) {
                    $orgId = key($customer ['profiles']);
                    if ($orgId === 0) {
                        $customer ['profiles'] ['00'] = $customer ['profiles'] [0];
                        unset ($customer ['profiles'] [0]);
                    }
                }
            }

            return array(
                'code' => '7001', 
                'data' => array(
                    'customers' => $customers
                )
            );
        }

        private function convertToCustomerObject($data) {
            
            $customer = $this -> transform($data);

            if (empty($customer ['identifiers']))
                throw new MalformedRequestDataException('POST data for creating a customer not in valid format');

            $customerObj = new Customer($customer['identifiers'], $customer ['profiles']);
            return $customerObj;
        }

        private function insertSingleCustomer($data, $raw) {
            
            global $logger;

            $logger -> debug ("Transforming the payload data.."); 
            $customerObj = $this -> convertToCustomerObject($data);

            try {
                $logger -> debug ("POSTing Customer: " . $customerObj -> toString()); 
                $result = $this -> customerDAO -> insert($customerObj, $raw);
            } catch (DuplicateCustomerException $e) {

                $oldCustomerObj = $this -> customerDAO -> load($e -> getExistingCustomerUuid());
                $payload = array( 
                    'uuid' => $customerObj -> getUuid(), 
                    'identifiers' => $customerObj -> getIdentifiers(), 
                    'profiles' => $customerObj -> getProfiles()
                );
                $oldCustomerObj = $this -> mergeUpdatesIntoOldCustomerObject ($oldCustomerObj, $payload);
                $customerObj = $this -> customerDAO -> update($oldCustomerObj, $raw);
                
            } catch (Exception $e) {
                throw $e;
            }

            return $customerObj -> toArray();
        }

        private function insertMultipleCustomers($data, $raw) {
            
            global $logger;
            $customerObjs = $customers = array();
            
            $logger -> debug ("Transforming the payload data.."); 
            foreach ($data as $key => $value) 
                $customerObjs [] = $this -> convertToCustomerObject($value);

            $logger -> debug ("Batch POSTing Customers: " . print_r($customerObjs, true)); 
            
            $result = $this -> customerDAO -> multiInsert($customerObjs, $raw);

            if (isset($result ['duplicates']) && (! empty($result ['duplicates']))) {
                foreach ($result ['duplicates'] as $key => &$duplicate) {
                    $oldCustomerObj = $this -> customerDAO -> load($duplicate ['existingUuid']);
                    $customerObj = $duplicate ['customer'];
                    $payload = array( 
                        'uuid' => $customerObj -> getUuid(), 
                        'identifiers' => $customerObj -> getIdentifiers(), 
                        'profiles' => $customerObj -> getProfiles()
                    );
                    $oldCustomerObj = $this -> mergeUpdatesIntoOldCustomerObject($oldCustomerObj, $payload);
                    $duplicate = $this -> customerDAO -> update($oldCustomerObj, $raw);
                }
            }
            echo "\n'"; print_r($result); die("'--");   

            foreach ($customerObjs as $customerObj) 
                $customers [] = $customerObj -> toArray();
            
            return $customers;
        }
        
        public function get ($resourceVals, $data) {
            $idType = $idValue = $customers = null;

            if (empty($data)) {
                throw new UnsupportedResourceMethodException("Global GET for /customers endpoint not supported");
                /*$customerObjs = $this -> getListOfAllCustomers();

                foreach ($customerObjs as $customerObj) {
                    $customers [] = $customerObj -> toArray();
                }*/
            } else {
                $customers [] = $this -> getCustomerDetails($data);
            }

            return array(
                'code' => '7000', 
                'data' => array( 
                    'customers' => $customers
                )
            );
        }

        private function getListOfAllCustomers() {
            global $logger;

            $logger -> debug ("Fetch details of all Customers");
            $customers = $this -> customerDAO -> loadAll();

            if (empty ($customers)) 
                throw new CustomerNotFoundException();

            return $customers;
        }

        private function getCustomerDetails($data) {
            global $logger; 
            $idType = $idValue = $customer = $customerObj = null;

            $orgId = $data ['org_id'];
            $unify = $data ['unify'] == 'true' ? true : false;
            $unifyAcross = $data ['unifyAcross'] == 'true' ? true : false;
            if (! isset ($orgId))
                throw new MissingParametersException('Org ID must be specified');

            unset($data ['org_id']);
            unset($data ['unify']);
            unset($data ['unifyAcross']);
            if (empty($data)) 
                throw new MissingParametersException('An identifier of the customer must be specified');

            $idType = $idValue = null;
            foreach ($data as $key => $value) {
                if ($key == 'uuid') {
                    $idType = 'uuid';
                    $idValue = $value;

                    $logger -> debug("Load customer by UUID: $value");
                    $customerObj = $this -> customerDAO -> load($value);

                    if (empty($customerObj)) 
                        throw new CustomerNotFoundException('uuid', $value);

                } else {
                    $isValid = IdentifierTypes::isValidName($key);

                    if ($isValid) {
                        $idType = $key;
                        $idValue = $value;
                    } else {
                        throw new MissingParametersException(
                            "Invalid identifier-type specified for fetching a customer; " . 
                            "Must be one of uuid, '" . join(', ', IdentifierTypes::getConstants()) . "'");
                    }

                    $logger -> debug("Load customer by $idType = $idValue");
                    $customerObj = $this -> customerDAO -> loadByOtherIdentifier($idType, $idValue);

                    if (empty($customerObj)) 
                        throw new CustomerNotFoundException($idType, $idValue);
                }
                break;
            }
            /*$customer = $customerObj -> toArray();*/

            //Returning back only the profile that belongs to the `org_id` given
            $orgSpecificCustomerObj = null;
            $hasMatchedRequestedOrgId = false;
            foreach ($customerObj -> getProfiles() as $custOrgProfileObj) {
                if ($custOrgProfileObj -> getOrg() -> getOrgId() == $orgId) {

                    $identifiers = array();
                    foreach ($custOrgProfileObj -> getChannelSources() as $channelSource) {
                        foreach ($channelSource -> getExtProfilesFromSources() as $externalProfileFromSource) {
                            foreach ($externalProfileFromSource -> getProfiles() as $profile) {
                                $identifiers = $identifiers + $profile -> getIdentifiers();
                            }
                        }
                    }
                    $custOrgProfileObjs = array($custOrgProfileObj);
                    $uuid = $customerObj -> getUuid();

                    $orgSpecificCustomerObj = new Customer($identifiers, $custOrgProfileObjs, $uuid);
                    $hasMatchedRequestedOrgId = true;
                    break;
                }
            }
            if (! $hasMatchedRequestedOrgId) 
                throw new CustomerNotFoundException($idType, $idValue, $orgId);

            if ($unify)
                CustomerUnifier :: unifyAcrossProfile($orgSpecificCustomerObj);
            else if ($unifyAcross) 
                $orgSpecificCustomerObj = CustomerUnifier :: unifyAcrossChannels($orgSpecificCustomerObj);

            $orgSpecificCustomer = $orgSpecificCustomerObj -> toArray();

            /* This is a hack for ORG 0 since 0 vanishes when ResponseHandler does a json_encode() and 
            don't want the entire object representation with json_encode($response, JSON_FORCE_OBJECT) */
            if (! $unifyAcross) {
                $count = count($orgSpecificCustomer ['profiles']); 
                if ($count = 1) {
                    $orgId = key($orgSpecificCustomer ['profiles']);
                    if ($orgId === 0) {
                        $orgSpecificCustomer ['profiles'] ['00'] = $orgSpecificCustomer ['profiles'] [0];
                        unset ($orgSpecificCustomer ['profiles'] [0]);
                    }
                }
            }

            return $orgSpecificCustomer;
        }

        private function transform ($data) {
            global $warnings_payload; 
            
            $globalIdentifiers = $profiles = array(); 
            foreach ($data ['profiles'] as $key => $profile) {

                /* Fetch the org_id */
                $orgId = key($profile);
                $organizationObj = ResourceUtil :: loadOrganization($orgId);
                $rawChannels = $profile [$orgId];

                /* Fetch the channel */
                $channels = array();
                foreach ($rawChannels as $channelName => $channelSources) {
                    $channelObj = ResourceUtil :: loadChannel('name', $channelName);

                    /* Fetch the source */
                    $profilesFromSources = array();
                    foreach ($channelSources as $sourceName => $listOfExternalProfiles) {
                        $sourceObj = ResourceUtil :: loadSource($sourceName, $channelName);

                        /* Transform the external profiles' data in the format required by customer collection */
                        $extProfiles = array();
                        foreach ($listOfExternalProfiles as $externalProfile) {
                            $orgDataFields = $orgDataFieldObjs = $profileAttributes = null;

                            if (! empty($externalProfile)) {
                                $identifiers = $externalProfile ['identifiers'];
                                if (! empty($identifiers)) {
                                    if ($this -> isAssoc($identifiers)) {
                                        $valid = ResourceUtil :: checkIfValidIdentifiers($identifiers);
                                        if ($valid) {
                                            foreach ($identifiers as $idType => $idValue) {
                                                $globalIdentifiers [$idType] [] = $idValue;
                                                $globalIdentifiers [$idType] = array_unique($globalIdentifiers [$idType]);
                                            }
                                        }
                                    } else {
                                        throw new MalformedRequestDataException(
                                            "Key 'identifiers' must contain key-value attributes");
                                    }
                                } else {
                                    throw new MissingParametersException(
                                        "Key 'identifiers' is missing in the element under the source '$source' key");
                                }

                                if ($this -> isAssoc($externalProfile ['attributes'])) {
                                    $orgDataFieldObjs = ResourceUtil :: loadOrgDataFields(
                                                            $orgId, $channelObj -> getId());

                                    foreach ($orgDataFieldObjs as $orgDataFieldObj) {
                                        $orgDataField = $orgDataFieldObj -> toArray();
                                        $orgDataFields [$orgDataField ['name']] = $orgDataFieldObj;
                                    }

                                    $profileAttributes = $this -> transformIntoProfileAttributes(
                                                            $externalProfile ['attributes'], $orgDataFields);

                                    $extProfiles [] = new ExternalProfile($identifiers, 
                                                $profileAttributes ['typed'], $profileAttributes ['untyped']);
                                } else {
                                    throw new MalformedRequestDataException (
                                        "Key 'attributes' must contain key-value attributes");
                                }
                            } else {
                                throw new MissingParametersException (
                                    "Data is missing under the source '$source' key");
                            }    
                        }

                        $profilesFromSources [] = new ExternalProfilesFromSource($sourceObj, $extProfiles);
                    }
                    $channels [] = new ChannelSources($channelObj, $profilesFromSources);
                }

                /* Return all necessary information */
                $profiles [] = new CustomerOrganizationProfile($organizationObj, $channels);
            }

            return array(
                'identifiers' => $globalIdentifiers, 
                'profiles' => $profiles
            );
        }

        private function transformIntoProfileAttributes ($payload, $orgDataFields) {
            global $logger, $warnings_payload;
            $data = $raw = array();

            foreach ($payload as $key => $value) { 

                $arr = array(
                    array(
                        'v' => $value, 
                        'mt' => '' . $this -> modifiedTime
                    )
                );

                $orgDataFieldObj = $orgDataFields[$key]; 
                if (empty ($orgDataFieldObj)) {
                    $raw [$key] = $arr;
                } else {
                    $logger -> debug("Run validators on value: $value");

                    $fieldValidators = $orgDataFieldObj -> getValidators();
                    $valueToValidate = $value;
                    foreach ($fieldValidators as $fieldValidator) {
                        $validatorName = "Validator" . $this -> underscoreToCamelcase($fieldValidator -> getName());
                        
                        $validatorObj = ValidatorFactory :: get($validatorName);
                        $logger -> debug ("Validating by $validatorName");
                        try {
                            $valueToValidate = $validatorObj -> validate($valueToValidate);
                        } catch(ValidationFailedException $e) {
                            $isFieldRequired = $orgDataFieldObj -> getIsRequired();

                            if($isFieldRequired) {
                                throw $e; 
                            } else {
                                $arr [0] ['v'] = null;
                                $warnings_payload [] = $e -> getCustomMessage() . " for key '$key'";
                            }
                        } catch (Exception $e) {
                            throw $e; 
                        }
                    }

                    $typed [] = new ExternalProfileAttribute($orgDataFieldObj, $arr);
                }
            }

            $data ['typed'] = $typed;
            if (! empty($raw)) 
                $data ['untyped'] = $raw;

            return $data;
        }

        private function mergeUpdatesIntoOldCustomerObject($customerObj, $payload) {

            $mergedIdentifiers = $payload ['identifiers'] + $customerObj -> getIdentifiers();
            $customerObj -> setIdentifiers($mergedIdentifiers);

            $newProfiles = array();
            foreach ($payload ['profiles'] as $profileObj) {
                $profile = $profileObj -> toArray();
                $newProfiles [$profile ['org_id']] = $profile ['channels'];
            }
            
            $customer = $customerObj -> toArray();
            $oldProfiles = $customer ['profiles'];

            foreach ($newProfiles as $newOrgId => $newOrgProfile) {
                $existingOrgProfile = $oldProfiles [$newOrgId];
                if (! empty($existingOrgProfile)) {
                    foreach ($newOrgProfile as $newChannelName => $newSources) {
                        $existingSources = $existingOrgProfile[$newChannelName];

                        if (! empty($existingSources)) {
                            foreach ($newSources as $newSourceName => $newSetOfExternalProfiles) {
                                $existingExternalProfiles = $existingSources [$newSourceName];

                                if (! empty($existingExternalProfiles)) {
                                    foreach ($newSetOfExternalProfiles as $newExternalProfile) {
                                        $hasMatchedExternalProfile = false;
                                        foreach ($existingExternalProfiles as $existingExternalProfile) {
                                            if ($existingExternalProfile ['identifiers'] == $newExternalProfile ['identifiers']) {
                                                    
                                                $oldData = $existingExternalProfile ['attributes'];
                                                $newData = $newExternalProfile ['attributes'];

                                                $updatedTypedAttrs = $this -> mergeUpdate(
                                                                        $oldData ['typed'], $newData ['typed']);
                                                $updatedUntypedAttrs = $this -> mergeUpdate(
                                                                        $oldData ['untyped'], $newData ['untyped']);

                                                $oldProfileObjs = $customerObj -> getProfiles();
                                                foreach ($oldProfileObjs as $oldProfileObj) {
                                                    $orgId = $oldProfileObj -> getOrg() -> getOrgId();

                                                    if ($newOrgId == $orgId) {
                                                        $oldListOfChannelSources = $oldProfileObj -> getChannelSources();
                                                        foreach ($oldListOfChannelSources as $oldChannelSources) {
                                                            $oldChannelName = $oldChannelSources -> getChannel() -> getName();

                                                            if ($newChannelName == $oldChannelName) {
                                                                $oldExternalProfilesFromSources = $oldChannelSources -> getExtProfilesFromSources();
                                                                foreach ($oldExternalProfilesFromSources as $oldExternalProfilesFromSource) {
                                                                    $oldSourceName = $oldExternalProfilesFromSource -> getSource() -> getSourceName();
                                                                    
                                                                    if($oldSourceName == $newSourceName) {
                                                                        $oldExternalProfiles = $oldExternalProfilesFromSource -> getProfiles();

                                                                        foreach ($oldExternalProfiles as $oldExternalProfile) {
                                                                            $oldIdentifiers = $oldExternalProfile -> getIdentifiers();

                                                                            if ($oldIdentifiers == $newExternalProfile ['identifiers']) {
                                                                                $updatedTypedAttrObjs = null;
                                                                                foreach ($updatedTypedAttrs as $key => $values) {
                                                                                    $updatedAttr = array(
                                                                                        'key' => $key,
                                                                                        'value' => $values, 
                                                                                        'channel_id' => $oldChannelSources -> getChannel() -> getId(), 
                                                                                        'org_id' => $newOrgId
                                                                                    );
                                                                                    $updatedTypedAttrObjs [] = ExternalProfileAttribute :: 
                                                                                                                deserialize($updatedAttr, false);
                                                                                }
                                                                                $oldExternalProfile -> setTypedAttributes($updatedTypedAttrObjs);
                                                                                $oldExternalProfile -> setUntypedAttributes($updatedUntypedAttrs);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } 

                                                $hasMatchedExternalProfile = true;
                                                break;
                                            }
                                        }
                                        if (! $hasMatchedExternalProfile){

                                            $oldProfileObjs = $customerObj -> getProfiles();
                                            foreach ($oldProfileObjs as $oldProfileObj) {
                                                $orgId = $oldProfileObj -> getOrg() -> getOrgId();

                                                if ($newOrgId == $orgId) {
                                                    $oldListOfChannelSources = $oldProfileObj -> getChannelSources();
                                                    foreach ($oldListOfChannelSources as $oldChannelSources) {
                                                        $oldChannelName = $oldChannelSources -> getChannel() -> getName();

                                                        if ($newChannelName == $oldChannelName) {
                                                            $oldExternalProfilesFromSources = $oldChannelSources -> getExtProfilesFromSources();
                                                            foreach ($oldExternalProfilesFromSources as $oldExternalProfilesFromSource) {
                                                                $oldSourceName = $oldExternalProfilesFromSource -> getSource() -> getSourceName();
                                                                
                                                                if($oldSourceName == $newSourceName) {
                                                                    $newExternalProfile ['channel_id'] = $oldChannelSources -> getChannel() -> getId();
                                                                    $newExternalProfile ['org_id'] = $newOrgId;
                                                                    $newExternalProfileObj = ExternalProfile :: 
                                                                                            deserialize($newExternalProfile, false);

                                                                    $oldExternalProfilesFromSource -> setSingleProfile($newExternalProfileObj);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $newExtProfilesFromSources = array(
                                        'name' => $newSourceName, 
                                        'channel' => array('name' => $newChannelName), 
                                        'org_id' => $newOrgId,
                                        'external_profiles' => $newSetOfExternalProfiles
                                    );

                                    $oldProfileObjs = $customerObj -> getProfiles();
                                    foreach ($oldProfileObjs as $oldProfileObj) {
                                        $orgId = $oldProfileObj -> getOrg() -> getOrgId();

                                        if ($newOrgId == $orgId) {
                                            $oldListOfChannelSources = $oldProfileObj -> getChannelSources();
                                            foreach ($oldListOfChannelSources as $oldChannelSources) {
                                                $oldChannelName = $oldChannelSources -> getChannel() -> getName();

                                                if ($newChannelName == $oldChannelName) {
                                                    $newExtProfilesFromSources ['channel'] ['id'] = $oldChannelSources -> getChannel() -> getId();
                                                    $newExtProfilesFromSourcesObj = ExternalProfilesFromSource :: 
                                                                                    deserialize($newExtProfilesFromSources, false);

                                                    $oldChannelSources -> setSingleExtProfilesFromSources(
                                                                                    $newExtProfilesFromSourcesObj);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $newChannels = array(
                                'name' => $newChannelName, 
                                'org_id' => $newOrgId, 
                                'sources' => $newSources
                            );
                            $newChannelSourcesObj = ChannelSources :: deserialize ($newChannels, false);

                            $oldProfileObjs = $customerObj -> getProfiles();
                            foreach ($oldProfileObjs as $oldProfileObj) {
                                $orgId = $oldProfileObj -> getOrg() -> getOrgId();

                                if ($newOrgId == $orgId) {
                                    $oldProfileObj -> setSingleChannelSource($newChannelSourcesObj);
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    $newProfile = array($newOrgId => $newOrgProfile);
                    $newProfileObj = CustomerOrganizationProfile :: deserialize($newProfile, false);
                    $customerObj -> setProfile($newProfileObj);
                }
            }

            return $customerObj;
        }

        private function mergeUpdate($old, $new) {
            $updated = null;

            foreach ($old as $key => $value) {
                $newValue = $new [$key];
                $newIndex = count($value);

                if (! empty($newValue)) {
                    $value [$newIndex] = $newValue [0];
                    $old [$key] = $value;
                }
            }

            $updated = $old + $new;
            return $updated;
        }        

        private function isAssoc($arr)
        {
            return array_keys($arr) !== range(0, count($arr) - 1);
        }

        private function underscoreToCamelcase($string) {
          // Split string in words.
          $words = explode('_', strtolower(trim($string)));

          $return = '';
          foreach ($words as $word) {
            $return .= ucfirst($word);
          }

          return $return;
        }
    }