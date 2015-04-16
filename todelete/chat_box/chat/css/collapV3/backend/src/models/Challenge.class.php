<?php
	/**
	 * Object represents table 'challenges'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Challenge {
		
		private $id;
		private $userId;
		private $projectId;
		private $blobId;
		private $orgId;
		private $title;
		private $stmt;
		private $type;
		private $status;
		private $likes;
		private $dislikes;
		private $creationTime;
		private $lastUpdateTime;
		private $firstName;
		private $lastName;
		private $userName;
		
		function __construct( $userId, $projectId, $blobId, $orgId, $title, $stmt, $type, $status, $likes
		,$dislikes, $creationTime, $lastUpdateTime, $firstName, $lastName, $userName, $id = null)
		{
			$this -> id = $id;
			$this -> userId= $userId;
			$this -> projectId = $projectId;
			$this -> blobId = $blobId;
			$this -> orgId = $orgId;
			$this -> title = $title;
			$this -> stmt = $stmt;
			$this -> type= $type;
			$this -> status = $status;
			$this -> likes = $likes;
			$this -> dislikes = $dislikes;
			$this -> creationTime = $creationTime;
			$this -> lastUpdateTime=$lastUpdateTime;
			$this -> firstName = $firstName;
			$this -> lastName = $lastName;
			$this -> userName = $userName;
		}
	
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this-> id;
		}

		function setUserID($userId){
			$this -> userId = $userId;
		}
		function getUserId(){
			return $this-> userId;
		}
			
		function setProjectId($projectId){
			$this -> projectId = $projectId;
		}
		function getProjectId(){
			return $this-> projectId;
		}

		function setBlobId($blobId){
			$this -> blobId = $blobId;
		}
		function getBlobId(){
			return $this-> blobId;
		}
			
		function setTitle ($title) {
			$this -> title = $title;
		}
		function getTitle () {
			return $this -> title;
		}

		function setStmt($stmt){
			$this -> stmt = $stmt;
		}
		function getStmt(){
				return $this-> stmt;
		}
		function setLikes($likes){
			$this -> likes = $likes;
		}
		function getLikes(){
				return $this-> likes;
		}

		function setDislikes($dislikes){
			$this -> dislikes = $dislikes;
		}
		function getDislikes(){
				return $this-> dislikes;
		}
			
		function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
			return $this->status;
		}
		
		function setCreationtime($creationTime){
			$this -> $creationTime = $creationTime;
		}
		function getCreationtime(){
			return $this-> creationTime;
		}
				
		function setOrgId($orgId){
			$this -> orgId =$orgId;
		}
		function getOrgId(){
			return $this-> orgId;
		}
		
		function setLastUpdateTime($lastUpdateTime){
			$this -> lastUpdateTime = $lastUpdateTime;
		}
		function getLastUpdateTime(){
				return $this-> lastUpdateTime;
		}

		function setType($type){
			$this -> type= $type;
		}
		function getType(){
			return $this-> type;		
		}

		function setFirstName($firstName){
			$this -> firstName = $firstName;
		}
		function getFirstName(){
			return $this-> firstName;
		}
		
		function setLastName($lastName){
			$this -> lastName = $lastName;
		}
		function getLastName(){
				return $this->lastName;
		}

		function setUsername($username){
			$this -> username = $username;
		}
		function getUsername(){
				return $this-> username;
		}

		function toString (){
			return $this -> id . ", " . 
					$this -> userId.",".
					$this -> projectId.",".
					$this -> blobId.",".
					$this -> orgId.",".
					$this -> title . ", " . 
					$this -> likes.",".
					$this -> dislikes.",".
					$this -> status.".".
					$this -> creationTime. ", " . 
					$this -> stmt.",".
					$this -> lastUpdateTime.",".
					$this -> type.",".
					$this -> firstName.",".
					$this -> lastName.",".
					$this -> userName;
		}

		function toArray() {
			return array (			
							id => $this-> id,
							userId => $this-> userId,
							projectId => $this-> projectId,
							blobId => $this-> blobId,
							orgId => $this-> orgId,
							title => $this-> title,
							stmt => $this-> stmt,
							type => $this-> type,
							status => $this-> status,
							likes => $this-> likes,
							dislikes => $this-> dislikes,
							creationTime => $this-> creationTime,
							lastUpdateTime => $this-> lastUpdateTime
						);
		}

		function toArrayUserChallenges() {
			return array (			
							id => $this-> id,
							projectId => $this-> projectId,
							title => $this-> title,
							stmt => $this-> stmt,
							type => $this-> type,
							status => $this-> status,
							likes => $this-> likes,
							dislikes => $this-> dislikes,
							creationTime => $this-> creationTime,
							firstName => $this-> firstName,
							lastName => $this-> lastName,
							userName => $this-> userName
						);
		}

		function toArrayTeamDashboard() {
			return array (			
							id => $this-> id,
							title => $this-> title,
							type => $this-> type,
							status => $this-> status,
							creationTime => $this-> creationTime,
							firstName => $this-> firstName,
							lastName => $this-> lastName,
							userName => $this-> userName
						);
		}		
	}
?>
