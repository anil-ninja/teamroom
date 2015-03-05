<?php
/**
 * Class that operate on table 'challenge_responses'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ChallengeResponsesMySqlDAO implements ChallengeResponsesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ChallengeResponsesMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM challenge_responses WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM challenge_responses';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM challenge_responses ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param challengeResponse primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM challenge_responses WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ChallengeResponsesMySql challengeResponse
 	 */
	public function insert($challengeResponse){
		$sql = 'INSERT INTO challenge_responses (user_id, challenge_id, blob_id, stmt, status, creation_time) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($challengeResponse->userId);
		$sqlQuery->setNumber($challengeResponse->challengeId);
		$sqlQuery->setNumber($challengeResponse->blobId);
		$sqlQuery->set($challengeResponse->stmt);
		$sqlQuery->setNumber($challengeResponse->status);
		$sqlQuery->set($challengeResponse->creationTime);

		$id = $this->executeInsert($sqlQuery);	
		$challengeResponse->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ChallengeResponsesMySql challengeResponse
 	 */
	public function update($challengeResponse){
		$sql = 'UPDATE challenge_responses SET user_id = ?, challenge_id = ?, blob_id = ?, stmt = ?, status = ?, creation_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($challengeResponse->userId);
		$sqlQuery->setNumber($challengeResponse->challengeId);
		$sqlQuery->setNumber($challengeResponse->blobId);
		$sqlQuery->set($challengeResponse->stmt);
		$sqlQuery->setNumber($challengeResponse->status);
		$sqlQuery->set($challengeResponse->creationTime);

		$sqlQuery->setNumber($challengeResponse->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM challenge_responses';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM challenge_responses WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByChallengeId($value){
		$sql = 'SELECT * FROM challenge_responses WHERE challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByBlobId($value){
		$sql = 'SELECT * FROM challenge_responses WHERE blob_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStmt($value){
		$sql = 'SELECT * FROM challenge_responses WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM challenge_responses WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreationTime($value){
		$sql = 'SELECT * FROM challenge_responses WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM challenge_responses WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByChallengeId($value){
		$sql = 'DELETE FROM challenge_responses WHERE challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByBlobId($value){
		$sql = 'DELETE FROM challenge_responses WHERE blob_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStmt($value){
		$sql = 'DELETE FROM challenge_responses WHERE stmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM challenge_responses WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreationTime($value){
		$sql = 'DELETE FROM challenge_responses WHERE creation_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ChallengeResponsesMySql 
	 */
	protected function readRow($row){
		$challengeResponse = new ChallengeResponse($row['user_id'],$row['challenge_id'],$row['blob_id'],
		$row['stmt'],$row['status'],$row['creation_time'],$row['id']);
		
		
		

		return $challengeResponse;
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
	 * @return ChallengeResponsesMySql 
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
