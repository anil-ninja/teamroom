<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface UserExternalProfilesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserExternalProfiles 
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
 	 * @param userExternalProfile primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserExternalProfiles userExternalProfile
 	 */
	public function insert($userExternalProfile);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserExternalProfiles userExternalProfile
 	 */
	public function update($userExternalProfile);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByExtUrl($value);

	public function queryByExtUsername($value);

	public function queryByExtEmail($value);


	public function deleteByUserId($value);

	public function deleteByExtUrl($value);

	public function deleteByExtUsername($value);

	public function deleteByExtEmail($value);


}
?>