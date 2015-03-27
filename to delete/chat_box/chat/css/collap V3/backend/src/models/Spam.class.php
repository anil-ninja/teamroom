<?php
	/**
	 * Object represents table 'spams'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Spam{
		
		private $id;
		private $userId;
		private $spammedId;
		private $type;
		private $time;
		function __construct( $userId,$type,$spammedId,$time
		,$id = null)
		{
			$this->id = $id;
			$this->userId= $userId;
			$this->spammedId= $spammedId;
			$this->type = $type;
			$this->time = $time;
			
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
				
				function setTime($time){
			$this -> time = $time;
			function getTime(){
				return $this->time;
		}
			function setType($type){
			$this -> type= $type;
		}
		function getType(){
				return $this-> $type;
				}
				
				function setSpammedId($spammedId){
			$this -> spammedId = $spammedId;
		}
		function getSpammedId(){
				return $this-> spammedId;
		}
	function toString (){
			return $this -> id . ", " . $this ->spammedId.",".$this->userId.",".$this->type.".".$this->time
	;		}
			function toArray() {
			return array (
						id => $this->id,
			userId=>$this->userId,
			type=> $this->type,
			spammedId => $this->spammedId,
			time =>$this->time
			
			
			
						);
					}

		
		
	}
?>
