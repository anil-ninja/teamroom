<?php
/**
 * Class that operate on table 'challenges'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ChallengesMySqlDAO implements ChallengesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ChallengesMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM challenges WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM challenges';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM challenges ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param challenge primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM challenges WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ChallengesMySql challenge
 	 */
	public function insert($challenge){
		$sql = 'INSERT INTO challenges (user_id, project_id, blob_id, org_id, title, stmt, type, status, likes, dislikes, creation_time, last_update_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($challenge->userId);
		$sqlQuery->setNumber($challenge->projectId);
		$sqlQuery->setNumber($challenge->blobId);
		$sqlQuery->setNumber($challenge->orgId);
		$sqlQuery->set($challenge->title);
		$sqlQuery->set($challenge->stmt);
		$sqlQuery->setNumber($challenge->type);
		$sqlQuery->setNumber($challenge->status);
		$sqlQuery->setNumber($challenge->likes);
		$sqlQuery->setNumber($challenge->dislikes);
		$sqlQuery->set($challenge->creationTime);
		$sqlQuery->set($challenge->lastUpdateTime);

		$id = $this->executeInsert($sqlQuery);	
		$challenge->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ChallengesMySql challenge
 	 */
	public function update($challenge){
		$sql = 'UPDATE challenges SET user_id = ?, project_id = ?, blob_id = ?, org_id = ?, title = ?, stmt = ?, type = ?, status = ?, likes = ?, dislikes = ?, creation_time = ?, last_update_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($challenge->userId);
		$sqlQuery->setNumber($challenge->projectId);
		$sqlQuery->setNumber($challenge->blobId);
		$sqlQuery->setNumber($challenge->orgId);
		$sqlQuery->set($challenge->title);
		$sqlQuery->set($challenge->stmt);
		$sqlQuery->setNumber($challenge->type);
		$sqlQuery->setNumber($challenge->status);
		$sqlQuery->setNumber($challenge->likes);
		$sqlQuery->setNumber($challenge->dislikes);
		$sqlQuery->set($challenge->creationTime);
		$sqlQuery->set($challenge->lastUpdateTime);

		$sqlQuery->setNumber($challenge->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM challenges';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM challenges WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProjectId($value){
		$sql = 'SELECT * FROM challenges WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBlobId($value){
		$sql = 'SELECT * FROM challenges WHERE blob_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByOrgId($value){
		$sql = 'SELECT * FROM challenges WHERE org_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTitle($value){
		$sql = 'SELECT * FROM challenges WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStmt($value){
		$sql = 'SELECT * FROM challenges WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByType($value){
		$sql = 'SELECT * FROM challenges WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM challenges WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLikes($value){
		$sql = 'SELECT * FROM challenges WHERE likes = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDislikes($value){
		$sql = 'SELECT * FROM challenges WHERE dislikes = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreationTime($value){
		$sql = 'SELECT * FROM challenges WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastUpdateTime($value){
		$sql = 'SELECT * FROM challenges WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM challenges WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProjectId($value){
		$sql = 'DELETE FROM challenges WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBlobId($value){
		$sql = 'DELETE FROM challenges WHERE blob_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByOrgId($value){
		$sql = 'DELETE FROM challenges WHERE org_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTitle($value){
		$sql = 'DELETE FROM challenges WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStmt($value){
		$sql = 'DELETE FROM challenges WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByType($value){
		$sql = 'DELETE FROM challenges WHERE type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM challenges WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLikes($value){
		$sql = 'DELETE FROM challenges WHERE likes = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDislikes($value){
		$sql = 'DELETE FROM challenges WHERE dislikes = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreationTime($value){
		$sql = 'DELETE FROM challenges WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastUpdateTime($value){
		$sql = 'DELETE FROM challenges WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ChallengesMySql 
	 */
	protected function readRow($row){
		$challenge = new Challenge();
		
		$challenge->id = $row['id'];
		$challenge->userId = $row['user_id'];
		$challenge->projectId = $row['project_id'];
		$challenge->blobId = $row['blob_id'];
		$challenge->orgId = $row['org_id'];
		$challenge->title = $row['title'];
		$challenge->stmt = $row['stmt'];
		$challenge->type = $row['type'];
		$challenge->status = $row['status'];
		$challenge->likes = $row['likes'];
		$challenge->dislikes = $row['dislikes'];
		$challenge->creationTime = $row['creation_time'];
		$challenge->lastUpdateTime = $row['last_update_time'];

		return $challenge;
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
	 * @return ChallengesMySql 
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