<?php
/**
 * Object represents connection to database
 *
 * @author: Rahul Lahoria
 * @date: 9.12.2014
 */
class Connection{
	private $connection;

	public function Connection(){
		$this->connection = ConnectionFactory::getConnection();
	}

	public function close(){
		ConnectionFactory::close($this->connection);
	}

	/**
	 *
	 * @param sql query as string
	 * @return query response
	 */
	public function executeQuery($sql){
		return mysql_query($sql, $this->connection);
	}
}
?>