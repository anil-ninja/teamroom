<?php
	/**
	 * Object represents table 'user_info'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class UserInfo{
		
		private $id;
		private $firstName;
		private $lastName;
		private $email;
		private $phone;
		private $username;
		private $password;
		private $rank;
		private $userType;
		private $orgId;
		private $capital;
		private $pageAccess;
		private $workingOrgName;
		private $livingTown;
		private $aboutUser;
		private $regTime;
		private $lastLoginTime;
		
           function __construct($firstName,$lastName,$email,$phone,$username,$password,$rank,$usertype,$orgId,
          $capital,$pageAccess,$workingOrgName,$livingTown,$aboutUser,$regTime,$lastLoginTime,$id = null )
          {
			$this->id = $id;
			$this->firstName = $fristnmae;
			$this->lastName = $lastName;
			$this->email = $email;
			$this->phone = $phone;
			$this->usernameName = $username;
			$this->password = $password;
			$this->rank = $rank;
			$this->userType= $userType;
			$this->orgId = $orgId;
			$this->capital = $capital;
			$this->pageAccess= $pageAccess;
			$this->workingOrgName = $workingOrgName;
			$this->livingTown = $livingTown;
			$this->aboutUser = $aboutUser;
			$this->regTime = $regTime;
			$this->lastLoginTime=$lastLoginTime;		
	}
	function setId($id){
			$this -> id = $id;
		}
		function getId(){
				return $this->id;
		}

		function setFirstname($firstName){
			$this -> firstName = $firstNamet;
		}
		function getFristnmae(){
				return $this-> fristname;
				}
				
				function setLastname($lastName){
			$this -> lastName = $lastName;
		}
		function getLastname(){
				return $this->lastName;
		}

		function setEmail($email){
			$this -> email = $email;
		}
		function getEmail(){
				return $this-> Email;
		}
		function setPhone($phone){
			$this -> phone = $phone;
		}
		function getPhone(){
				return $this->phone;
		}

		function setUsername($username){
			$this -> username = $username;
		}
		function getUsername(){
				return $this-> username;
		}
		function setPassword($password){
			$this -> password = $password;
		}
		function getPassword(){
				return $this->password;
		}

		function setRank($rank){
			$this -> rank = $rank;
		}
		function getRank(){
				return $this-> rank;
		}
		function setUserType($userType){
			$this -> userType = $userType;
		}
		function getUserType(){
				return $this->userType;
		}

		function setOrgId($orgId){
			$this -> Orgid = $OrgId;
		}
		function getOrgId(){
				return $this-> orgId;
		}
		function setCapital($capital){
			$this -> capital = $capital;
		}
		function getCapital(){
				return $this->capital;
		}

		function setPageAccess($pageAccess){
			$this -> pageAccess = $pageAccess;
		}
		function getPageAccess(){
				return $this-> pageAccess;
		}
		function setWorkingOrgName($workingOrgName){
			$this -> workingOrgName = $workingOrgName;
		}
		function getWorkingOrgName(){
				return $this->$workingOrgName;
		}

		function setLivingTown($livingTown){
			$this -> livingTown = $livingTown;
		}
		function getLivingTown(){
				return $this-> livingTown;
		}
		function setAboutUser($aboutUser){
			$this -> aboutUser = $aboutUser;
		}
		function getAboutUser(){
				return $this->aboutUser;
		}

		function setRegTime($regTime){
			$this -> regTime = $regTime;
		}
		function getRegTime($regTime){
			$this -> regTime = $regTime;
		}
		function setLastlogintime($lastlogintime){
		$this->lastlogintime=$lastlogintime;
		
		function getLastlogintime($lastlogintime){
				return $this-> lastLoginTime;
		}
		function toString (){
			return $this -> id . ", " . $this -> firstName.",". $this->lastname.",". $this->phone."," . $this->email.",".$this->username.",". $this->password.",".
			$this->rank.",".$this->userType.",".$this->regTime.",". $this->lastlogintime .",".$this->aboutUser 
			.",".$this-> livingTown.",".$this-> workingOrgName.",".$this -> pageAccess.",".$this-> orgId.",".$this->capital ;
		}
		
		function toArray() {
			return array (
						id => $this->id,
						firstName => $this->fristname,
						lastName => $this->lastName,
						phone => $this->phone,
						username => $this->username,
						password => $this->password,
						rank => $this->rank,
						workingOrgName => $this->workingOrgName,
						
						regTime=> $this->regTime,
						pageAccess=> $this->pageAccess,
						livingTown => $this->livingTown,
						lastLoginTime => $this->lastLoginTime,
						
						aboutUser=> $this->aboutUser,
						
						capital=> $this->capitial
						
						
				);
		}
	}
		
?>
