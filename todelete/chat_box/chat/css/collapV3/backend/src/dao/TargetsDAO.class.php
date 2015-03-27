<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface TargetsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Targets 
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
 	 * @param target primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Targets target
 	 */
	public function insert($target);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Targets target
 	 */
	public function update($target);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByEmail($value);

	public function queryByStatus($value);

	public function queryByType($value);

	public function queryByTime($value);


	public function deleteByEmail($value);

	public function deleteByStatus($value);

	public function deleteByType($value);

	public function deleteByTime($value);


}
?>