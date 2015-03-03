<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface ProjectsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Projects 
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
 	 * @param project primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Projects project
 	 */
	public function insert($project);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Projects project
 	 */
	public function update($project);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByBlobId($value);

	public function queryByProjectTitle($value);

	public function queryByStmt($value);

	public function queryByType($value);

	public function queryByOrgId($value);

	public function queryByOrder($value);

	public function queryByCreationTime($value);

	public function queryByProjectValue($value);

	public function queryByFundNeeded($value);

	public function queryByLastUpdateTime($value);


	public function deleteByUserId($value);

	public function deleteByBlobId($value);

	public function deleteByProjectTitle($value);

	public function deleteByStmt($value);

	public function deleteByType($value);

	public function deleteByOrgId($value);

	public function deleteByOrder($value);

	public function deleteByCreationTime($value);

	public function deleteByProjectValue($value);

	public function deleteByFundNeeded($value);

	public function deleteByLastUpdateTime($value);


}
?>