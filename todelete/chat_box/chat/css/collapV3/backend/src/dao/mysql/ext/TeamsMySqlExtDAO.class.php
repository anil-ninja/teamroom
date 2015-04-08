<?php
/**
 * Class that operate on table 'teams'. Database Mysql.
 *
 * @author: rajnish
 * @date: 2015-03-03 14:48
 */
class TeamsMySqlExtDAO extends TeamsMySqlDAO{

	/**
	 * Get all team name records from table
	 */
	public function queryAllTeamNames($projectId, $teamName){
		$sql = "SELECT DISTINCT teams.id, teams.team_name, teams.project_id, user.username 
				FROM teams as teams JOIN user_info as user 
					WHERE teams.project_id= ? AND teams.team_name != ? AND teams.team_owner = user.id AND teams.status= '1'";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> set($projectId);
		$sqlQuery -> set($teamName);
		return $this->getListAllTeams($sqlQuery);
	}

	/**
	 * Get all team member records from table
	 */
	public function queryAllTeamMembers($projectId, $teamName){
		$sql = "SELECT team.id, user.first_name, user.last_name, user.username, user.rank 
				FROM teams as team join user_info as user 
				WHERE team.project_id= ? AND user.id = team.user_id AND team.member_status = '1' AND team.status= '1' AND team.team_name = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery -> set($projectId);
		$sqlQuery -> set($teamName);
		return $this->getListAllTeamMembers($sqlQuery);
	}

	/**
 	 * Delete team record from table
 	 * @param team primary key
 	 */
	public function deleteTeam($projectId, $teamName){
		$sql = 'UPDATE teams SET status = 2, member_status = 2 WHERE project_id = ? AND team_name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($projectId);
		$sqlQuery->set($teamName);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete team member from table
 	 * @param team primary key
 	 */
	public function deleteTeamMember($id){
		$sql = 'UPDATE teams SET member_status = 2 WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}



	/**
	 * Read row
	 *
	 * @return TeamsMySql 
	 */
	protected function readRowAllTeams($row){
		$team = new Team(0,$row['project_id'],$row['team_name'],0,0,0,0,0,$row['username'],$row['id']);
		
		return $team;
	}

	protected function readRowAllTeamMembers($row){
		$team = new TeamMembers($row['first_name'],$row['last_name'],$row['rank'], $row['username'], $row['id']);
		
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

	protected function getListAllTeamMembers($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRowAllTeamMembers($tab[$i]);
		}
		return $ret;
	}
}
