<?php
/**
 * Class that operate on table 'known_peoples'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class KnownPeoplesMySqlExtDAO extends KnownPeoplesMySqlDAO{

	public function queryAllLinks($userId){
		$sql = '(SELECT a.first_name, a.last_name, a.username, a.rank, a.user_id FROM user_info as a JOIN known_peoples as b WHERE b.requesting_id = ? AND b.status != 4)
				UNION 
				(SELECT a.first_name, a.last_name, a.username, a.rank, a.user_id FROM user_info as a JOIN known_peoples as b WHERE b.knowing_id = ? AND b.status = 2)
				UNION 
				(SELECT a.first_name, a.last_name, a.username, a.rank, a.user_id FROM user_info as a join (SELECT DISTINCT b.user_id FROM teams as a join teams as b 
											where a.user_id = $user_id and a.team_name = b.team_name and b.user_id != '$user_id')
											as b where a.user_id = b.user_id)';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		return $this->getList($sqlQuery);
	}
}
?>