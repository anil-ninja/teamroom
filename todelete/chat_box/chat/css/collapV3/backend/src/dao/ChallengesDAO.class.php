<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface ChallengesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Challenges 
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
 	 * @param challenge primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Challenges challenge
 	 */
	public function insert($challenge);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Challenges challenge
 	 */
	public function update($challenge);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByProjectId($value);

	public function queryByBlobId($value);

	public function queryByOrgId($value);

	public function queryByTitle($value);

	public function queryByStmt($value);

	public function queryByType($value);

	public function queryByStatus($value);

	public function queryByLikes($value);

	public function queryByDislikes($value);

	public function queryByCreationTime($value);

	public function queryByLastUpdateTime($value);


	public function deleteByUserId($value);

	public function deleteByProjectId($value);

	public function deleteByBlobId($value);

	public function deleteByOrgId($value);

	public function deleteByTitle($value);

	public function deleteByStmt($value);

	public function deleteByType($value);

	public function deleteByStatus($value);

	public function deleteByLikes($value);

	public function deleteByDislikes($value);

	public function deleteByCreationTime($value);

	public function deleteByLastUpdateTime($value);


}
?>