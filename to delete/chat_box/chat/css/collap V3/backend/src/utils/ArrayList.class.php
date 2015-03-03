<?php
/**
 * ArrayList
 *
 * @author: Rahul Lahoria
 * @date: 9/12/2014
 * Is used in transaction management system
 */
class ArrayList{
	private $tab;
	private $size;

	public function ArrayList(){
		$this->tab = array();
		$this->size=0;
	}

	public function add($value){
		$this->tab[$this->size] = $value;
		$this->size = ($this->size) +1;
	}

	public function get($idx){
		return $this->tab[$idx];
	}

	public function getLast(){
		if($this->size==0){
			return null;
		}
		return $this->tab[($this->size)-1];
	}

	public function size(){
		return $this->size;
	}

	public function isEmpty(){
		return ($this->size)==0;
	}

	public function removeLast(){
		return $this->size = ($this->size) -1;
	}
}
?>