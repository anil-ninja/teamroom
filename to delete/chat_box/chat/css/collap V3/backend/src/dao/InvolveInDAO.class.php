<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface InvolveInDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return InvolveIn 
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
 	 * @param involveIn primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InvolveIn involveIn
 	 */
	public function insert($involveIn);
	
	/**
 	 * Update record in table
 	 *
 	 * @param InvolveIn involveIn
 	 */
	public function update($involveIn);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByPCId($value);

	public function queryByEventType($value);


	public function deleteByUserId($value);

	public function deleteByPCId($value);

	public function deleteByEventType($value);


}
?>