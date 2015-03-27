<?php
	/**
	 * Object represents table 'targets'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Target{
		
		private $id;
		private $email;
		private $status;
		private $type;
		private $time;
		function __construct($email,$status,$time,$type,$id = null)
		{
			$this->id = $id;

		$this ->email = $email;

		$this ->type= $type;

		$this ->time = $time;
		$this->status=$status;
		}function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setEmail($email){
			$this -> email = $email;
		}
		function getEmail(){
				return $this-> email;
				}
				
				function setTime($time){
			$this -> time = $time;
			function getTime(){
				return $this->time;
		}
			function setType($type){
			$this -> type = $type;
		}
		function getType(){
				return $this-> type;
				function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
				
		}
		function toString (){
			return $this -> id . ", " . $this ->status.",".$this->email.",".$this->type.",".$this->time;}
			function toArray() {
			return array (
						id => $this->id,
						email => $this->email,
						time => $this->time,
						status => $this->status,
						type=>$this->type
						
						);

			
}
		
	}
?>
