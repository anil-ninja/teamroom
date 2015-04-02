<?php
/**
 * Class that operate on table 'projects'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ProjectsMySqlExtDAO extends ProjectsMySqlDAO{

	public function loadProject($projectId, $userId){
		$sql = 'SELECT * FROM projects WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		$sqlQuery->setNumber($projectId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllProjects($userId){
		$sql = 'SELECT * FROM projects WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		return $this->getList($sqlQuery);
	}
}
?>