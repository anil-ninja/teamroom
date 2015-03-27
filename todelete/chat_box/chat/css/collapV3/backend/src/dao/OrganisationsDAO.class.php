<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface OrganisationsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Organisations 
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
 	 * @param organisation primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Organisations organisation
 	 */
	public function insert($organisation);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Organisations organisation
 	 */
	public function update($organisation);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByPlanId($value);

	public function queryByTime($value);


	public function deleteByName($value);

	public function deleteByPlanId($value);

	public function deleteByTime($value);


}
?>