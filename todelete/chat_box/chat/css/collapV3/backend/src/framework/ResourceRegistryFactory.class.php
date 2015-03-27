<?php

	/**
     * @author Jessy James
     */

    class ResourceRegistryFactory {

        protected static $resourceRegistry = null;

        public static function getResourceRegistryByVersion($requestApiVersion) {

            switch ($requestApiVersion) {

            	case 'v0': 
            		require_once 'resourceregistry/v0ResourceRegistry.class.php';
            		self :: $resourceRegistry = new v0ResourceRegistry();
                break;
    			case 'v1': 
    				/*require_once 'resourceregistry/v1ResourceRegistry.php';
            		self :: $resourceRegistry = new v1ResourceRegistry();*/
            	break;
            	default:
                    require_once 'exceptions/UnsupportedApiVersionException.class.php';
                    throw new UnsupportedApiVersionException("Only 'v0' version supported");
                break;
            }

        	return self :: $resourceRegistry;
        }

        public function toString() {
            return "ResourceRegistry: " . json_encode(self :: $resourceRegistry);
        }
    }
