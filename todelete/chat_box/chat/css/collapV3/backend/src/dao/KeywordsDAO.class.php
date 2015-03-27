<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface KeywordsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Keywords 
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
 	 * @param keyword primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Keywords keyword
 	 */
	public function insert($keyword);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Keywords keyword
 	 */
	public function update($keyword);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUPCId($value);

	public function queryByType($value);

	public function queryByWords($value);

	public function queryByRelevence($value);

	public function queryByTime($value);


	public function deleteByUPCId($value);

	public function deleteByType($value);

	public function deleteByWords($value);

	public function deleteByRelevence($value);

	public function deleteByTime($value);


}
?>