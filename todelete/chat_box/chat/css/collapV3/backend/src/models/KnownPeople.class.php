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

		function __construct($requestingId, $knowingId, $status, $lastActionTime, $requestingTime, $id = null) {
			$this -> id = $id;
			$this -> requestingId= $requestingId;
			$this -> knowingId= $knowingId;
			$this -> requestingTime = $requestingTime;
			$this -> lastActionTime = $lastActionTime;
			$this -> status = $status;
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

		function toString (){
			return $this -> id . ", " . 
					$this -> requestingId.",".
					$this -> lastActionTime.",".
					$this -> requestingTime.".".
					$this -> knowingId.",".
					$this -> status;
		}
		
		function toArray() {
			return array (
							id => $this-> id,
							requestingId=>$this-> requestingId,
							requestingTime=> $this-> requestingTime,
							knowingId => $this-> knowingId,
							lastActionTime =>$this-> lastActionTime,
							status => $this-> status
						);
		}
	}
?>
