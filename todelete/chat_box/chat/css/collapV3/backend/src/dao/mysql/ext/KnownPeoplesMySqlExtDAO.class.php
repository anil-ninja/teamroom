<?php
/**
 * Class that operate on table 'known_peoples'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-03-03 14:48
 */
class KnownPeoplesMySqlExtDAO extends KnownPeoplesMySqlDAO{

	public function queryAllLinks($userId, $userId, $requestingId, $userId, $requestingId, $userId, $requestingId){
		$sql = "(SELECT a.first_name, a.last_name, a.username, a.rank FROM user_info as a 
					join (SELECT DISTINCT b.user_id FROM teams as a join teams as b where a.id = ? and a.team_name = b.team_name) as b 
					where a.id = b.user_id and b.user_id != ? and b.user_id != ?)
				UNION
				
				(select a.first_name, a.last_name, a.username, a.rank FROM user_info as a join known_peoples as b 
					where b.requesting_id = ? and b.knowing_id != ? and a.id = b.knowing_id and b.status != 4 and b.status != 3)
				UNION

				(select a.first_name, a.last_name, a.username, a.rank FROM user_info as a join known_peoples as b 
					where b.knowing_id = ? and b.requesting_id != ? and a.id = b.requesting_id and b.status = 2)";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($userId);
		$sqlQuery->setNumber($userId);
		$sqlQuery->setNumber($requestingId);
		$sqlQuery->setNumber($userId);
		$sqlQuery->setNumber($requestingId);
		$sqlQuery->setNumber($userId);
		$sqlQuery->setNumber($requestingId);
		return $this->getListUserLinks($sqlQuery);
	}

	/**
	 * Read row
	 *
	 * @return KnownPeoplesMySql 
	 */
	protected function readUserLinks($row){
		$knownPeople = new KnownPeople(0,0,0,0,0,$row['first_name'],$row['last_name'],$row['username'],$row['rank'],0);
		
		

		return $knownPeople;
	}
	
	protected function getListUserLinks($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readUserLinks($tab[$i]);
		}
		return $ret;
	}
}
?>