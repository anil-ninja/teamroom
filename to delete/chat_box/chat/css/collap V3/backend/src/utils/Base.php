<?php
class Base {

	private $id;
	//var $name;
	static function CreateID(){
		static $Sid = 0;
		return ($Sid++);
	}
	function __construct() {
		$this->id = Table::CreateID();
		//$this->name = "widget".$this->id;
	}
	
	function __call($function, $args) {
		global $logger;
		$logger->error("Calling non-existent function $function with arguments: ".print_r($args, true));
		$logger->printLog();
		if (php_sapi_name() != "cli") {
			die("");
		}
	}
}
?>
