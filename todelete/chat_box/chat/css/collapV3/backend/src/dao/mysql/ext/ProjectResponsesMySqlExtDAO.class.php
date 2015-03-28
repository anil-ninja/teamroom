<?php
/**
 * Class that operate on table 'project_responses'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ProjectResponsesMySqlExtDAO extends ProjectResponsesMySqlDAO{

	public function loadResponse($id, $projectId){
		$sql = 'SELECT * FROM project_responses WHERE id = ? AND project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($projectId);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllResponse($projectId){
		$sql = 'SELECT * FROM project_responses WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($projectId);
		return $this->getList($sqlQuery);
	}
	
}
?>