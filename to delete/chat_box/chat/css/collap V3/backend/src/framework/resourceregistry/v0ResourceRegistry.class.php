<?php

	/**
	 * @author Rahul Lahoria
	 */

	require_once 'ResourceRegistry.interface.php';

    class v0ResourceRegistry implements ResourceRegistry{

        private $resource = null;

        public function lookupResource ($resourceType) {

            switch($resourceType) {

            	case '/user': 
            		require_once 'resources/UserResource.class.php';
            		$this -> resource = new UserResource();
                break;

                case '/user/notifications': 
                    require_once 'resources/UserNotificationsResource.class.php';
                    $this -> resource = new UserNotificationsResource();
                break;

                case '/user/messages': 
                    require_once 'resources/UserMessagesResource.class.php';
                    $this -> resource = new UserMessagesResource();
                break;

    			case '/user/reminders': 
    				require_once 'resources/UserRemindersResource.class.php';
            		$this -> resource = new UserRemindersResource();
                break;

            	case '/user/links': 
            		require_once 'resources/UserLinksResource.class.php';
            		$this -> resource = new UserLinksResource();
                break;

            	case '/user/projects': 
            		require_once 'resources/UserProjectsResource.class.php';
            		$this -> resource = new UserProjectsResource();
                break;

                case '/user/challenges': 
                    require_once 'resources/UserChallengesResource.class.php';
                    $this -> resource = new UserChallengesResource();
                break;
            	
                case '/user/recommendation': 
            		require_once 'resources/ChannelResource.class.php';
            		$this -> resource = new ChannelResource();
                break;
                
            	case '/data-field-types': 
            		require_once 'resources/DataFieldTypeResource.class.php';
            		$this -> resource = new DataFieldTypeResource();
                break;
                case '/data-fields': 
                    require_once 'resources/DataFieldResource.class.php';
                    $this -> resource = new DataFieldResource();
                break;
            	case '/validators': 
            		require_once 'resources/ValidatorResource.class.php';
            		$this -> resource = new ValidatorResource();
                break;
                case '/intouch-organizations': 
                    require_once 'resources/IntouchOrganizationResource.class.php';
                    $this -> resource = new IntouchOrganizationResource();
                break;
                case '/intouch-customfields': 
                    require_once 'resources/IntouchCustomfieldsResource.class.php';
                    $this -> resource = new IntouchCustomfieldsResource();
                break;
                //migrationRequestsResource
                case '/migration-requests': 
                    require_once 'resources/MigrationRequestsResource.class.php';
                    $this -> resource = new MigrationRequestsResource();
                break;
                case '/facebook-fields': 
                    require_once 'resources/FacebookFieldsResource.class.php';
                    $this -> resource = new FacebookFieldsResource();
                break;
            	default:
                    require_once 'exceptions/UnsupportedResourceTypeException.class.php';
            		throw new UnsupportedResourceTypeException();
                break;
            }
        	return $this -> resource;
        }

        public function toString() {
            return "Resource: " . $this -> resource;
        }
    }
