<?php
	/**
	 * Object represents table 'investment_info'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class InvestmentInfo{
		
		private $id;
		private $userId;
		private $projectId;
		private $investment;
		private $status;
		private $time;
		private $lastUpdateTime;
		function __construct( $projectId,$userId,$investment,$status,$lastUpdateTime,$time,$id = null)
		{$this->id = $id;
			
			$this->projectId = $projectId;
			$this->userId = $userId;
			$this->investment = $investment;
			$this->lastUpdateTime=$lastUpdateTime;
			$this->time=$time;
			$this->status=$status;
			
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
				
					function setStatus($status){
			$this -> status = $status;
		}
		function getStatus(){
				return $this-> status;
		}
		}
			function setInvestment($investment){
			$this -> investment = $investment;
		}
		function getInvestment(){
				return $this-> investment;
				}
				
				function setTime($time){
			$this -> time = $time;
		}
		function getTime(){
				return $this->time;
		}
		function setLastUpdateTime(lastUpdateTime){
			$this->lastUpdateTime=$lastUpdateTime;
			function getLastUpdateTime(){
				return $this->lastUpdateTime;
			
		function toString (){
			return $this -> id . ", " . $this ->projectId.",".$this->lastUpdateTime.",".$this->time.".".$this->investment.".".status;}
			function toArray() {
			return array (
						id => $this->id,
						projectId => $this->projectId,
						investment => $this->investment,
						status => $this->status,
						time => $this->time,
						lastUpdateTime=>$this->lastUpdateTime
						);
					}
			

		
		
	}
?>
