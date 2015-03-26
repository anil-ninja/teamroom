<?php
	/**
	 * Object represents table 'chat'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Chat{
		
		private $id;
		private  $from;
		private  $to;
		private  $message;
		private  $time;
		private  $status;
		
		function function__construct( $from,$to,$message,$time,$status,$id = null)
		{
			$this-> id = id;
			$this-> from= from;
			$this-> to = to;
			$this-> message = message;
			$this-> time = time;
			$this-> status = status;
		}

		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this-> id;
		}

		function setFrom($from){
			$this -> from = $from;
		}
		function getFrom(){
			return $this-> from;
		}
				
		function setTime($time){
			$this -> time = $time;
		}
		function getTime(){
			return $this-> time;
		}

		function setMessage($message){
			$this -> message= $message;
		}
		function getMessage(){
			return $this-> message;
		}
			
		function setStatus($status){
			$this -> status = $status;
		}

		function getStatus(){
			return $this-> status;
		}

		function setTo($to){
			$this -> to = $to;
		}
		function getTo(){
			return $this-> to;
		}


	
		function toString (){
			return $this -> id . ", " . 
					$this -> from.",".
					$this-> to.",".
					$this-> message.".".
					$this-> time.",".
					$this-> status;
		}

		function toArray() {
			return array (
							id => $this-> id,
							from =>$this-> from,
							to => $this-> to,
							message => $this-> message,
							time =>$this-> time,
							status => $this-> status
						);
		}
	}
?>