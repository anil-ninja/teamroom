<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface ChallengeResponsesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ChallengeResponses 
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
 	 * @param challengeResponse primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ChallengeResponses challengeResponse
 	 */
	public function insert($challengeResponse);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ChallengeResponses challengeResponse
 	 */
	public function update($challengeResponse);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByChallengeId($value);

	public function queryByBlobId($value);

	public function queryByStmt($value);

	public function queryByStatus($value);

	public function queryByCreationTime($value);


	public function deleteByUserId($value);

	public function deleteByChallengeId($value);

	public function deleteByBlobId($value);

	public function deleteByStmt($value);

	public function deleteByStatus($value);

	public function deleteByCreationTime($value);


}
?>