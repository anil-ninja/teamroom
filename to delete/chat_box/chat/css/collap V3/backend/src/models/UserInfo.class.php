<?php
	/**
	 * Object represents table 'user_info'
	 *
     	 * @author: http://rahullahoria.com
     	 * @date: 2015-03-03 14:48	 
	 */
	class UserInfo {
		
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
		
        function __construct($firstName,$lastName,$email,$phone,$username,$password,$rank,$userType,$orgId,
          $capital,$pageAccess,$workingOrgName,$livingTown,$aboutUser,$regTime,$lastLoginTime,$id = null )
          {
			$this->id = $id;
			$this->firstName = $firstName;
			$this->lastName = $lastName;
			$this->email = $email;
			$this->phone = $phone;
			$this->username = $username;
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
		
		function setId($id) {
			$this -> id = $id;
		}
		function getId(){
			return $this->id;
		}

		function setFirstName($firstName){
			$this -> firstName = $firstName;
		}
		function getFirstName(){
			return $this-> firstName;
		}
		
		function setLastName($lastName){
			$this -> lastName = $lastName;
		}
		function getLastName(){
				return $this->lastName;
		}

		function setEmail($email){
			$this -> email = $email;
		}
		function getEmail(){
				return $this-> email;
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
				return $this-> workingOrgName;
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
				return $this-> aboutUser;
		}

		function setRegTime($regTime){
			$this -> regTime = $regTime;
		}
		function getRegTime(){
			$this -> regTime ;
		}
		function setLastlogintime($lastLoginTime){
			$this->lastLoginTime=$lastLoginTime;
		}
		
		function getLastlogintime(){
				return $this-> lastLoginTime;
		}
		function toString (){
			return $this -> id . ", " . 
					$this -> firstName.",". 
					$this-> lastName.",". 
					$this-> email.",". 
					$this-> phone."," . 
					$this-> username.",". 
					$this-> password.",".
					$this-> rank.",".
					$this-> userType.",".
					$this-> orgId.",".
					$this-> capital.",".
					$this-> pageAccess.",".
					$this-> workingOrgName.",".
					$this-> livingTown.",".
					$this-> aboutUser .",".
					$this-> regTime.",". 
					$this-> lastLoginTime ;
		}
		
		function toArray() {
			return array (
						id => $this-> id,
						firstName => $this-> firstName,
						lastName => $this-> lastName,
						email => $this -> email,
						phone => $this-> phone,
						username => $this-> username,
						password => "******",
						rank => $this-> rank,
						userType => $this-> userType,
						orgId => $this -> orgId,
						capital=> $this-> capital,
						pageAccess=> $this-> pageAccess,
						workingOrgName => $this-> workingOrgName,
						livingTown => $this-> livingTown,
						aboutUser=> $this-> aboutUser,
						regTime=> $this-> regTime,
						lastLoginTime => $this-> lastLoginTime
				);
		}
	}