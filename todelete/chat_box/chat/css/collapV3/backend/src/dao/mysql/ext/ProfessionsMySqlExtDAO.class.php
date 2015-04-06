<?php
/**
 * Class that operate on table 'professions'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ProfessionsMySqlExtDAO extends ProfessionsMySqlDAO{

	/**
 	 * Insert record to table
 	 *
 	 * @param UserProfessionsMySql userProfession
 	 */
	public function insertUserProfession($userProfession){
		$sql = 'INSERT INTO user_professions (user_id, profession_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($userProfession->getUserId());
		$sqlQuery->setNumber($userProfession->getProfessionId());

		$id = $this->executeInsert($sqlQuery);	
		$userProfession -> setId($id);
		return $id;
	}

	public function queryAllUserProfessions($id){
		$sql = 'SELECT b.id, a.name FROM professions as a JOIN user_professions as b WHERE b.user_id = ? AND a.id = b.profession_id';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getList($sqlQuery);
	}

	/**
 	 * Delete record from table
 	 * @param profession primary key
 	 */
	public function deleteUserProfession($id, $userId){
		$sql = 'DELETE FROM user_professions WHERE id = ? AND user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($userId);
		return $this->executeUpdate($sqlQuery);
	}
}
?>