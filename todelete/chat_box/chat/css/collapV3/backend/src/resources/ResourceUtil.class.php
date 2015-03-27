<?php

    /**
    * @author: Jessy James
    * This class is nothing but a collection of functions that maybe repeatedly 
    * called from the CustomerResource class or CustomerModel or subsequent models: 
    * CustomerOrganizationProfile, ExternalProfile, ProfileAttribute, etc.
    */

    require_once 'dao/DAOFactory.class.php';
    require_once 'models/IdentifierTypes.class.php';
    require_once 'models/SourceTypes.class.php';
    require_once 'exceptions/data-field-types/DataFieldTypeNotFoundException.class.php';
    require_once 'exceptions/data-fields/DataFieldNotFoundException.class.php';
    require_once 'exceptions/validators/FieldValidatorNotFoundException.class.php';
    require_once 'exceptions/organizations/OrganizationNotFoundException.class.php';
    require_once 'exceptions/channels/ChannelNotFoundException.class.php';
    require_once 'exceptions/customers/SourceNotFoundException.class.php';
    require_once 'exceptions/org-data-fields/OrgDataFieldNotFoundException.class.php';

    class ResourceUtil {

        private static $orgDAO;
        private static $channelDAO;
        private static $sourceDAO;
        private static $dataFieldTypeDAO;
        private static $dataFieldDAO;
        private static $validatorDAO;
        private static $orgDataFieldDAO;

        public static function loadOrganization($orgId) {
            global $logger;
            self :: $orgDAO = DAOFactory :: getOrganizationDAO();

            $logger -> debug('CHECK - Fetch ORG Details with org_id: ' . $orgId);
            $organizationObj = self :: $orgDAO -> read($orgId);

            if(! isset($organizationObj)) {
                $logger -> debug('CHECK - Fetched ORG: ' . $organizationObj);
                throw new OrganizationNotFoundException($orgId);
            }
            $logger -> debug('CHECK - Fetched ORG: ' . $organizationObj -> toString());

            return $organizationObj;
        }

        public static function loadChannel($by, $value) {
            global $logger;
            self :: $channelDAO = DAOFactory :: getChannelsDAO();

            $logger -> debug("CHECK - Fetch Channel Details with $by: $value");
            
            $channelObj = self :: $channelDAO -> read($by, $value);

            if(! isset($channelObj)) {
                $logger -> debug('CHECK - Fetched Channel: ' . $channelObj);
                throw new ChannelNotFoundException($by, $value);
            }
            $logger -> debug('CHECK - Fetched Channel: ' . $channelObj -> toString());

            return $channelObj;
        }

        public static function loadSource($sourceName, $channelName) {
            global $logger;
            self :: $sourceDAO = DAOFactory :: getSourcesDAO();

            $logger -> debug("CHECK - Fetch Source Details with source '$sourceName' and channel '$channelName'");
            $isValid = SourceTypes::isValidName($sourceName);
            if (! $isValid) {
                throw new MalformedRequestDataException(
                    "Source '$sourceName' is an invalid source type; " . 
                    "Must be one of '" . join(', ', SourceTypes::getConstants()) . "'");
            }
            $sourceObj = self :: $sourceDAO -> queryBySourceAndChannelName($sourceName, $channelName);

            if(! isset($sourceObj)) {
                $logger -> debug('CHECK - Fetched Source: ' . $sourceObj);
                throw new SourceNotFoundException($sourceName, $channelName);
            }
            $logger -> debug('CHECK - Fetched Source: ' . $sourceObj -> toString());

            return $sourceObj;
        }

        public static function loadValidator($by, $value) {
            global $logger;
            self :: $validatorDAO = DAOFactory :: getFieldValidatorsDAO();

            $logger -> debug ("CHECK - load Validator with $by: $value");
            $validatorObj = self :: $validatorDAO -> read($by, $value);

            if (! isset ($validatorObj)) {
                $logger -> debug('CHECK - Loaded ValidatorObj: ' . $validatorObj);
                throw new FieldValidatorNotFoundException($by, $value);
            }
            $logger -> debug('CHECK - Loaded ValidatorObj: ' . $validatorObj -> toString());

            return $validatorObj;
        }

        public static function loadDataFieldType($by, $value) {
            global $logger;
            self :: $dataFieldTypeDAO = DAOFactory :: getDataFieldsTypeDAO();

            $logger -> debug ("CHECK - load DataFieldType with $by: $value");
            $dataFieldTypeObj = self :: $dataFieldTypeDAO -> read($by, $value);

            if (! isset ($dataFieldTypeObj)) {
                $logger -> debug('CHECK - Loaded DataFieldTypeObj: ' . $dataFieldTypeObj);
                throw new DataFieldTypeNotFoundException($by, $value);
            }
            $logger -> debug('CHECK - Loaded DataFieldTypeObj: ' . $dataFieldTypeObj -> toString());

            return $dataFieldTypeObj;
        }


        public static function loadDataField($by, $value) {
            global $logger;
            self :: $dataFieldDAO = DAOFactory :: getDataFieldsDAO();

            $logger -> debug ("CHECK - load DataField with $by: $value");
            $dataFieldObj = self :: $dataFieldDAO -> read($by, $value);

            if (! isset ($dataFieldObj)) {
                $logger -> debug('CHECK - Loaded DataFieldObj: ' . $dataFieldObj);
                throw new DataFieldNotFoundException($by, $value);
            }
            $logger -> debug('CHECK - Loaded DataFieldObj: ' . $dataFieldObj -> toString());

            return $dataFieldObj;
        }

        public static function loadFromCachedDataField($cachedDF) {
            global $logger;
            self :: $dataFieldDAO = DAOFactory :: getDataFieldsDAO();

            $logger -> debug ("CHECK - load Cached DataField" . print_r($cachedDF, true));
            return self :: $dataFieldDAO -> convertFromCacheObject($cachedDF);
        }

        public static function loadOrgDataField($orgId, $channelId, $by, $value) {
            
            global $logger;
            self :: $orgDataFieldDAO = DAOFactory :: getOrgDataFieldsDAO();

            $logger -> debug ("CHECK - load OrgDataField and validators with $by: $value, org_id: $orgId, channel_id: $channelId");
            $orgDataFieldObj = self :: $orgDataFieldDAO -> 
                                        read($orgId, $channelId, $value, $by);

            if (! isset ($orgDataFieldObj)) {
                $logger -> debug('CHECK - Loaded DataFieldObj: ' . $orgDataFieldObj);
                throw new OrgDataFieldNotFoundException(null, null, "Field with $by '$value' not found");
            }
            $logger -> debug('CHECK - Loaded DataFieldObj: ' . $orgDataFieldObj -> toString());

            return $orgDataFieldObj;
        }

        public static function loadOrgDataFields($orgId, $channelId) {
            global $logger;
            self :: $orgDataFieldDAO = DAOFactory :: getOrgDataFieldsDAO();

            $logger -> debug("CHECK - Fetch OrgDataField Details with org_id: $orgId and channel_id: $channelId");
            $orgDataFieldObjs = self :: $orgDataFieldDAO -> readAll($orgId, $channelId);

            if(empty($orgDataFieldObjs)) {
                $logger -> debug('CHECK - Fetched OrgDataField: ' . $orgDataFieldObjs);
                throw new OrgDataFieldNotFoundException($orgId, $channelName);
            }
            $logger -> debug('CHECK - Fetched OrgDataField: ' . json_encode($orgDataFieldObjs));

            return $orgDataFieldObjs;
        }

        public static function checkIfValidIdentifiers($identifiers) {

            foreach ($identifiers as $idType => $idValue) {
                $isValid = IdentifierTypes::isValidName($idType);

                if (! $isValid) {
                    throw new MalformedRequestDataException(
                        "IdentifierType '$idType' is an invalid identifier type; " . 
                        "Must be one of '" . join(', ', IdentifierTypes::getConstants()) . "'");
                }
            }

            return true;
        }
    }