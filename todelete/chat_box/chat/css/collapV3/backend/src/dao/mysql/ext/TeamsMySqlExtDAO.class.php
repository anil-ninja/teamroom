<?php
/**
 * Class that operate on table 'teams'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class TeamsMySqlExtDAO extends TeamsMySqlDAO{

	/**
	 * Get all records from table
	 */
	public function queryAllTeamNames($projectId, $teamName){
		$sql = "SELECT DISTINCT teams.team_name, teams.project_id, user.username 
				FROM teams as teams JOIN user_info as user 
					WHERE teams.project_id= ? AND teams.team_name != ? AND teams.team_owner = user.id";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> set($projectId);
		$sqlQuery -> set($teamName);
		return $this->getListAllTeams($sqlQuery);
	}

	/**
	 * Read row
	 *
	 * @return TeamsMySql 
	 */
	protected function readRowAllTeams($row){
		$team = new Team(0,$row['project_id'],$row['team_name'],0,0,0,0,0,$row['username'],0);
		
		return $team;
	}
	
	protected function getListAllTeams($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRowAllTeams($tab[$i]);
		}
		return $ret;
	}
}
