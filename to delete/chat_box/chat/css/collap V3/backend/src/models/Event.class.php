<?php
	/**
	 * Object represents table 'events'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Event{
		
		private $id;
		private $eventCreater;
		private $eventType;
		private $pCId;
		private $time;
		function __construct( $eventCreater,$eventType,$pCId,$time,$id = null)
		{$this->id = $id;
			
			$this->eventCreater = $eventCreater;
			$this->eventType = $eventType;
			$this->time = $time;
			$this->pCId=$pCId;
			
			}
			function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setEventCreater($eventCreater){
			$this -> eventCreater = $eventCreater;
		}
		function getEventCreater(){
				return $this-> eventCreater;
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
			
				
				function setTime($time){
			$this -> time = $time;
		}
		function getTime(){
				return $this->time;
		}
		function toString (){
			return $this -> id . ", " . $this ->eventCreater.",".$this->eventType.",".$this->time.".".$this->pCId;}
			function toArray() {
			return array (
						id => $this->id,
						eventCreater => $this->eventCreater,
						eventType => $this->eventType,
						time => $this->time,
						pCId => $this->pCId
						);
					}
			

		
		
	}
?>
