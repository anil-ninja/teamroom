<?php
	/**
	 * Object represents table 'organisations'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Organisation{
		
		private $id;
		private $name;
		private $planId;
		private $time;
		function __construct($name,$planId,$time,$id = null)
		{
			$this->id = $id;

		$this ->name = $name;

		$this ->planId = $planId;

		$this ->time = $time;
		}function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setPlanID($planId){
			$this -> planId = $planId;
		}
		function getPlanId(){
				return $this-> planId;
				}
				
				function setTime($time){
			$this -> time = $time;
			function getTime(){
				return $this->time;
		}
			function setName($name){
			$this -> Name = $name;
		}
		function getName(){
				return $this-> name;
				
		}
		function toString (){
			return $this -> id . ", " . $this ->planId.",".$this->time.",".$this->name;}
			function toArray() {
			return array (
						id => $this->id,
						planId => $this->planId,
						time => $this->time,
						name => $this->name
						
						);

			

		
	}
?>
		
