<?php
/**
 * Class that operate on table 'teams'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class TeamsMySqlDAO implements TeamsDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return TeamsMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM teams WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM teams';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM teams ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param team primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM teams WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param TeamsMySql team
 	 */
	public function insert($team){
		$sql = 'INSERT INTO teams (user_id, project_id, team_name, team_owner, team_creation, member_status, leave_team, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($team->getUserId());
		$sqlQuery->setNumber($team->getProjectId());
		$sqlQuery->set($team->getTeamName());
		$sqlQuery->setNumber($team->getTeamOwner());
		$sqlQuery->set($team->getTeamCreation());
		$sqlQuery->setNumber($team->getMemberStatus());
		$sqlQuery->set($team->getLeaveTeam());
		$sqlQuery->setNumber($team->getStatus());

		$id = $this->executeInsert($sqlQuery);	
		$team-> setId($id);
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param TeamsMySql team
 	 */
	public function update($team){
		$sql = 'UPDATE teams SET user_id = ?, project_id = ?, team_name = ?, team_owner = ?, team_creation = ?, member_status = ?, leave_team = ?, status = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($team->userId);
		$sqlQuery->setNumber($team->projectId);
		$sqlQuery->set($team->teamName);
		$sqlQuery->setNumber($team->teamOwner);
		$sqlQuery->set($team->teamCreation);
		$sqlQuery->setNumber($team->memberStatus);
		$sqlQuery->set($team->leaveTeam);
		$sqlQuery->setNumber($team->status);

		$sqlQuery->setNumber($team->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM teams';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM teams WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByProjectId($value){
		$sql = 'SELECT * FROM teams WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTeamName($value){
		$sql = 'SELECT * FROM teams WHERE team_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTeamOwner($value){
		$sql = 'SELECT * FROM teams WHERE team_owner = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTeamCreation($value){
		$sql = 'SELECT * FROM teams WHERE team_creation = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMemberStatus($value){
		$sql = 'SELECT * FROM teams WHERE member_status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLeaveTeam($value){
		$sql = 'SELECT * FROM teams WHERE leave_team = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM teams WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM teams WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByProjectId($value){
		$sql = 'DELETE FROM teams WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTeamName($value){
		$sql = 'DELETE FROM teams WHERE team_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTeamOwner($value){
		$sql = 'DELETE FROM teams WHERE team_owner = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTeamCreation($value){
		$sql = 'DELETE FROM teams WHERE team_creation = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMemberStatus($value){
		$sql = 'DELETE FROM teams WHERE member_status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLeaveTeam($value){
		$sql = 'DELETE FROM teams WHERE leave_team = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM teams WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return TeamsMySql 
	 */
	protected function readRow($row){
		$team = new Team($row['user_id'],$row['project_id'],$row['team_name'],$row['team_owner'],$row['team_creation'],$row['member_status'],$row['leave_team'],$row['status'],$row['id']);
		
		
		

		return $team;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return TeamsMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>
