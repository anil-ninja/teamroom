<?php
/**
 * Class that operate on table 'projects'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ProjectsMySqlDAO implements ProjectsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ProjectsMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM projects WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM projects';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM projects ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param project primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM projects WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ProjectsMySql project
 	 */
	public function insert($project){
		$sql = 'INSERT INTO projects (user_id, blob_id, project_title, stmt, type, org_id, `order`, creation_time, project_value, fund_needed, last_update_time) 
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($project->getUserId());
		$sqlQuery->setNumber($project->getBlobId());
		$sqlQuery->set($project->getProjectTitle());
		$sqlQuery->set($project->getStmt());
		$sqlQuery->setNumber($project->getType());
		$sqlQuery->setNumber($project->getOrgId());
		$sqlQuery->setNumber($project->getOrder());
		$sqlQuery->set($project->getCreationTime());
		$sqlQuery->setNumber($project->getProjectValue());
		$sqlQuery->setNumber($project->getFundNeeded());
		$sqlQuery->set($project->getLastUpdateTime());

		$id = $this->executeInsert($sqlQuery);	
		$project-> seTId ($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ProjectsMySql project
 	 */
	public function update($project){
		$sql = 'UPDATE projects SET user_id = ?, blob_id = ?, project_title = ?, stmt = ?, type = ?, org_id = ?, order = ?, creation_time = ?, project_value = ?, fund_needed = ?, last_update_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($project->userId);
		$sqlQuery->setNumber($project->blobId);
		$sqlQuery->set($project->projectTitle);
		$sqlQuery->set($project->stmt);
		$sqlQuery->setNumber($project->type);
		$sqlQuery->setNumber($project->orgId);
		$sqlQuery->setNumber($project->order);
		$sqlQuery->set($project->creationTime);
		$sqlQuery->setNumber($project->projectValue);
		$sqlQuery->setNumber($project->fundNeeded);
		$sqlQuery->set($project->lastUpdateTime);

		$sqlQuery->setNumber($project->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM projects';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM projects WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBlobId($value){
		$sql = 'SELECT * FROM projects WHERE blob_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProjectTitle($value){
		$sql = 'SELECT * FROM projects WHERE project_title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStmt($value){
		$sql = 'SELECT * FROM projects WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByType($value){
		$sql = 'SELECT * FROM projects WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByOrgId($value){
		$sql = 'SELECT * FROM projects WHERE org_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByOrder($value){
		$sql = 'SELECT * FROM projects WHERE order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreationTime($value){
		$sql = 'SELECT * FROM projects WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProjectValue($value){
		$sql = 'SELECT * FROM projects WHERE project_value = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFundNeeded($value){
		$sql = 'SELECT * FROM projects WHERE fund_needed = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastUpdateTime($value){
		$sql = 'SELECT * FROM projects WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM projects WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBlobId($value){
		$sql = 'DELETE FROM projects WHERE blob_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProjectTitle($value){
		$sql = 'DELETE FROM projects WHERE project_title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStmt($value){
		$sql = 'DELETE FROM projects WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByType($value){
		$sql = 'DELETE FROM projects WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByOrgId($value){
		$sql = 'DELETE FROM projects WHERE org_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByOrder($value){
		$sql = 'DELETE FROM projects WHERE order = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreationTime($value){
		$sql = 'DELETE FROM projects WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProjectValue($value){
		$sql = 'DELETE FROM projects WHERE project_value = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFundNeeded($value){
		$sql = 'DELETE FROM projects WHERE fund_needed = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastUpdateTime($value){
		$sql = 'DELETE FROM projects WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ProjectsMySql 
	 */
	protected function readRow($row){
		$project = new Project($project->userId = $row['user_id'], $row['blob_id'],$row['project_title'], $row['stmt'],$row['type'],$row['org_id'],$row['order'],$row['creation_time'],$row['project_value'], $row['fund_needed'], $row['last_update_time'],
		$row['id']);
		
		

		return $project;
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
	 * @return ProjectsMySql 
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
