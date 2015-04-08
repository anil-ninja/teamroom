<?php
	/**
	 * Object represents table 'teams'
	 *
     	 * @author: rajnish
     	 * @date: 2015-03-03 14:48	 
	 */
	class TeamMembers{
		
		//private $id;
		//private $userId;
		private $firstName;
		private $lastName;
		private $userName;
		private $rank;

		function __construct ($firstName, $lastName, $rank, $userName) {
			//$this -> id = $id;
			//$this -> userId = $userId;
			$this -> firstName = $firstName;
			$this -> lastName = $lastName;
			$this -> rank = $rank;
			$this -> userName = $userName;
		}
/*		function setId ($id) {
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
*/
		function setFirstName ($firstName) {
			$this -> firstName = $firstName;
		}
		function getFirstName () {
			return $this -> firstName;
		}

		function setLastName ($lastName) {
			$this -> lastName = $lastName;
		}
		function getLastName () {
			return $this -> lastName;
		}

		function setRank ($rank) {
			$this -> rank = $rank;
		}
		function getRank () {
			return $this -> rank;
		}

		function setUserName ($userName) {
			$this -> userName = $userName;
		}
		function getUserName () {
			return $this -> userName;
		}

		function toString() {
			return $this -> firstName.",".
					$this -> lastName. ", " . 
					$this -> rank. ", " . 
					$this -> userName;
		}

		function toArray() {
			return array (			
							firstName => $this-> firstName,
							lastName => $this-> lastName,
							rank => $this -> rank,
							userName => $this-> userName
						);
		}
	}
?>