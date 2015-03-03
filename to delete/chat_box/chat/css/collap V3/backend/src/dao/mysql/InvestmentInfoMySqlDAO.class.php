<?php
/**
 * Class that operate on table 'investment_info'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class InvestmentInfoMySqlDAO implements InvestmentInfoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return InvestmentInfoMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM investment_info WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM investment_info';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM investment_info ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param investmentInfo primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM investment_info WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InvestmentInfoMySql investmentInfo
 	 */
	public function insert($investmentInfo){
		$sql = 'INSERT INTO investment_info (user_id, project_id, investment, status, time, last_update_time) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($investmentInfo->userId);
		$sqlQuery->setNumber($investmentInfo->projectId);
		$sqlQuery->setNumber($investmentInfo->investment);
		$sqlQuery->setNumber($investmentInfo->status);
		$sqlQuery->set($investmentInfo->time);
		$sqlQuery->set($investmentInfo->lastUpdateTime);

		$id = $this->executeInsert($sqlQuery);	
		$investmentInfo->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param InvestmentInfoMySql investmentInfo
 	 */
	public function update($investmentInfo){
		$sql = 'UPDATE investment_info SET user_id = ?, project_id = ?, investment = ?, status = ?, time = ?, last_update_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($investmentInfo->userId);
		$sqlQuery->setNumber($investmentInfo->projectId);
		$sqlQuery->setNumber($investmentInfo->investment);
		$sqlQuery->setNumber($investmentInfo->status);
		$sqlQuery->set($investmentInfo->time);
		$sqlQuery->set($investmentInfo->lastUpdateTime);

		$sqlQuery->setNumber($investmentInfo->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM investment_info';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM investment_info WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProjectId($value){
		$sql = 'SELECT * FROM investment_info WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByInvestment($value){
		$sql = 'SELECT * FROM investment_info WHERE investment = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM investment_info WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTime($value){
		$sql = 'SELECT * FROM investment_info WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastUpdateTime($value){
		$sql = 'SELECT * FROM investment_info WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM investment_info WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProjectId($value){
		$sql = 'DELETE FROM investment_info WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByInvestment($value){
		$sql = 'DELETE FROM investment_info WHERE investment = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM investment_info WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTime($value){
		$sql = 'DELETE FROM investment_info WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastUpdateTime($value){
		$sql = 'DELETE FROM investment_info WHERE last_update_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return InvestmentInfoMySql 
	 */
	protected function readRow($row){
		$investmentInfo = new InvestmentInfo();
		
		$investmentInfo->id = $row['id'];
		$investmentInfo->userId = $row['user_id'];
		$investmentInfo->projectId = $row['project_id'];
		$investmentInfo->investment = $row['investment'];
		$investmentInfo->status = $row['status'];
		$investmentInfo->time = $row['time'];
		$investmentInfo->lastUpdateTime = $row['last_update_time'];

		return $investmentInfo;
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
	 * @return InvestmentInfoMySql 
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