<?php
/**
 * Class that operate on table 'notifications'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class NotificationsMySqlDAO implements NotificationsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return NotificationsMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM notifications WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM notifications';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM notifications ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param notification primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM notifications WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param NotificationsMySql notification
 	 */
	public function insert($notification){
		$sql = 'INSERT INTO notifications (notice_url, user_id, time) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($notification->noticeUrl);
		$sqlQuery->setNumber($notification->userId);
		$sqlQuery->set($notification->time);

		$id = $this->executeInsert($sqlQuery);	
		$notification->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param NotificationsMySql notification
 	 */
	public function update($notification){
		$sql = 'UPDATE notifications SET notice_url = ?, user_id = ?, time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($notification->noticeUrl);
		$sqlQuery->setNumber($notification->userId);
		$sqlQuery->set($notification->time);

		$sqlQuery->setNumber($notification->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM notifications';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNoticeUrl($value){
		$sql = 'SELECT * FROM notifications WHERE notice_url = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM notifications WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTime($value){
		$sql = 'SELECT * FROM notifications WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByNoticeUrl($value){
		$sql = 'DELETE FROM notifications WHERE notice_url = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUserId($value){
		$sql = 'DELETE FROM notifications WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTime($value){
		$sql = 'DELETE FROM notifications WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return NotificationsMySql 
	 */
	protected function readRow($row){
		$notification = new Notification();
		
		$notification->id = $row['id'];
		$notification->noticeUrl = $row['notice_url'];
		$notification->userId = $row['user_id'];
		$notification->time = $row['time'];

		return $notification;
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
	 * @return NotificationsMySql 
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