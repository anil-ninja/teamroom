<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface KnownPeoplesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return KnownPeoples 
	 */
	public function load($requestingId, $knowingId);

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
 	 * @param knownPeople primary key
 	 */
	public function delete($requestingId, $knowingId);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param KnownPeoples knownPeople
 	 */
	public function insert($knownPeople);
	
	/**
 	 * Update record in table
 	 *
 	 * @param KnownPeoples knownPeople
 	 */
	public function update($knownPeople);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryById($value);

	public function queryByStatus($value);

	public function queryByRequestingTime($value);

	public function queryByLastActionTime($value);


	public function deleteById($value);

	public function deleteByStatus($value);

	public function deleteByRequestingTime($value);

	public function deleteByLastActionTime($value);


}
?>