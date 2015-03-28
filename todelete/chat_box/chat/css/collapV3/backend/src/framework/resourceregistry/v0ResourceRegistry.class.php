<?php

	/**
	 * @author Rahul Lahoria
	 */

	require_once 'ResourceRegistry.interface.php';

    class v0ResourceRegistry implements ResourceRegistry{

        private $resource = null;

        public function lookupResource ($resourceType) {

            switch($resourceType) {
                //done
            	case '/user': 
            		require_once 'resources/UserResource.class.php';
            		$this -> resource = new UserResource();
                break;
//update /notifications to user/notifications
                //done
                case '/notifications': 
                    require_once 'resources/UserNotificationsResource.class.php';
                    $this -> resource = new UserNotificationsResource();
                break;
//update /messages to user/messages
                //done
                case '/messages': 
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

//update /user-projects to user/projects
                //done
            	case '/user-projects': 
            		require_once 'resources/UserProjectsResource.class.php';
            		$this -> resource = new UserProjectsResource();
                break;
//update /user-challenges to user/challenges
                //done
                case '/user-challenges': 
                    require_once 'resources/UserChallengesResource.class.php';
                    $this -> resource = new UserChallengesResource();
                break;
            	
                case '/user/recommendation': 
            		require_once 'resources/UserRecommendationResource.class.php';
            		$this -> resource = new UserRecommendationResource();
                break;
                
                // Resorce for challenge endpoint 
                //done
            	case '/challenge': 
                    require_once 'resources/ChallengeResource.class.php';
                    $this -> resource = new ChallengeResource();
                break;
//update /responses to challenge/responses
                //done
                case '/responses': 
                    require_once 'resources/ChallengeResponsesResource.class.php';
                    $this -> resource = new ChallengeResponsesResource();
                break;

                //response can be Answer to challenge or comment to any chall post

                case '/challenge/keywords': 
                    require_once 'resources/ChallengeKeywordsResource.class.php';
                    $this -> resource = new ChallengeKeywordsResource();
                break;


                // Resorce for project endpoint 
                //done
                case '/project': 
                    require_once 'resources/ProjectResource.class.php';
                    $this -> resource = new ProjectResource();
                break;

                case '/project/teams': 
                    require_once 'resources/ProjectTeamsResource.class.php';
                    $this -> resource = new ProjectTeamsResource();
                break;

                case '/project/conversations': 
                    require_once 'resources/ProjectConversationsResource.class.php';
                    $this -> resource = new ProjectConversationsResource();
                break;
//update /project-responses to project/responses
                case '/project-responses': 
                    require_once 'resources/ProjectResponsesResource.class.php';
                    $this -> resource = new ProjectResponsesResource();
                break;

                case '/project/keywords': 
                    require_once 'resources/ProjectKeywordsResource.class.php';
                    $this -> resource = new ProjectKeywordsResource();
                break;

                case '/project/challenges': 
                    require_once 'resources/ProjectChallengesResource.class.php';
                    $this -> resource = new ProjectChallegesResource();
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
?>