<?php
/**
 * Class that operate on table 'user_info'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class UserInfoMySqlDAO implements UserInfoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UserInfoMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM user_info WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM user_info';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM user_info ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param userInfo primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM user_info WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserInfoMySql userInfo
 	 */
	public function insert($userInfo){
		$sql = 'INSERT INTO user_info (first_name, last_name, email, phone, username, password, rank, user_type, org_id, capital, page_access, working_org_name, living_town, about_user, reg_time, last_login_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($userInfo->getFirstName());
		$sqlQuery->set($userInfo->getLastName());
		$sqlQuery->set($userInfo->getEmail());
		$sqlQuery->set($userInfo->getPhone());
		$sqlQuery->set($userInfo->getUsername());
		$sqlQuery->set($userInfo->getPassword());
		$sqlQuery->set($userInfo->getRank());
		$sqlQuery->set($userInfo->getUserType());
		$sqlQuery->setNumber($userInfo->getOrgId());
		$sqlQuery->setNumber($userInfo->getCapital());
		$sqlQuery->setNumber($userInfo->getPageAccess());
		$sqlQuery->set($userInfo->getWorkingOrgName());
		$sqlQuery->set($userInfo->getLivingTown());
		$sqlQuery->set($userInfo->getAboutUser());
		$sqlQuery->set($userInfo->getRegTime());
		$sqlQuery->set($userInfo->getLastlogintime());

		$id = $this->executeInsert($sqlQuery);	
		$userInfo -> setId($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserInfoMySql userInfo
 	 */
	public function update($userInfo){
		$sql = 'UPDATE user_info SET first_name = ?, last_name = ?, email = ?, phone = ?, username = ?, password = ?, rank = ?, user_type = ?, org_id = ?, capital = ?, page_access = ?, working_org_name = ?, living_town = ?, about_user = ?, reg_time = ?, last_login_time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($userInfo->firstName);
		$sqlQuery->set($userInfo->lastName);
		$sqlQuery->set($userInfo->email);
		$sqlQuery->set($userInfo->phone);
		$sqlQuery->set($userInfo->username);
		$sqlQuery->set($userInfo->password);
		$sqlQuery->set($userInfo->rank);
		$sqlQuery->set($userInfo->userType);
		$sqlQuery->setNumber($userInfo->orgId);
		$sqlQuery->setNumber($userInfo->capital);
		$sqlQuery->setNumber($userInfo->pageAccess);
		$sqlQuery->set($userInfo->workingOrgName);
		$sqlQuery->set($userInfo->livingTown);
		$sqlQuery->set($userInfo->aboutUser);
		$sqlQuery->set($userInfo->regTime);
		$sqlQuery->set($userInfo->lastLoginTime);

		$sqlQuery->setNumber($userInfo->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM user_info';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByFirstName($value){
		$sql = 'SELECT * FROM user_info WHERE first_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastName($value){
		$sql = 'SELECT * FROM user_info WHERE last_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmail($value){
		$sql = 'SELECT * FROM user_info WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPhone($value){
		$sql = 'SELECT * FROM user_info WHERE phone = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUsername($value){
		$sql = 'SELECT * FROM user_info WHERE username = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPassword($value){
		$sql = 'SELECT * FROM user_info WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRank($value){
		$sql = 'SELECT * FROM user_info WHERE rank = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUserType($value){
		$sql = 'SELECT * FROM user_info WHERE user_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByOrgId($value){
		$sql = 'SELECT * FROM user_info WHERE org_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCapital($value){
		$sql = 'SELECT * FROM user_info WHERE capital = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPageAccess($value){
		$sql = 'SELECT * FROM user_info WHERE page_access = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByWorkingOrgName($value){
		$sql = 'SELECT * FROM user_info WHERE working_org_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLivingTown($value){
		$sql = 'SELECT * FROM user_info WHERE living_town = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAboutUser($value){
		$sql = 'SELECT * FROM user_info WHERE about_user = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRegTime($value){
		$sql = 'SELECT * FROM user_info WHERE reg_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLastLoginTime($value){
		$sql = 'SELECT * FROM user_info WHERE last_login_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByFirstName($value){
		$sql = 'DELETE FROM user_info WHERE first_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastName($value){
		$sql = 'DELETE FROM user_info WHERE last_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmail($value){
		$sql = 'DELETE FROM user_info WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPhone($value){
		$sql = 'DELETE FROM user_info WHERE phone = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUsername($value){
		$sql = 'DELETE FROM user_info WHERE username = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPassword($value){
		$sql = 'DELETE FROM user_info WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRank($value){
		$sql = 'DELETE FROM user_info WHERE rank = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUserType($value){
		$sql = 'DELETE FROM user_info WHERE user_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByOrgId($value){
		$sql = 'DELETE FROM user_info WHERE org_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCapital($value){
		$sql = 'DELETE FROM user_info WHERE capital = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPageAccess($value){
		$sql = 'DELETE FROM user_info WHERE page_access = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByWorkingOrgName($value){
		$sql = 'DELETE FROM user_info WHERE working_org_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLivingTown($value){
		$sql = 'DELETE FROM user_info WHERE living_town = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAboutUser($value){
		$sql = 'DELETE FROM user_info WHERE about_user = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRegTime($value){
		$sql = 'DELETE FROM user_info WHERE reg_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLastLoginTime($value){
		$sql = 'DELETE FROM user_info WHERE last_login_time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UserInfoMySql 
	 */
	protected function readRow($row){
		$userInfo = new UserInfo($row['first_name'],$row['last_name'],$row['email'],$row['phone'],$row['username'],$row['password'],$row['rank'],$row['user_type'],$row['org_id'],$row['capital'],$row['page_access'],$row['working_org_name'],$row['living_town'],$row['about_user'],$row['reg_time'],$row['last_login_time'],$row['id']);
		
		
		

		return $userInfo;
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
	 * @return UserInfoMySql 
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
