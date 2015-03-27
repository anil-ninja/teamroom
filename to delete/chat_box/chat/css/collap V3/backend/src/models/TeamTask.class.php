<?php
	/**
	 * Object represents table 'team_tasks'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class TeamTask{
		
		private $id;
		private $projectId;
		private $teamName;
		private $challengeId;
		private $time;
		function __construct( $projectId,$challengeId,$teamName,$time,$id = null)
		{$this->id = $id;
			
			$this->projectId = $projectId;
			$this->challengeId = $challengeId;
			$this->time = $time;
			$this->teamName=$teamName;
			
			}
			function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setProjectId($projectId){
			$this -> projectId = $projectId;
		}
		function getProjectId(){
				return $this-> projectId;
				}
				
				function setChallengeId($challengeId){
			$this -> challengeId = $challengeId;
		}
		function getChallengeId(){
				return $this->challengeId;
		}
			function setTeamName($exteamName){
			$this -> teamName = $teamNameame;
		}
		function getTeamName(){
				return $this-> teamName;
				}
				
				function setTime($time){
			$this -> time = $time;
		}
		function getTime(){
				return $this->time;
		}
		function toString (){
			return $this -> id . ", " . $this ->projectId.",".$this->teamName.",".$this->time.".".$this->challengeId;}
			function toArray() {
			return array (
						id => $this->id,
						projectId => $this->projectId,
						teamName => $this->teamName,
						time => $this->time,
						challengeId => $this->challengeId
						);
					}
			

		
		
	}
?>
