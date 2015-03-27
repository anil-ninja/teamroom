<?php
	/**
	 * Object represents table 'involve_in'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class InvolveIn{
		
		private $id;
		private $userId;
		private $pCId;
		private $eventType;
		function __construct( $userId,$eventType,$pCId,$id = null)
		{$this->id = $id;
			
			$this->userId = $userId;
			$this->eventType = $eventType;
			
			$this->pCId=$pCId;
			
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
				function setEventType($eventType){
					$this->eventType=$eventType;
					function getEventCreater(){
						return$this->eventType;}
				function setPCId($pCId){
			$this -> pCId = $pCId;
		}
		function getpCId(){
				return $this->pCId;
		}
			
				
				
		function toString (){
			return $this -> id . ", " . $this ->userId.",".$this->pCId.",".$this->eventType;}
			function toArray() {
			return array (
						id => $this->id,
						userId => $this->userId,
						pCId => $this->pCId,
						eventType => $this->eventType
						
						);
					}
			

		
		
	}
?>
