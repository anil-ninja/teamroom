<?php 

    /**
     * @author Jessy James
    **/

    require_once 'models/customer/unified/TypedProfileAttribute.class.php';
    require_once 'models/customer/unified/UnifiedProfile.class.php';
    require_once 'models/customer/unified/UnifiedCustomer.class.php';

    class CustomerUnifier
    {
        public static function unifyAcrossProfile($customerObj) {

            foreach ($customerObj -> getProfiles() as $customerOrganizationProfile) {
                foreach ($customerOrganizationProfile -> getChannelSources() as $channelSources) {
                    foreach ($channelSources -> getExtProfilesFromSources() as $externalProfileFromSource) {
                        foreach ($externalProfileFromSource -> getProfiles() as $externalProfile) {

                            /* Throwing out the values with the latest timestamp */
                            foreach ($externalProfile -> getTypedAttributes() as $typedAttributeObj) {
                                foreach ($typedAttributeObj -> getValue() as $key => $value) {
                                   $newValues [$value ['mt']] = $value;
                                }   
                                $typedAttributeObj -> setValue($newValues [max(array_keys($newValues))]);
                            }

                            $untypedAttributes = $externalProfile -> getUntypedAttributes();
                            $newUntypedAttributes = array();
                            foreach ($untypedAttributes as $untypedAttrName => $values) {
                                foreach ($values as $key => $value) {
                                   $newValues [$value ['mt']] = $value;
                                }   
                                $newUntypedAttributes [$untypedAttrName] = $newValues [max(array_keys($newValues))];
                            }
                            $externalProfile -> setUntypedAttributes($newUntypedAttributes);

                            /* Throwing out the values with the highest priority */
                            $categorizedByDataFieldsAndPriority = array();
                            $typedAttributeObjs = $externalProfile -> getTypedAttributes();
                            foreach ($typedAttributeObjs as $typedAttributeObj) {
                                $dfId = -1;
                                if (is_object ($typedAttributeObj -> getOrgDataField() -> getDataField()))
                                    $dfId = $typedAttributeObj -> getOrgDataField() -> getDataField() -> getId();
                                $priority = $typedAttributeObj -> getOrgDataField() -> getPriority();

                                if (! isset($categorizedByDataFieldsAndPriority [$dfId]))
                                    $categorizedByDataFieldsAndPriority [$dfId] = array();
                                $categorizedByDataFieldsAndPriority [$dfId] [$priority] = $typedAttributeObj;
                            }

                            $sortedByHighestPriority = array();
                            if (!empty($categorizedByDataFieldsAndPriority)) {
                                foreach ($categorizedByDataFieldsAndPriority as $dfId => $attributesWithPriority) {
                                    $sortedByHighestPriority [] = $attributesWithPriority [min(array_keys($attributesWithPriority))];
                                }
                            }
                            $externalProfile -> setTypedAttributes($sortedByHighestPriority);
                        }
                    }
                }
            }
        }

        public static function unifyAcrossSources($customerObj) {}

        public static function unifyAcrossChannels($customerObj) {

            foreach ($customerObj -> getProfiles() as $customerOrganizationProfile) {
                
                $newTypedAttributes = $newUntypedAttributes = $identifiers = array();

                foreach ($customerOrganizationProfile -> getChannelSources() as $channelSources) {
                    foreach ($channelSources -> getExtProfilesFromSources() as $externalProfileFromSource) {
                        foreach ($externalProfileFromSource -> getProfiles() as $externalProfile) {

                            $identifiers = $identifiers + $externalProfile -> getIdentifiers();

                            /* Throwing out the values with the latest timestamp */
                            $typedAttributes = $externalProfile -> getTypedAttributes();
                            $sortedByTimestamp = self :: sortEPAByTimestamp($typedAttributes);

                            $newTypedAttributes = array_merge($newTypedAttributes, $sortedByTimestamp);

                            /* Throwing out the values with the latest timestamp */
                            $untypedAttributes = $externalProfile -> getUntypedAttributes();
                            $sortedByTimestamp = self :: sortUntypedByTimestamp($untypedAttributes);
                            $newUntypedAttributes = array_merge($newUntypedAttributes, $sortedByTimestamp);
                        }
                    }
                }

                /* Throwing out the values with the highest priority */
                $highestPriorityEPAs = self :: getEPAsWithHighestPriority($newTypedAttributes);

                /* Converting them to UnifiedProfile Attributes */
                foreach ($highestPriorityEPAs as $epa) {
                    $dataField = $epa -> getOrgDataField() -> getDataField();
                    $value = $epa -> getValue();
                    $unifiedTypedProfileAttrs [] = new TypedProfileAttribute($dataField, $value);
                }

                $up = new UnifiedProfile($customerObj -> getUuid(), 
                                         $identifiers, 
                                         $unifiedTypedProfileAttrs, 
                                         $newUntypedAttributes);
                return $up;
            }
        }

        private static function sortEPAByTimestamp($typedAttributeObjs) {
            $sortedByTimestamp = array();

           foreach ($typedAttributeObjs as $typedAttributeObj) {
                if (get_class($typedAttributeObj) == 'ExternalProfileAttribute') {
                    $newValues = array();
                    foreach ($typedAttributeObj -> getValue() as $key => $value) {
                       $newValues [$value ['mt']] = $value;
                    }   
                    $latestValue = $newValues [max(array_keys($newValues))];
                    $odf = $typedAttributeObj -> getOrgDataField();
                    $odfName = $odf -> getName();
                    $sortedByTimestamp [] = new ExternalProfileAttribute($odf, $latestValue);
                }
            }

            return $sortedByTimestamp;
        }

        private static function sortUntypedByTimestamp($untypedAttributes){
            $sortedByTimestamp = array();

            foreach ($untypedAttributes as $untypedAttrName => $values) {
                foreach ($values as $key => $value) {
                   $newValues [$value ['mt']] = $value;
                }   
                $sortedByTimestamp [$untypedAttrName] = $newValues [max(array_keys($newValues))];
            }

            return $sortedByTimestamp;
        }

        private static function getEPAsWithHighestPriority($typedAttributes) {

            $categorizedByDataFieldsAndPriority = array();
            foreach ($typedAttributes as $typedAttributeObj) {
                if (get_class($typedAttributeObj) == 'ExternalProfileAttribute') {
                    $dfId = -1;
                    if (is_object ($typedAttributeObj -> getOrgDataField() -> getDataField()))
                        $dfId = $typedAttributeObj -> getOrgDataField() -> getDataField() -> getId();
                    $priority = $typedAttributeObj -> getOrgDataField() -> getPriority();

                    if (! isset($categorizedByDataFieldsAndPriority [$dfId]))
                        $categorizedByDataFieldsAndPriority [$dfId] = array();
                    $categorizedByDataFieldsAndPriority [$dfId] [$priority] = $typedAttributeObj;
                }
            }

            $highestPriority = array();
            if (! empty($categorizedByDataFieldsAndPriority)) {
                foreach ($categorizedByDataFieldsAndPriority as $dfId => $sortedByPriority) {
                    $highestPriority [] = $sortedByPriority [min(array_keys($sortedByPriority))];
                }
            }

            return $highestPriority;
        }
    }