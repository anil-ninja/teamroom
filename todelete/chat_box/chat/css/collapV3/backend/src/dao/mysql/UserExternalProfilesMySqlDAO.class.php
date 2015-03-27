<?php
/**
 * Class that operate on table 'user_external_profiles'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class UserExternalProfilesMySqlDAO implements UserExternalProfilesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UserExternalProfilesMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM user_external_profiles WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM user_external_profiles';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM user_external_profiles ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param userExternalProfile primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM user_external_profiles WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserExternalProfilesMySql userExternalProfile
 	 */
	public function insert($userExternalProfile){
		$sql = 'INSERT INTO user_external_profiles (user_id, ext_url, ext_username, ext_email) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($userExternalProfile->userId);
		$sqlQuery->set($userExternalProfile->extUrl);
		$sqlQuery->set($userExternalProfile->extUsername);
		$sqlQuery->set($userExternalProfile->extEmail);

		$id = $this->executeInsert($sqlQuery);	
		$userExternalProfile->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserExternalProfilesMySql userExternalProfile
 	 */
	public function update($userExternalProfile){
		$sql = 'UPDATE user_external_profiles SET user_id = ?, ext_url = ?, ext_username = ?, ext_email = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($userExternalProfile->userId);
		$sqlQuery->set($userExternalProfile->extUrl);
		$sqlQuery->set($userExternalProfile->extUsername);
		$sqlQuery->set($userExternalProfile->extEmail);

		$sqlQuery->setNumber($userExternalProfile->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM user_external_profiles';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM user_external_profiles WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByExtUrl($value){
		$sql = 'SELECT * FROM user_external_profiles WHERE ext_url = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByExtUsername($value){
		$sql = 'SELECT * FROM user_external_profiles WHERE ext_username = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByExtEmail($value){
		$sql = 'SELECT * FROM user_external_profiles WHERE ext_email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM user_external_profiles WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByExtUrl($value){
		$sql = 'DELETE FROM user_external_profiles WHERE ext_url = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByExtUsername($value){
		$sql = 'DELETE FROM user_external_profiles WHERE ext_username = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByExtEmail($value){
		$sql = 'DELETE FROM user_external_profiles WHERE ext_email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UserExternalProfilesMySql 
	 */
	protected function readRow($row){
		$userExternalProfile = new UserExternalProfile($row['user_id'],$row['ext_url'],$row['ext_username'],$row['ext_email'],$row['id']);
		
		
		

		return $userExternalProfile;
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
	 * @return UserExternalProfilesMySql 
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
