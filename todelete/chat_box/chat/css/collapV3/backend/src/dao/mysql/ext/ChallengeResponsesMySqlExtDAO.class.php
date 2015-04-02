<?php
/**
 * Class that operate on table 'challenge_responses'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ChallengeResponsesMySqlExtDAO extends ChallengeResponsesMySqlDAO{

	public function loadResponse($id, $challengeId) {
		$sql = 'SELECT * FROM challenge_responses WHERE id = ? AND challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($challengeId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllResponse($challengeId){
		$sql = 'SELECT * FROM challenge_responses WHERE challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($challengeId);
		return $this->getList($sqlQuery);
	}
	
}
?>