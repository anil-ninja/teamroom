<?php
/**
 * Connection properties
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 9.12.2014
 */
class ConnectionProperty{

	/*private static $host = 'localhost';
	private static $user = 'capillary';
	private static $password = 'deal20hunt';
	private static $database = 'nucleus';*/

	public static function getHost(){
		/*return ConnectionProperty::$host;*/
		global $configs;
		return $configs ['mysql'] ['host'];
	}

	public static function getUser(){
		/*return ConnectionProperty::$user;*/
		global $configs;
		return $configs ['mysql'] ['user'];
	}

	public static function getPassword(){
		/*return ConnectionProperty::$password;*/
		global $configs; 
		return $configs ['mysql'] ['password'];
	}

	public static function getDatabase(){
		/*return ConnectionProperty::$database;*/
		global $configs; 
		return $configs ['mysql'] ['database'];
	}
}
?>