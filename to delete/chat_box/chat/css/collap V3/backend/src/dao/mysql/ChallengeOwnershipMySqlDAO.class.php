<?php
/**
 * Class that operate on table 'challenge_ownership'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ChallengeOwnershipMySqlDAO implements ChallengeOwnershipDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return ChallengeOwnershipMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM challenge_ownership WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM challenge_ownership';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM challenge_ownership ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param challengeOwnership primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM challenge_ownership WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ChallengeOwnershipMySql challengeOwnership
 	 */
	public function insert($challengeOwnership){
		$sql = 'INSERT INTO challenge_ownership (user_id, challenge_id, ownership_creation, status, submission_time) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($challengeOwnership->userId);
		$sqlQuery->setNumber($challengeOwnership->challengeId);
		$sqlQuery->set($challengeOwnership->ownershipCreation);
		$sqlQuery->setNumber($challengeOwnership->status);
		$sqlQuery->set($challengeOwnership->submissionTime);

		$id = $this->executeInsert($sqlQuery);	
		$challengeOwnership->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param ChallengeOwnershipMySql challengeOwnership
 	 */
	public function update($challengeOwnership){
		$sql = 'UPDATE challenge_ownership SET user_id = ?, challenge_id = ?, ownership_creation = ?, status = ?, submission_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($challengeOwnership->userId);
		$sqlQuery->setNumber($challengeOwnership->challengeId);
		$sqlQuery->set($challengeOwnership->ownershipCreation);
		$sqlQuery->setNumber($challengeOwnership->status);
		$sqlQuery->set($challengeOwnership->submissionTime);

		$sqlQuery->setNumber($challengeOwnership->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM challenge_ownership';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM challenge_ownership WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByChallengeId($value){
		$sql = 'SELECT * FROM challenge_ownership WHERE challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByOwnershipCreation($value){
		$sql = 'SELECT * FROM challenge_ownership WHERE ownership_creation = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM challenge_ownership WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySubmissionTime($value){
		$sql = 'SELECT * FROM challenge_ownership WHERE submission_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM challenge_ownership WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByChallengeId($value){
		$sql = 'DELETE FROM challenge_ownership WHERE challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByOwnershipCreation($value){
		$sql = 'DELETE FROM challenge_ownership WHERE ownership_creation = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM challenge_ownership WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySubmissionTime($value){
		$sql = 'DELETE FROM challenge_ownership WHERE submission_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return ChallengeOwnershipMySql 
	 */
	protected function readRow( $row){
		$challengeOwnership = new ChallengeOwnership($row['user_id'],$row['challenge_id'],$row['ownership_creation'],$row['status']
		,$row['submission_time'], $row['id']);
		
		

		return $challengeOwnership;
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
	 * @return ChallengeOwnershipMySql 
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
