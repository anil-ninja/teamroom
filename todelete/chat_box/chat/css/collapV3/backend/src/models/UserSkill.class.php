<?php
	/**
	 * Object represents table 'user_skills'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class UserSkill{
		
		private $id;
		private $userId;
		private $skillId;
			
		function __construct( $userId,$skillId,$id = null) {
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> skillId = $skillId;
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this -> id;
		}

		function setUserID($userId){
			$this -> userId = $userId;
		}
		function getUserId(){
			return $this-> userId;
		}
	
		function setSkillId($skillId){
			$this -> skillId = $skillId;
		}
		function getSkillId(){
			return $this -> skillId;
		}
				
		function toString (){
			return $this -> id . ", " . 
					$this -> userId.",".
					$this -> skillId;
		}
		
		function toArray() {
			return array (
						id => $this-> id,
						userId => $this-> userId,
						skillId => $this-> skillId
					);
		}
	}
?>
