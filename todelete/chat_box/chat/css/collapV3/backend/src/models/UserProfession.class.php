<?php
	/**
	 * Object represents table 'user_professions'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class UserProfession{
		
		private $id;
		private $userId;
		private $professionId;
		function __construct( $userId,$professionId,$id = null)
		{$this->id = $id;
			
			$this->userId = $userId;
			$this->professionId = $professionId;
			
			
			
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
				function setProfesionId($professionId){
					$this->professionId=$professionId;
					function getProfessionId(){
						return$this->professionId;
						}
				
			
				
				
		function toString (){
			return $this -> id . ", " . $this ->userId.",".$this->professionId;}
			function toArray() {
			return array (
						id => $this->id,
						userId => $this->userId,
						professionId => $this->professionId
						
						);
					}
			

		
	}
?>
