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
		
		require_once('ChallengeResponsesDAO.class.php');
		require_once('models/ChallengeResponse.class.php');
		require_once('mysql/ChallengeResponsesMySqlDAO.class.php');
		require_once('mysql/ext/ChallengeResponsesMySqlExtDAO.class.php');

		return new ChallengeResponsesMySqlExtDAO();
	}

	/**
	 * @return ChallengesDAO
	 */
	public static function getChallengesDAO(){

		require_once('ChallengesDAO.class.php');
		require_once('models/Challenge.class.php');
		require_once('mysql/ChallengesMySqlDAO.class.php');
		require_once('mysql/ext/ChallengesMySqlExtDAO.class.php');

		return new ChallengesMySqlExtDAO();
	}

	/**
	 * @return ChatDAO
	 */
	public static function getChatDAO(){

		require_once('ChatDAO.class.php');
		require_once('models/Chat.class.php');
		require_once('mysql/ChatMySqlDAO.class.php');
		require_once('mysql/ext/ChatMySqlExtDAO.class.php');

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
		
		require_once('NotificationsDAO.class.php');
		require_once('models/Notification.class.php');
		require_once('mysql/NotificationsMySqlDAO.class.php');
		require_once('mysql/ext/NotificationsMySqlExtDAO.class.php');

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

		require_once('ProjectResponsesDAO.class.php');
		require_once('models/ProjectResponse.class.php');
		require_once('mysql/ProjectResponsesMySqlDAO.class.php');
		require_once('mysql/ext/ProjectResponsesMySqlExtDAO.class.php');

		return new ProjectResponsesMySqlExtDAO();
	}

	/**
	 * @return ProjectsDAO
	 */
	public static function getProjectsDAO(){
		
		require_once('ProjectsDAO.class.php');
		require_once('models/Project.class.php');
		require_once('mysql/ProjectsMySqlDAO.class.php');
		require_once('mysql/ext/ProjectsMySqlExtDAO.class.php');

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