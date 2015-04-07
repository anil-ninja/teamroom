<?php
	/**
	 * Object represents table 'projects'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Project{
		
		private $id;
		private $userId;
		private $blobId;
		private $projectTitle;
		private $stmt;
		private $type;
		private $orgId;
		private $order;
		private $creationTime;
		private $projectValue;
		private $fundNeeded;
		private $lastUpdateTime;
		private $firstName;
		private $lastName;
		private $userName;

	
		function __construct ($userId, $blobId, $projectTitle, $stmt, $type, $orgId, $order, $creationTime, $projectValue, $fundNeeded, $lastUpdateTime, $firstName, $lastName, $userName, $id = null) {
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> blobId = $blobId;
			$this -> projectTitle = $projectTitle;
			$this -> stmt = $stmt;
			$this -> type = $type;
			$this -> orgId = $orgId;
			$this -> order = $order;
			$this -> creationTime = $creationTime;
			$this -> projectValue = $projectValue;
			$this -> fundNeeded = $fundNeeded;
			$this -> lastUpdateTime = $lastUpdateTime;
			$this -> firstName = $firstName;
			$this -> lastName = $lastName;
			$this -> userName = $userName;
		}

		function setId ($id) {
			$this -> id = $id;
		}
		function getId () {
			return $this -> id;
		}

		function setBlobId ($blobId) {
			$this -> blobId = $blobId;
		}
		function getBlobId () {
			return $this -> blobId;
		}

		function setUserId ($userId) {
			$this -> userId = $userId;
		}
		function getUserId () {
			return $this -> userId;
		}

		function setProjectTitle ($projectTitle) {
			$this -> projectTitle = $projectTitle;
		}
		function getProjectTitle () {
			return $this -> projectTitle;
		}

		function setStmt ($stmt) {
			$this -> stmt = $stmt;
		}
		function getStmt () {
			return $this -> stmt;
		}

		function setType ($type) {
			$this -> type = $type;
		}
		function getType () {
			return $this -> type;
		}

		function setOrgId ($orgId) {
			$this -> orgId = $orgId;
		}
		function getOrgId () {
			return $this -> orgId;
		}

		function setOrder ($order) {
			$this -> order = $order;
		}
		function getOrder () {
			return $this -> order;
		}

		function setCreationTime ($creationTime) {
			$this -> creationTime = $creationTime;
		}
		function getCreationTime () {
			return $this -> creationTime;
		}

		function setProjectValue ($projectValue) {
			$this -> projectValue = $projectValue;
		}
		function getProjectValue () {
			return $this -> projectValue;
		}

		function setLastUpdateTime ($lastUpdateTime) {
			$this -> lastUpdateTime = $lastUpdateTime;
		}
		function getLastUpdateTime () {
			return $this -> lastUpdateTime;
		}

		function setFundNeeded ($fundNeeded) {
			$this -> fundNeeded = $fundNeeded;
		}
		function getFundNeeded () {
			return $this -> fundNeeded;
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

		function toString() {
			return $this -> id . ", " . 
					$this -> userId.",".
					$this -> blobId.",".
					$this -> projectTitle.",".
					$this -> stmt.",".
					$this -> type . ", " . 
					$this -> orgId.",".
					$this -> order.",".
					$this -> creationTime.".".
					$this -> projectValue. ", " . 
					$this -> fundNeeded.",".
					$this -> lastUpdateTime.",".
					$this -> firstName.",".
					$this -> lastName.",".
					$this -> userName;
		}

		function toArray() {
			return array (			
							id => $this-> id,
							userId => $this-> userId,
							blobId => $this-> blobId,
							projectTitle => $this-> projectTitle,
							stmt => $this-> stmt,
							type => $this-> type,
							orgId => $this-> orgId,
							order => $this-> order,
							creationTime => $this-> creationTime,
							projectValue => $this-> projectValue,
							fundNeeded => $this-> fundNeeded,
							lastUpdateTime => $this-> lastUpdateTime,
							firstName => $this-> firstName,
							lastName => $this-> lastName,
							userName => $this-> userName
						);
		}

		function toArrayUserProjects() {
			return array (			
							id => $this-> id,
							projectTitle => $this-> projectTitle,
							stmt => $this-> stmt,
							type => $this-> type,
							creationTime => $this-> creationTime,
							firstName => $this-> firstName,
							lastName => $this-> lastName,
							userName => $this-> userName
						);
		}
	}
?>