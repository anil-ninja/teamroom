<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-30 14:57
 */
interface RemindersDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Reminders 
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
 	 * @param reminder primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Reminders reminder
 	 */
	public function insert($reminder);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Reminders reminder
 	 */
	public function update($reminder);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByRemindTo($value);

	public function queryByMessage($value);

	public function queryByDisplayOnTime($value);

	public function queryByStatus($value);

	public function queryByCreationTime($value);


	public function deleteByUserId($value);

	public function deleteByRemindTo($value);

	public function deleteByMessage($value);

	public function deleteByDisplayOnTime($value);

	public function deleteByStatus($value);

	public function deleteByCreationTime($value);


}
?>