<?php
	/**
	 * Object represents table 'challenge_ownership'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class ChallengeOwnership{
		
		private $id;





			function __construct( $userId,$to,$challengeId,$ownershipCreation,$submissionTime,$status
		,$id = null)
		{
			$this->id = $id;
			$this->userId= $userId;
			$this->challengeId = $challengeId;
			$this->owenershipCreation = $ownershipCreation;
			$this->submissionTime = $submissionTime;
			$this->status = $status;
			
			
			}
			function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setUserId($userId){
			$this -> userId = $userId;
		}
		function getUserId(){
				return $this-> userId;
				}
				
				function setChallengeId($challengeId){
			$this -> challengeId = $challengeId;
			function getChallengeId(){
				return $this->challengeId;
		}
			function setOwnershipCreation($ownershipCreation){
			$this -> ownershipCreation= $ownershipCreation;
		}
		function getOwnershipCreation(){
				return $this-> $ownershipCreation;
				}
				
				function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
		}
		function setSubmissionTime($submissionTime){
			$this -> submissionTime = $submissionTime;
		}
		function getSubmissionTime(){
				return $this->submissionTime;
		}


	
			function toString (){
			return $this -> id . ", " . $this ->userId.",".$this->challengeId.",".$this->ownershipCreation.".".$this->submissionTime.",".$this->status;}
			function toArray() {
			return array (
						
						
						
						
			id => $this->id,
			userId=>$this->userId,
			challengeId=> $this->challengeId,
			ownershipCreation => $this->ownershipCreation,
			submissionTime =>$this->submissionTime,
			
			status => $this->status
			
						);
					}

		

		
	}
		

	}
?>