<?php
	/**
	 * Object represents table 'skills'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Skill{
		
		private $id;
		private $name;

		function __construct($name, $id = null) {
			$this -> id = $id;
			$this -> name = $name;
		}

		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this->id;
		}

		function setName($name){
			$this -> name = $name;
		}
		function getName(){
			return $this-> name;
		}

		function toString (){
			return $this -> id . ", " .
					$this -> name;
		}
		
		function toArray() {
			return array (
						id => $this -> id,
						name => $this -> name
				);
		}
	}
?>