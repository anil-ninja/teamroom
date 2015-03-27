<?php
/**
 * Class that operate on table 'known_peoples'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class KnownPeoplesMySqlDAO implements KnownPeoplesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return KnownPeoplesMySql 
	 */
	public function load($requestingId, $knowingId){
		$sql = 'SELECT * FROM known_peoples WHERE requesting_id = ?  AND knowing_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($requestingId);
		$sqlQuery->setNumber($knowingId);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM known_peoples';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM known_peoples ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param knownPeople primary key
 	 */
	public function delete($requestingId, $knowingId){
		$sql = 'DELETE FROM known_peoples WHERE requesting_id = ?  AND knowing_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($requestingId);
		$sqlQuery->setNumber($knowingId);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param KnownPeoplesMySql knownPeople
 	 */
	public function insert($knownPeople){
		$sql = 'INSERT INTO known_peoples (id, status, requesting_time, last_action_time, requesting_id, knowing_id) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($knownPeople->id);
		$sqlQuery->setNumber($knownPeople->status);
		$sqlQuery->set($knownPeople->requestingTime);
		$sqlQuery->set($knownPeople->lastActionTime);

		
		$sqlQuery->setNumber($knownPeople->requestingId);

		$sqlQuery->setNumber($knownPeople->knowingId);

		$this->executeInsert($sqlQuery);	
		//$knownPeople->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param KnownPeoplesMySql knownPeople
 	 */
	public function update($knownPeople){
		$sql = 'UPDATE known_peoples SET id = ?, status = ?, requesting_time = ?, last_action_time = ? WHERE requesting_id = ?  AND knowing_id = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($knownPeople->id);
		$sqlQuery->setNumber($knownPeople->status);
		$sqlQuery->set($knownPeople->requestingTime);
		$sqlQuery->set($knownPeople->lastActionTime);

		
		$sqlQuery->setNumber($knownPeople->requestingId);

		$sqlQuery->setNumber($knownPeople->knowingId);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM known_peoples';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryById($value){
		$sql = 'SELECT * FROM known_peoples WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM known_peoples WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRequestingTime($value){
		$sql = 'SELECT * FROM known_peoples WHERE requesting_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastActionTime($value){
		$sql = 'SELECT * FROM known_peoples WHERE last_action_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteById($value){
		$sql = 'DELETE FROM known_peoples WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM known_peoples WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRequestingTime($value){
		$sql = 'DELETE FROM known_peoples WHERE requesting_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastActionTime($value){
		$sql = 'DELETE FROM known_peoples WHERE last_action_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return KnownPeoplesMySql 
	 */
	protected function readRow($row){
		$knownPeople = new KnownPeople($row['requesting_id'],$row['knowing_id'],$row['status'],$row['requesting_time'],
		$row['last_action_time'],$row['id']);
		
		

		return $knownPeople;
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
	 * @return KnownPeoplesMySql 
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
