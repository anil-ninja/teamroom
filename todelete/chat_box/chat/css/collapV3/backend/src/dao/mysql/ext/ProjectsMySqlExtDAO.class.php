<?php
/**
 * Class that operate on table 'projects'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class ProjectsMySqlExtDAO extends ProjectsMySqlDAO{

	public function loadUserProject($projectId, $userId){

		$sql = 'SELECT project.id, project.project_title as title, project.stmt as statement, project.type, project.creation_time, user.first_name, user.last_name, user.username 
					FROM projects as project JOIN user_info as user WHERE project.id = ? AND project.user_id = ? AND project.user_id = user.id';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($projectId);
		$sqlQuery->setNumber($userId);
		return $this->getRowUserProject($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAllUserProjects($userId, $userId){
		$sql = "SELECT DISTINCT project.id, project.project_title as title, project.stmt as statement, project.type, project.creation_time, user.first_name, user.last_name, user.username 
					FROM projects as project JOIN user_info as user JOIN teams as team 
					WHERE (project.user_id = ? OR team.user_id = ?) AND project.user_id = user.id AND project.type != 'Deleted' AND team.member_status = 1 ORDER BY creation_time DESC";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		$sqlQuery->setNumber($userId);
		return $this->getListUserProjects($sqlQuery);
	}

	/**
	 * Read row
	 *
	 * @return ProjectsMySql 
	 */
	protected function readRowUserProjects($row){
		$project = new Project(0, 0, $row['title'], $row['statement'],$row['type'],0,0, $row['creation_time'],0,0,0, $row['first_name'], $row['last_name'], $row['username'], $row['id']);
		
		return $project;
	}
	
	protected function getListUserProjects($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRowUserProjects($tab[$i]);
		}
		return $ret;
	}

	/**
	 * Get row
	 *
	 * @return ProjectsMySql 
	 */
	protected function getRowUserProject($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRowUserProjects($tab[0]);		
	}
}
?>