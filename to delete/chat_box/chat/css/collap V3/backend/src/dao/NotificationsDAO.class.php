<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface NotificationsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Notifications 
	 */
	public function load($id, $userID);

	/**
	 * Get all records from table
	 */
	public function queryAll($userID);
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param notification primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Notifications notification
 	 */
	public function insert($notification);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Notifications notification
 	 */
	public function update($notification);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNoticeUrl($value);

	public function queryByUserId($value);

	public function queryByTime($value);


	public function deleteByNoticeUrl($value);

	public function deleteByUserId($value);

	public function deleteByTime($value);


}
?>