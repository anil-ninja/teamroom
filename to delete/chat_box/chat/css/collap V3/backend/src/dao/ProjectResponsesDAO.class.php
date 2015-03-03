<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface ProjectResponsesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ProjectResponses 
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
 	 * @param projectResponse primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ProjectResponses projectResponse
 	 */
	public function insert($projectResponse);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ProjectResponses projectResponse
 	 */
	public function update($projectResponse);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByProjectId($value);

	public function queryByStatus($value);

	public function queryByStmt($value);

	public function queryByCreationTime($value);


	public function deleteByUserId($value);

	public function deleteByProjectId($value);

	public function deleteByStatus($value);

	public function deleteByStmt($value);

	public function deleteByCreationTime($value);


}
?>