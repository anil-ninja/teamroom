<?php
	/**
	 * Object represents table 'teams'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Team{
		
		private $id;
		private $userId;
		private $projectId;
		private $teamName;
		private $teamOwner;
		private $teamCreation;
		private $memberStatus;
		private $leaveTeam;
		private $status;
	
		function __construct ($userId, $projectId, $teamName, $teamOwner, $teamCreation, $memberStatus, $leaveTeam, $status, $id = null) {
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> projectId = $projectId;
			$this -> teamName = $teamName;
			$this -> teamOwner = $teamOwner;
			$this -> teamCreation = $teamCreation;
			$this -> memberStatus = $memberStatus;
			$this -> leaveTeam = $leaveTeam;
			$this -> status = $status;
		}	

		function setId ($id) {
			$this -> id = $id;
		}
		function getId () {
			return $this -> id;
		}

		function setUserId ($userId) {
			$this -> userId = $userId;
		}
		function getUserId () {
			return $this -> userId;
		}

		function setProjectId ($projectId) {
			$this -> projectId = $projectId;
		}
		function getProjectId () {
			return $this -> projectId;
		}

		function setTeamName ($teamName) {
			$this -> teamName = $teamName;
		}
		function getTeamName () {
			return $this -> teamName;
		}

		function setTeamOwner ($teamOwner) {
			$this -> teamOwner = $teamOwner;
		}
		function getTeamOwner () {
			return $this -> teamOwner;
		}

		function setTeamCreation ($teamCreation) {
			$this -> teamCreation = $teamCreation;
		}
		function getTeamCreation () {
			return $this -> teamCreation;
		}

		function setMemberStatus ($memberStatus) {
			$this -> memberStatus = $memberStatus;
		}
		function getMemberStatus () {
			return $this -> memberStatus;
		}

		function setLeaveTeam ($leaveTeam) {
			$this -> leaveTeam = $leaveTeam;
		}
		function getLeaveTeam () {
			return $this -> leaveTeam;
		}

		function setStatus ($status) {
			$this -> status = $status;
		}
		function getStatus () {
			return $this -> status;
		}

		function toString() {
			return $this -> id . ", " . 
					$this -> userId.",".
					$this -> projectId.",".
					$this -> teamName.",".
					$this -> teamOwner . ", " . 
					$this -> teamCreation.",".
					$this -> memberStatus.",".
					$this -> leaveTeam. ", " . 
					$this -> status;
		}

		function toArray() {
			return array (			
							id => $this-> id,
							userId => $this-> userId,
							projectId => $this-> projectId,
							teamName => $this-> teamName,
							teamOwner => $this-> teamOwner,
							teamCreation => $this-> teamCreation,
							memberStatus => $this-> memberStatus,
							leaveTeam => $this-> leaveTeam,
							status => $this-> status
						);
		}
	}
?>