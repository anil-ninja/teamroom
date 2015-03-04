<?php
	/**
	 * Object represents table 'notifications'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Notification{
		
		private $id;
		private $noticeUrl;
		private $userId;
		private $time;
		function __construct($noticeUrl,$userId,$time,$id = null)
		
		{$this->id = $id;

		$this ->noticeUrl = $noticeUrl;

		$this ->userId = $userId;

		$this ->time = $time;
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
				
				function setTime($time){
			$this -> time = $time;
			function getTime(){
				return $this->time;
		}
			function setNoticelUrl($noticelUr){
			$this -> NoticelUr = $noticelUr;
		}
		function getNoticelUr(){
				return $this-> noticelUr;
				
		}
		function toString (){
			return $this -> id . ", " . $this ->userId.",".$this->time.",".$this->noticeUrl;}
			function toArray() {
			return array (
						id => $this->id,
						userId => $this->userId,
						time => $this->time,
						noticeUrlurl => $this->noticeUrlurl
						
						);

			
	
	}
?>
