<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */
require_once('utils/sql/Connection.class.php');
require_once('utils/sql/ConnectionFactory.class.php');
require_once('utils/sql/ConnectionProperty.class.php');
require_once('utils/sql/QueryExecutor.class.php');
require_once('utils/sql/Transaction.class.php');
require_once('utils/sql/SqlQuery.class.php');
require_once('utils/ArrayList.class.php');

class DAOFactory{
	
	/**
	 * @return BlobsDAO
	 */
	public static function getBlobsDAO(){
		return new BlobsMySqlExtDAO();
	}

	/**
	 * @return ChallengeOwnershipDAO
	 */
	public static function getChallengeOwnershipDAO(){
		return new ChallengeOwnershipMySqlExtDAO();
	}

	/**
	 * @return ChallengeResponsesDAO
	 */
	public static function getChallengeResponsesDAO(){
		return new ChallengeResponsesMySqlExtDAO();
	}

	/**
	 * @return ChallengesDAO
	 */
	public static function getChallengesDAO(){
		return new ChallengesMySqlExtDAO();
	}

	/**
	 * @return ChatDAO
	 */
	public static function getChatDAO(){
		return new ChatMySqlExtDAO();
	}

	/**
	 * @return EventsDAO
	 */
	public static function getEventsDAO(){
		return new EventsMySqlExtDAO();
	}

	/**
	 * @return InvestmentInfoDAO
	 */
	public static function getInvestmentInfoDAO(){
		return new InvestmentInfoMySqlExtDAO();
	}

	/**
	 * @return InvolveInDAO
	 */
	public static function getInvolveInDAO(){
		return new InvolveInMySqlExtDAO();
	}

	/**
	 * @return KeywordsDAO
	 */
	public static function getKeywordsDAO(){
		return new KeywordsMySqlExtDAO();
	}

	/**
	 * @return KnownPeoplesDAO
	 */
	public static function getKnownPeoplesDAO(){
		return new KnownPeoplesMySqlExtDAO();
	}

	/**
	 * @return NotificationsDAO
	 */
	public static function getNotificationsDAO(){
		return new NotificationsMySqlExtDAO();
	}

	/**
	 * @return OrganisationsDAO
	 */
	public static function getOrganisationsDAO(){
		return new OrganisationsMySqlExtDAO();
	}

	/**
	 * @return ProfessionsDAO
	 */
	public static function getProfessionsDAO(){
		return new ProfessionsMySqlExtDAO();
	}

	/**
	 * @return ProjectResponsesDAO
	 */
	public static function getProjectResponsesDAO(){
		return new ProjectResponsesMySqlExtDAO();
	}

	/**
	 * @return ProjectsDAO
	 */
	public static function getProjectsDAO(){
		return new ProjectsMySqlExtDAO();
	}

	/**
	 * @return SkillsDAO
	 */
	public static function getSkillsDAO(){
		return new SkillsMySqlExtDAO();
	}

	/**
	 * @return SpamsDAO
	 */
	public static function getSpamsDAO(){
		return new SpamsMySqlExtDAO();
	}

	/**
	 * @return TargetsDAO
	 */
	public static function getTargetsDAO(){
		return new TargetsMySqlExtDAO();
	}

	/**
	 * @return TeamTasksDAO
	 */
	public static function getTeamTasksDAO(){
		return new TeamTasksMySqlExtDAO();
	}

	/**
	 * @return TeamsDAO
	 */
	public static function getTeamsDAO(){
		return new TeamsMySqlExtDAO();
	}

	/**
	 * @return UserAccessAidDAO
	 */
	public static function getUserAccessAidDAO(){
		return new UserAccessAidMySqlExtDAO();
	}

	/**
	 * @return UserExternalProfilesDAO
	 */
	public static function getUserExternalProfilesDAO(){
		return new UserExternalProfilesMySqlExtDAO();
	}

	/**
	 * @return UserInfoDAO
	 */
	public static function getUserInfoDAO(){
		
		require_once('UserInfoDAO.class.php');
		require_once('models/UserInfo.class.php');
		require_once('mysql/UserInfoMySqlDAO.class.php');
		require_once('mysql/ext/UserInfoMySqlExtDAO.class.php');

		return new UserInfoMySqlExtDAO();
	}

	/**
	 * @return UserProfessionsDAO
	 */
	public static function getUserProfessionsDAO(){
		return new UserProfessionsMySqlExtDAO();
	}

	/**
	 * @return UserSkillsDAO
	 */
	public static function getUserSkillsDAO(){
		return new UserSkillsMySqlExtDAO();
	}


}
?>