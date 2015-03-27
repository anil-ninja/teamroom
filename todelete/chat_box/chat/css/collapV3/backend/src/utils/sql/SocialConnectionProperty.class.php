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
		//global $configs;
		//return $configs ['mysql']['social']['host'];
		return 'localhost';
	}

	public static function getUser(){
		/*return ConnectionProperty::$user;*/
		//global $configs;
		//return $configs ['mysql']['social']['user'];
		return 'root';
	}

	public static function getPassword(){
		/*return ConnectionProperty::$password;*/
		//global $configs; 
		//return $configs ['mysql']['social']['password'];
		return 'redhat11111p';
	}

	public static function getDatabase(){
		/*return ConnectionProperty::$database;*/
		//global $configs; 
		//return $configs ['mysql']['social']['database'];
		return 'social3';
	}
}
?>
