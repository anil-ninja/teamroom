<?php
	/**
	 * Object represents table 'keywords'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class Keyword{
		
		private $id;
		private $uPCId;
		private $type;
		private $words;
		private $relevence;
		private $time;
		function __construct($uPCId, $type, $words, $relevence, $time, $id = null) {
			$this -> id = $id;
			$this -> uPCId= $uPCId;
			$this -> type= $type;
			$this -> words = $words;
			$this -> relevence = $relevence;
			$this -> time = $time;
		}
		
		function setId($id){
			$this -> id = $id;
		}
		function getId(){
			return $this -> id;
		}

		function setUPCId($uPCId){
			$this -> uPCId = $uPCId;
		}
		function getUPCId(){
			return $this -> uPCId;
		}
				
		function setType($type){
 			$this -> type = $type;
 		}	
		function getType(){
			return $this -> type;
		}

		function setWords($words){
			$this -> words= $words;
		}
		function getWords(){
			return $this-> words;
		}
				
		function setRelevence($relevence){
			$this -> relevence = $relevence;
		}
		function getRelevence(){
			return $this -> relevence;
		}

		function setTime($time){
 			$this -> time = $time;
 		}
		function getTime(){
			return $this -> time;
		}
		

		function toString (){
			return $this -> id . ", " . 
					$this -> uPCId.",".
					$this -> relevence.",".
					$this -> words.".".
					$this -> type.",".
					$this -> time;
		}

		function toArray() {
			return array (
						id => $this-> id,
						uPCId=>$this-> uPCId,
						relevence=> $this-> relevence,
						words => $this-> words,
						type =>$this-> type,
						time =>$this-> time
					);
		}
	}
?>
