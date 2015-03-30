<?php
/**
 * Class that operate on table 'reminders'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-30 14:57
 */
class RemindersMySqlExtDAO extends RemindersMySqlDAO{

	public function loadReminder($id, $userId){
		$sql = 'SELECT * FROM reminders WHERE id = ? AND user_id = ? AND display_on_time > NOW()';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllReminders($userId){
		$sql = 'SELECT * FROM reminders WHERE user_id = ?  AND display_on_time > NOW()';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);	
		return $this->getList($sqlQuery);
	}

	public function deleteReminder($id){
		$sql = 'UPDATE reminders SET status = 2 WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
}
?>