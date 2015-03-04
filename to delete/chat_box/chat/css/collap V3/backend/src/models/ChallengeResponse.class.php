<?php
	/**
	 * Object represents table 'challenge_responses'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class ChallengeResponse{
		
		private $id;
		private $userId;
		private $challengeId;
		private $blobId;
		private $stmt;
		private $status;
		private $creationTime;
function __construct( $userId,$challengeId,$blobId,$stmt,$status,$creationTime
		,$id = null)
		{
			$this->id = $id;
			$this->userId= $userId;
			$this->challengeId= $challengeId;
			$this->blobId = $blobId;
			$this->stmt = $stmt;
			$this->status = $status;
			$this->creationTime=$creationTime;}
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
				
				function ChallengeId($challengeId){
			$this -> challengeId = $challengeId;
			function getChallengeId(){
				return $this->challengeId;
		}
			function setStmt($stmt){
			$this -> $stmt= $stmt;
		}
		function getStmt(){
				return $this-> $stmt;
				}
				
				function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
		}
		function setCreationTime($creationTime){
			$this -> to = $creationTime;
		}
		function CreationTime(){
				return $this->creationTime;
		}


	
			function toString (){
			return $this -> id . ", " . $this ->challengeId.",".$this->blobId.",".$this->stmt.".".$this->creationTime.",".$this->status;}
			function toArray() {
			return array (
						
						
						
						
			id => $this->id,
			challengeId=>$this->challengeId,
			blobId=> $this->blobId,
			stmt => $this->stmt,
			creationTime =>$this->creationTime,
			
			status => $this->status
			
						);
					}

		

				
	}
?>
