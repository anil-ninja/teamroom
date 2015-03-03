<?php
/**
 * Class that operate on table 'team_tasks'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class TeamTasksMySqlDAO implements TeamTasksDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return TeamTasksMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM team_tasks WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM team_tasks';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM team_tasks ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param teamTask primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM team_tasks WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param TeamTasksMySql teamTask
 	 */
	public function insert($teamTask){
		$sql = 'INSERT INTO team_tasks (project_id, team_name, challenge_id, time) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($teamTask->projectId);
		$sqlQuery->set($teamTask->teamName);
		$sqlQuery->setNumber($teamTask->challengeId);
		$sqlQuery->set($teamTask->time);

		$id = $this->executeInsert($sqlQuery);	
		$teamTask->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param TeamTasksMySql teamTask
 	 */
	public function update($teamTask){
		$sql = 'UPDATE team_tasks SET project_id = ?, team_name = ?, challenge_id = ?, time = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($teamTask->projectId);
		$sqlQuery->set($teamTask->teamName);
		$sqlQuery->setNumber($teamTask->challengeId);
		$sqlQuery->set($teamTask->time);

		$sqlQuery->setNumber($teamTask->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM team_tasks';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByProjectId($value){
		$sql = 'SELECT * FROM team_tasks WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTeamName($value){
		$sql = 'SELECT * FROM team_tasks WHERE team_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByChallengeId($value){
		$sql = 'SELECT * FROM team_tasks WHERE challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTime($value){
		$sql = 'SELECT * FROM team_tasks WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByProjectId($value){
		$sql = 'DELETE FROM team_tasks WHERE project_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTeamName($value){
		$sql = 'DELETE FROM team_tasks WHERE team_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByChallengeId($value){
		$sql = 'DELETE FROM team_tasks WHERE challenge_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTime($value){
		$sql = 'DELETE FROM team_tasks WHERE time = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return TeamTasksMySql 
	 */
	protected function readRow($row){
		$teamTask = new TeamTask();
		
		$teamTask->id = $row['id'];
		$teamTask->projectId = $row['project_id'];
		$teamTask->teamName = $row['team_name'];
		$teamTask->challengeId = $row['challenge_id'];
		$teamTask->time = $row['time'];

		return $teamTask;
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
	 * @return TeamTasksMySql 
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