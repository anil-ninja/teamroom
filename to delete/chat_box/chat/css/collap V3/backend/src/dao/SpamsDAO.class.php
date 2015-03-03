<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface SpamsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Spams 
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
 	 * @param spam primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Spams spam
 	 */
	public function insert($spam);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Spams spam
 	 */
	public function update($spam);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryBySpammedId($value);

	public function queryByType($value);

	public function queryByTime($value);


	public function deleteByUserId($value);

	public function deleteBySpammedId($value);

	public function deleteByType($value);

	public function deleteByTime($value);


}
?>