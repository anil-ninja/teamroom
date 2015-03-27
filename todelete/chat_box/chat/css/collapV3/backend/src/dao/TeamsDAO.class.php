<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface TeamsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Teams 
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
 	 * @param team primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Teams team
 	 */
	public function insert($team);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Teams team
 	 */
	public function update($team);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByProjectId($value);

	public function queryByTeamName($value);

	public function queryByTeamOwner($value);

	public function queryByTeamCreation($value);

	public function queryByMemberStatus($value);

	public function queryByLeaveTeam($value);

	public function queryByStatus($value);


	public function deleteByUserId($value);

	public function deleteByProjectId($value);

	public function deleteByTeamName($value);

	public function deleteByTeamOwner($value);

	public function deleteByTeamCreation($value);

	public function deleteByMemberStatus($value);

	public function deleteByLeaveTeam($value);

	public function deleteByStatus($value);


}
?>