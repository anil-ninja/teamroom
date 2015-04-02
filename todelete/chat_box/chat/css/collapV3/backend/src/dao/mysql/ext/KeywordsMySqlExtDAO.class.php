<?php
/**
 * Class that operate on table 'keywords'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class KeywordsMySqlExtDAO extends KeywordsMySqlDAO{

	public function loadChallengeKeywords($challengeId){
		$sql = 'SELECT * FROM keywords WHERE u_p_c_id = ? AND type = 3';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($challengeId);
		return $this->getList($sqlQuery);
	}

	public function queryAllChallengeKeyword(){
		$sql = 'SELECT * FROM keywords WHERE type = 3';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}

	public function loadProjectKeywords($projectId){
		$sql = 'SELECT * FROM keywords WHERE u_p_c_id = ? AND type = 2';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($projectId);
		return $this->getList($sqlQuery);
	}

	public function queryAllProjectKeyword(){
		$sql = 'SELECT * FROM keywords WHERE type = 2';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
}
?>