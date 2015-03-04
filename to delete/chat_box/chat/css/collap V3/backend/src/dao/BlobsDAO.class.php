<?php
/**
 * Intreface DAO
 *
 * @author: http://rahul lahoria.com
 * @date: 2015-03-03 14:48
 */
interface BlobsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Blobs 
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
 	 * @param blob primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Blobs blob
 	 */
	public function insert($blob);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Blobs blob
 	 */
	public function update($blob);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByStmt($value);


	public function deleteByStmt($value);


}
?>
