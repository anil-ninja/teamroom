<?php
	/**
	 * Object represents table 'known_peoples'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class KnownPeople{
		
		private $id;
		private $requestingId;
		private $knowingId;
		private $status;
		private $requestingTime;
		private $lastActionTime;
		private $firstName;
		private $lastName;
		private $userName;
		private $rank;

		function __construct($requestingId, $knowingId, $status, $lastActionTime, $requestingTime, $firstName, $lastName, $userName, $rank, $id = null) {
			$this -> id = $id;
			$this -> requestingId= $requestingId;
			$this -> knowingId= $knowingId;
			$this -> requestingTime = $requestingTime;
			$this -> lastActionTime = $lastActionTime;
			$this -> status = $status;
			$this -> firstName = $firstName;
			$this -> lastName = $lastName;
			$this -> userName = $userName;
			$this -> rank = $rank;
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this -> id;
		}

		function setRequsetingId($requestingId){
			$this -> requestingId = $requestingId;
		}
		function getRequestingId(){
			return $this-> requestingId;
		}
				
		function setKnowingId($knowingId){
			$this -> knowingId = $knowingId;
		}
		function getKnowingId(){
			return $this-> knowingId;
		}

		function setRequsetingTime($requestingTime){
			$this -> requestingTime= $requestingTime;
		}
		function getRequsetingTime(){
			return $this-> requestingTime;
		}
				
		function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
			return $this-> status;
		}

		function setLastActionTime($lastActionTime){
			$this -> lastActionTime= $lastActionTime;
		}
		function getLastActionTime(){
			return $this -> lastActionTime;
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

		function setRank($rank){
			$this -> rank = $rank;
		}
		function getRank(){
				return $this-> rank;
		}
		function toString (){
			return $this -> id . ", " . 
					$this -> requestingId.",".
					$this -> lastActionTime.",".
					$this -> requestingTime.".".
					$this -> knowingId.",".
					$this -> status.",".
					$this -> firstName.",".
					$this -> lastName.",".
					$this -> userName.",".
					$this -> rank;
		}
		
		function toArray() {
			return array (
							id => $this-> id,
							requestingId=>$this-> requestingId,
							requestingTime=> $this-> requestingTime,
							knowingId => $this-> knowingId,
							lastActionTime =>$this-> lastActionTime,
							status => $this-> status,
							firstName => $this-> firstName,
							lastName => $this-> lastName,
							userName => $this-> userName,
							rank => $this-> rank
						);
		}

		function toArrayLinks() {
			return array (
							firstName => $this-> firstName,
							lastName => $this-> lastName,
							userName => $this-> userName,
							rank => $this-> rank
						);
		}
	}
?>
