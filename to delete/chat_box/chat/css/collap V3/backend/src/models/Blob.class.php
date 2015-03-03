<?php
	/**
	 * Object represents table 'blobs'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Blob{
		
		private $id;
		private $stmt;
		
		function __construct($stmt, $id = null){
			$this->id = $id;
			$this->stmt = $stmt;
			
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setStmt($stmt){
			$this -> stmt = $stmt;
		}
		function getStmt(){
				return $this-> stmt;
		}
		
		function toString (){
			return $this -> id . ", " . $this -> stmt;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						stmt => $this->stmt
				);
		}		
	}
?>
