<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface UserAccessAidDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserAccessAid 
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
 	 * @param userAccessAid primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserAccessAid userAccessAid
 	 */
	public function insert($userAccessAid);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserAccessAid userAccessAid
 	 */
	public function update($userAccessAid);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByHashKey($value);

	public function queryByStatus($value);

	public function queryByTime($value);


	public function deleteByUserId($value);

	public function deleteByHashKey($value);

	public function deleteByStatus($value);

	public function deleteByTime($value);


}
?>