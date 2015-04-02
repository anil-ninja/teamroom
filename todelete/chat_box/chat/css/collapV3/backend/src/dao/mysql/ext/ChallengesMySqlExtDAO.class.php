<?php
/**
 * Class that operate on table 'challenges'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ChallengesMySqlExtDAO extends ChallengesMySqlDAO{

	/**
	 * Get user challenge records from table
	 */
	public function loadUserChallenge($id, $userId){
		$sql = 'SELECT * FROM challenges WHERE id = ? AND user_id = ? AND status != 3 AND status != 7';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($userId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all user challenges records from table
	 */
	public function queryAllUserChallenges($userId){
		$sql = 'SELECT * FROM challenges WHERE user_id = ? AND status != 3 AND status != 7';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		return $this->getList($sqlQuery);
	}


	/**
	 * Get project challenge records from table
	 */
	public function loadProjectChallenge($id, $projectId){
		$sql = 'SELECT * FROM challenges WHERE id = ? AND project_id = ? AND status != 3 AND status != 7';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($projectId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all project challenges records from table
	 */
	public function queryAllProjectChallenges($projectId){
		$sql = 'SELECT * FROM challenges WHERE project_id = ? AND status != 3 AND status != 7';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($projectId);
		return $this->getList($sqlQuery);
	}

	public function deleteChallenge($challengeId){
		$sql = 'UPDATE challenges SET status = 5 WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($challengeId);
		return $this->executeUpdate($sqlQuery);
	}
}
?>