<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface ChallengeOwnershipDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ChallengeOwnership 
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
 	 * @param challengeOwnership primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ChallengeOwnership challengeOwnership
 	 */
	public function insert($challengeOwnership);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ChallengeOwnership challengeOwnership
 	 */
	public function update($challengeOwnership);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByChallengeId($value);

	public function queryByOwnershipCreation($value);

	public function queryByStatus($value);

	public function queryBySubmissionTime($value);


	public function deleteByUserId($value);

	public function deleteByChallengeId($value);

	public function deleteByOwnershipCreation($value);

	public function deleteByStatus($value);

	public function deleteBySubmissionTime($value);


}
?>