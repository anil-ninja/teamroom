<?php
/**
 * Class that operate on table 'reminders'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-30 14:57
 */
class RemindersMySqlDAO implements RemindersDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return RemindersMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM reminders WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM reminders';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM reminders ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param reminder primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM reminders WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param RemindersMySql reminder
 	 */
	public function insert($reminder){
		$sql = 'INSERT INTO reminders (user_id, remind_to, message, display_on_time, status, creation_time) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($reminder->getUserId());
		$sqlQuery->setNumber($reminder->getRemindTo());
		$sqlQuery->set($reminder->getMessage());
		$sqlQuery->set($reminder->getDisplayOnTime());
		$sqlQuery->setNumber($reminder->getStatus());
		$sqlQuery->set($reminder->getCreationTime());

		$id = $this->executeInsert($sqlQuery);	
		$reminder-> setId($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param RemindersMySql reminder
 	 */
	public function update($reminder){
		$sql = 'UPDATE reminders SET user_id = ?, remind_to = ?, message = ?, display_on_time = ?, status = ?, creation_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($reminder->userId);
		$sqlQuery->setNumber($reminder->remindTo);
		$sqlQuery->set($reminder->message);
		$sqlQuery->set($reminder->displayOnTime);
		$sqlQuery->setNumber($reminder->status);
		$sqlQuery->set($reminder->creationTime);

		$sqlQuery->setNumber($reminder->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM reminders';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM reminders WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRemindTo($value){
		$sql = 'SELECT * FROM reminders WHERE remind_to = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMessage($value){
		$sql = 'SELECT * FROM reminders WHERE message = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDisplayOnTime($value){
		$sql = 'SELECT * FROM reminders WHERE display_on_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM reminders WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreationTime($value){
		$sql = 'SELECT * FROM reminders WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM reminders WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRemindTo($value){
		$sql = 'DELETE FROM reminders WHERE remind_to = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMessage($value){
		$sql = 'DELETE FROM reminders WHERE message = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDisplayOnTime($value){
		$sql = 'DELETE FROM reminders WHERE display_on_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM reminders WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreationTime($value){
		$sql = 'DELETE FROM reminders WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return RemindersMySql 
	 */
	protected function readRow($row){
		$reminder = new Reminder();
		
		/*$reminder->id = $row['id'];
		$reminder->userId = $row['user_id'];
		$reminder->remindTo = $row['remind_to'];
		$reminder->message = $row['message'];
		$reminder->displayOnTime = $row['display_on_time'];
		$reminder->status = $row['status'];
		$reminder->creationTime = $row['creation_time'];
*/
		$reminder = new Reminder($row['user_id'], $row['remind_to'],$row['message'], $row['display_on_time'],$row['status'],$row['creation_time'], $row['id']);
		
		return $reminder;
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
	 * @return RemindersMySql 
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