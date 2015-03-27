<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface TeamTasksDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return TeamTasks 
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
 	 * @param teamTask primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param TeamTasks teamTask
 	 */
	public function insert($teamTask);
	
	/**
 	 * Update record in table
 	 *
 	 * @param TeamTasks teamTask
 	 */
	public function update($teamTask);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByProjectId($value);

	public function queryByTeamName($value);

	public function queryByChallengeId($value);

	public function queryByTime($value);


	public function deleteByProjectId($value);

	public function deleteByTeamName($value);

	public function deleteByChallengeId($value);

	public function deleteByTime($value);


}
?>