<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface ChatDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Chat 
	 */
	public function load($id, $userID);

	/**
	 * Get all records from table
	 */
	public function queryAll($userID);
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param chat primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Chat chat
 	 */
	public function insert($chat);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Chat chat
 	 */
	public function update($chat);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByFrom($value);

	public function queryByTo($value);

	public function queryByMessage($value);

	public function queryByTime($value);

	public function queryByStatus($value);


	public function deleteByFrom($value);

	public function deleteByTo($value);

	public function deleteByMessage($value);

	public function deleteByTime($value);

	public function deleteByStatus($value);


}
?>