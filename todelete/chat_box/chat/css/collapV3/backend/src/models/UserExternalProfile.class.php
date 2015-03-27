<?php
	/**
	 * Object represents table 'user_external_profiles'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class UserExternalProfile{
		
		private $id;
		private $userId;
		private $extUrl;
		 private $extUsername;
		private $extEmail;
		function __construct( $userId,$extUrl,$extUsername,$extEmail,$id = null)
		{$this->id = $id;
			
			$this->userId = $userId;
			$this->extUrl = $extUrl;
			$this->extUsername = $extUsername;
			$this->extemail = $extemail;
			}
			function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setUserID($userId){
			$this -> userId = $userId;
		}
		function getUserId(){
				return $this-> userId;
				}
				
				function setExtUrl($exturl){
			$this -> exturl = $exturl;
		}
		function getExtUrl(){
				return $this->exturl;
		}
			function setExtUsername($extUsername){
			$this -> extUsername = $extUsername;
		}
		function getExtUsername(){
				return $this-> extUsername;
				}
				
				function setExtemail($extemail){
			$this -> extemail = $extemail;
		}
		function getExtemail(){
				return $this->extemail;
		}
		function toString (){
			return $this -> id . ", " . $this ->userId.",".$this->extusername.",".$this->exturl.".".$this->extemail;
			}
			function toArray() {
			return array (
						id => $this->id,
						userId => $this->userId,
						extusernmae => $this->extusername,
						exturl => $this->exturl,
						extemail => $this->extemail
						);
					}
			
		
	}
?>
