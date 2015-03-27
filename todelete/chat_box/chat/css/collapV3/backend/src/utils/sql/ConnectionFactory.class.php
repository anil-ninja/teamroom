<?php
/**
 * Class return connection to database
 *
 * @author: Rahul Lahoria
 * @date: 9.12.2014
 */

require_once 'exceptions/MySqlDbException.class.php';

class ConnectionFactory{
	
	/**
	 *
	 * @return sql Handle
	 */
	static public function getConnection(){
		$conn = mysql_connect(ConnectionProperty::getHost(), ConnectionProperty::getUser(), ConnectionProperty::getPassword());
		mysql_select_db(ConnectionProperty::getDatabase());
		if(!$conn){
			//throw new Exception('could not connect to database');
			throw new MySqlDbException(mysql_errno(), mysql_error());
		}
		return $conn;
	}

	/**
	 *
	 * @param Close the sql connection
	 */
	static public function close($connection){
		mysql_close($connection);
	}
}
?>