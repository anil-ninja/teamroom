<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
interface InvestmentInfoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return InvestmentInfo 
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
 	 * @param investmentInfo primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InvestmentInfo investmentInfo
 	 */
	public function insert($investmentInfo);
	
	/**
 	 * Update record in table
 	 *
 	 * @param InvestmentInfo investmentInfo
 	 */
	public function update($investmentInfo);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByUserId($value);

	public function queryByProjectId($value);

	public function queryByInvestment($value);

	public function queryByStatus($value);

	public function queryByTime($value);

	public function queryByLastUpdateTime($value);


	public function deleteByUserId($value);

	public function deleteByProjectId($value);

	public function deleteByInvestment($value);

	public function deleteByStatus($value);

	public function deleteByTime($value);

	public function deleteByLastUpdateTime($value);


}
?>