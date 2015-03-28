<?php
/**
 * Class that operate on table 'challenges'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ChallengesMySqlExtDAO extends ChallengesMySqlDAO{

	public function loadUserChallenge($id, $userId){
		$sql = 'SELECT * FROM challenges WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllUserChallenges($userId){
		$sql = 'SELECT * FROM challenges WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		return $this->getList($sqlQuery);
	}
}
?>