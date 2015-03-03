<?php
/**
 * Class that operate on table 'project_responses'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ProjectResponsesMySqlDAO implements ProjectResponsesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ProjectResponsesMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM project_responses WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM project_responses';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM project_responses ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param projectResponse primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM project_responses WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ProjectResponsesMySql projectResponse
 	 */
	public function insert($projectResponse){
		$sql = 'INSERT INTO project_responses (user_id, project_id, status, stmt, creation_time) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($projectResponse->userId);
		$sqlQuery->setNumber($projectResponse->projectId);
		$sqlQuery->setNumber($projectResponse->status);
		$sqlQuery->set($projectResponse->stmt);
		$sqlQuery->set($projectResponse->creationTime);

		$id = $this->executeInsert($sqlQuery);	
		$projectResponse->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ProjectResponsesMySql projectResponse
 	 */
	public function update($projectResponse){
		$sql = 'UPDATE project_responses SET user_id = ?, project_id = ?, status = ?, stmt = ?, creation_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($projectResponse->userId);
		$sqlQuery->setNumber($projectResponse->projectId);
		$sqlQuery->setNumber($projectResponse->status);
		$sqlQuery->set($projectResponse->stmt);
		$sqlQuery->set($projectResponse->creationTime);

		$sqlQuery->setNumber($projectResponse->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM project_responses';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM project_responses WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProjectId($value){
		$sql = 'SELECT * FROM project_responses WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM project_responses WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStmt($value){
		$sql = 'SELECT * FROM project_responses WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreationTime($value){
		$sql = 'SELECT * FROM project_responses WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM project_responses WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProjectId($value){
		$sql = 'DELETE FROM project_responses WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM project_responses WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStmt($value){
		$sql = 'DELETE FROM project_responses WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreationTime($value){
		$sql = 'DELETE FROM project_responses WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ProjectResponsesMySql 
	 */
	protected function readRow($row){
		$projectResponse = new ProjectResponse();
		
		$projectResponse->id = $row['id'];
		$projectResponse->userId = $row['user_id'];
		$projectResponse->projectId = $row['project_id'];
		$projectResponse->status = $row['status'];
		$projectResponse->stmt = $row['stmt'];
		$projectResponse->creationTime = $row['creation_time'];

		return $projectResponse;
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
	 * @return ProjectResponsesMySql 
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