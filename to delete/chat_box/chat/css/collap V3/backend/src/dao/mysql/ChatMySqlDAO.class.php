<?php
/**
 * Class that operate on table 'chat'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ChatMySqlDAO implements ChatDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ChatMySql 
	 */
	public function load($id, $userId){
		$sql = 'SELECT * FROM chat WHERE id = ? AND `to` = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> setNumber($id);
		$sqlQuery -> setNumber($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll($userId){
		$sql = 'SELECT * FROM chat WHERE `to` = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> setNumber($userId);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM chat ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param chat primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM chat WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ChatMySql chat
 	 */
	public function insert($chat){
		$sql = 'INSERT INTO chat (`from`, `to`, `message`) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		//print_r($chat); exit;
		$sqlQuery -> set($chat-> getFrom());
		$sqlQuery -> set($chat-> getTo());
		$sqlQuery -> set($chat-> getMessage());
		//$sqlQuery->set($chat->getTime());
		//$sqlQuery->set($chat->getStatus());

		$id = $this->executeInsert($sqlQuery);	
		$chat -> setId($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ChatMySql chat
 	 */
	public function update($chat){
		$sql = 'UPDATE chat SET from = ?, to = ?, message = ?, time = ?, status = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($chat->from);
		$sqlQuery->setNumber($chat->to);
		$sqlQuery->set($chat->message);
		$sqlQuery->set($chat->time);
		$sqlQuery->setNumber($chat->status);

		$sqlQuery->setNumber($chat->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM chat';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByFrom($value){
		$sql = 'SELECT * FROM chat WHERE from = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTo($value){
		$sql = 'SELECT * FROM chat WHERE to = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMessage($value){
		$sql = 'SELECT * FROM chat WHERE message = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTime($value){
		$sql = 'SELECT * FROM chat WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM chat WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByFrom($value){
		$sql = 'DELETE FROM chat WHERE from = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTo($value){
		$sql = 'DELETE FROM chat WHERE to = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMessage($value){
		$sql = 'DELETE FROM chat WHERE message = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTime($value){
		$sql = 'DELETE FROM chat WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM chat WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ChatMySql 
	 */
	protected function readRow($row){
		$chat = new Chat($row['from'], $row['to'], $row['message'], $row['time'], $row['status'], $row['id']);

		return $chat;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return ChatMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>
