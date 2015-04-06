<?php
	/**
	 * Object represents table 'professions'
	 *
     	 * @author: http://rahul.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Profession{
		
		private $id;
		private $name;
		//private $userId;
		//private $professionId;

		function __construct($name, $id = null)
		{
			$this -> id = $id;
			$this -> name = $name;
			//$this -> userId = $userId;;
			//$this -> professionId = $professionId;
		}

		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this->id;
		}

		function setName($name){
			$this -> name = $name;
		}
		function getName(){
			return $this-> name;
		}

		/*function setUserId($userId){
			$this -> userId = $userId;
		}
		function getUserId(){
			return $this -> userId;
		}

		function setProfessionId ($professionId){
			$this -> professionId = $professionId;
		}
		function getProfessionId(){
			return $this -> professionId;
		}*/

		function toString (){
			return $this -> id . ", " .
					$this -> name;
		}
		
		function toArray() {
			return array (
						id => $this -> id,
						name => $this -> name
				);
		}
	}
?>