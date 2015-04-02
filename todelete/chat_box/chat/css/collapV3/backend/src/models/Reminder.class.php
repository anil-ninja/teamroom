<?php
	/**
	 * Object represents table 'reminders'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-30 14:57	 
	 */
	class Reminder{
		
		private $id;
		private $userId;
		private $remindTo;
		private $message;
		private $displayOnTime;
		private $status;
		private $creationTime;
		
		function __construct ($userId, $remindTo, $message, $displayOnTime, $status, $creationTime, $id = null) {
			$this -> id = $id;
			$this -> userId = $userId;
			$this -> remindTo = $remindTo;
			$this -> message = $message;
			$this -> displayOnTime = $displayOnTime;
			$this -> status = $status;
			$this -> creationTime = $creationTime;
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

		function setRemindTo ($remindTo) {
			$this -> remindTo = $remindTo;
		}
		function getRemindTo () {
			return $this -> remindTo;
		}

		function setMessage ($message) {
			$this -> message = $message;
		}
		function getMessage () {
			return $this -> message;
		}

		function setDisplayOnTime ($displayOnTime) {
			$this -> displayOnTime = $displayOnTime;
		}
		function getDisplayOnTime () {
			return $this -> displayOnTime;
		}

		function setStatus ($status) {
			$this -> status = $status;
		}
		function getStatus () {
			return $this -> status;
		}

		function setCreationTime ($creationTime) {
			$this -> creationTime = $creationTime;
		}
		function getCreationTime () {
			return $this -> creationTime;
		}

		function toString() {
			return $this -> id . ", " . 
					$this -> userId.",".
					$this -> remindTo.",".
					$this -> message.",".
					$this -> displayOnTime.",".
					$this -> status . ", " . 
					$this -> creationTime;
		}

		function toArray() {
			return array (			
							id => $this-> id,
							userId => $this-> userId,
							remindTo => $this-> remindTo,
							message => $this-> message,
							displayOnTime => $this-> displayOnTime,
							status => $this-> status,
							creationTime => $this-> creationTime
						);
		}
	}
?>