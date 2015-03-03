<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface EventsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Events 
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
 	 * @param event primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Events event
 	 */
	public function insert($event);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Events event
 	 */
	public function update($event);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByEventCreater($value);

	public function queryByEventType($value);

	public function queryByPCId($value);

	public function queryByTime($value);


	public function deleteByEventCreater($value);

	public function deleteByEventType($value);

	public function deleteByPCId($value);

	public function deleteByTime($value);


}
?>