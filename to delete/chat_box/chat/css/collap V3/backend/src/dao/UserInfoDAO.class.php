<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface UserInfoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserInfo 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param userInfo primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserInfo userInfo
 	 */
	public function insert($userInfo);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserInfo userInfo
 	 */
	public function update($userInfo);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByFirstName($value);

	public function queryByLastName($value);

	public function queryByEmail($value);

	public function queryByPhone($value);

	public function queryByUsername($value);

	public function queryByPassword($value);

	public function queryByRank($value);

	public function queryByUserType($value);

	public function queryByOrgId($value);

	public function queryByCapital($value);

	public function queryByPageAccess($value);

	public function queryByWorkingOrgName($value);

	public function queryByLivingTown($value);

	public function queryByAboutUser($value);

	public function queryByRegTime($value);

	public function queryByLastLoginTime($value);


	public function deleteByFirstName($value);

	public function deleteByLastName($value);

	public function deleteByEmail($value);

	public function deleteByPhone($value);

	public function deleteByUsername($value);

	public function deleteByPassword($value);

	public function deleteByRank($value);

	public function deleteByUserType($value);

	public function deleteByOrgId($value);

	public function deleteByCapital($value);

	public function deleteByPageAccess($value);

	public function deleteByWorkingOrgName($value);

	public function deleteByLivingTown($value);

	public function deleteByAboutUser($value);

	public function deleteByRegTime($value);

	public function deleteByLastLoginTime($value);


}
?>