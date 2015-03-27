<?php

require_once "utils/nsadmin.php";
require_once "utils/Xml.php";

define('TMP_LOCATION', $_ENV['DH_WWW']. DIRECTORY_SEPARATOR . 'shopbook-refactor' . DIRECTORY_SEPARATOR . "tmp" . DIRECTORY_SEPARATOR);
define('MESSAGE_PRIORITY', 1);
define('MESSAGE_BULK', 2);
define('MESSAGE_PERSONALIZED', 0);

class Util extends Base{


	static $userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6";

	static $mobile_pattern = "#^(91)?[789][\d]{9}$#"; # Mobile should have 10 characters and may be preceeded by 91. It should start with 9
	static $optional_mobile_pattern = "#^((91)?[789][\d]{9})?$#"; # Mobile should have 10 characters and may be preceeded by 91. It should start with 9
	static $optional_email_pattern = "#^(((([a-z\d][\.\-\+_]?)*)[a-z0-9])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6})$|^$#i";
	static $email_pattern = "#^(((([a-z\d][\.\-\+_]?)*)[a-z0-9])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6})$#i";
	static $multiple_email_pattern = "#^(((([a-z\d][\.\-\+_]?)*)[a-z0-9])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6})(\,(((([a-z\d][\.\-\+_]?)*)[a-z0-9])+)\@(((([a-z\d][\.\-_]?){0,62})[a-z\d])+)\.([a-z\d]{2,6}))*$#i";
	static $username_pattern = "#^[a-z][\da-z_\.\-]{3,49}\$#";
	static $integer_pattern = "/^-{0,1}\d+$/";
	static $positive_integer_pattern = "/^\d+$/";
	static $name_pattern = "((?:[a-zA-Z][a-zA-Z]+))";
	static $optional_name_pattern = "#^((?:[a-z\sA-Z][a-z\sA-Z]+))?$#";
	static $password_pattern = "#(?=.{6,50}$)(?=(.*?\d){1})(?=(.*?[A-Z]){1})(?=(.*?[a-z]){1})#";
	static $unknown_payment_key = 'UNKNOWN';

	static function dummyFunctionToForceInclude() { }

	static function genUrl($module, $action) {
		global $prefix;

		return "$prefix/$module/$action";
	}

	static function genUrlLinkByAccess( $module, $action, $params, $tag ){

		global $currentuser;
		$status = $currentuser->hasAccess( $module, $action );

		foreach( $params as $p ){

			$args = '/'.$p;
		}
		$action .= $args;
		$link = Util::genUrl( $module, $action );

		if( $status )
		$link = '<a href="'.$link.'">'.$tag.'</a>';
		else
		$link = "<span id = 'disabled_link'>".$tag."</span>";

		return $link;
	}

	/**
	 * xnor is negate of XOR
	 * php XOR operator is ~ and ! ing it gives xnor :)
	 *
	 * @param unknown_type $a
	 * @param unknown_type $b
	 * @return boolean
	 */
	static function xnor($a, $b) {

    	return !($a ^ $b);
	}

	static function getFunctionName( $function ){

		return substr( $function, 0, strpos( $function, 'Action' ) );
	}

	static function enum_select( $table , $field, $db = 'users' ){

		$db = new Dbase( $db );
		$sql = " SHOW COLUMNS FROM `$table` LIKE '$field' ";
		$row = $db->query_firstrow( $sql );

		#extract the values
		#the values are enclosed in single quotes
		#and separated by commas
		$regex = "/'(.*?)'/";
		$enum_fields = $row['Type'];
		preg_match_all( $regex , $enum_fields, $enum_array );

		$enum_fields = $enum_array[1];

		return $enum_fields;
	}


	static function genUrlLink($link, $display)
	{
		return "<a href=\"$link\">$display</a>";
	}

	static function beautify($str) {
		return trim(ucwords(str_replace('_', ' ', trim($str))));
	}

	/**
	 *
	 */
	static function beautifyAndRemoveChars($str,$length) {
		$str=trim(ucwords(str_replace('_', ' ', trim($str))));
		$length=0-$length;
		$str=substr($str,0,$length);
		return $str;
	}
	/**
	 * Opposite of beautify. Eg: Hello World is converted to hello_world
	 */
	static function uglify($str) {
		return trim(strtolower(str_replace(' ', '_', trim($str))));
	}
	/**
	 * Redirect the control to the module and action provided. If the returnUrl is not set, the user is sent back to the original page
	 */
	static function redirect($mod, $act = '', $return = false, $arg_flash_message = '', $returnUrl = ''){
		global $prefix, $logger, $module, $action, $flash_message, $perf_log_insert_id;
		$db = new Dbase('users');
		$arg_flash_message = "?flash=$arg_flash_message";
		Util::TriggerAlerts($mod, $act);
		if(isset($perf_log_insert_id)){
			$sql = "UPDATE `performance_logs`.`performancelog`
				SET  `status` = 'REDIRECTED'
				WHERE `id` = $perf_log_insert_id AND `apache_thread_id` = '".$_SERVER['UNIQUE_ID']."'";
			// $ret = $db->update($sql);
		}
		if($return == false)
		header("Location: $prefix/$mod/$act/$arg_flash_message");
		else {
			if ($returnUrl == '')
			$returnUrl = Util::genUrl($module, $action); //current action

			header("Location: $prefix/$mod/$act/$arg_flash_message&from=$returnUrl");

		}
		if (php_sapi_name() != "cli") {
			die("Never come here");
		}
		return false;
	}

	public static function redirectByUrl( $url ){

		global $flash_message, $prefix;
		header("Location: $prefix/$url" );
	}

	/**
	 * Complementary function to the function above
	 */
	static function redirectReturn($flash_message = ''){
		global $prefix,$from,$flash;

		if($from=="")
		$from = Util::genUrl('home','index');

		header("Location:$from?flash=$flash");
	}


	static function getNSAdmin(){
		if (Util::$nsadmin == false) {
			Util::$nsadmin = new NSAdminThriftClient();
		}

		return Util::$nsadmin;

	}

	public static $nsadmin;

	static function getStatusOfNSAdmin () {
		$nsadmin = Util::getNSAdmin();
		$ret = $nsadmin->getStatus();
		if ($ret == "")
		$ret = "NSAdmin is not running";
		return $ret;
	}

	static function getStatusOfMsging () {
		$msging = new MsgingThriftClient();
		$ret = $msging->getStatus();
		if ($ret == "")
		$ret = "MSGING is not running";
		return $ret;
	}

	static function getSprinklrReport ($messageId, $reportId) {
		$msging = new MsgingThriftClient();
		$msging->getSprinklrReport($messageId, $reportId);
	}


	//CONQUEST DATA THRIFT HANDLING

	public static $conquestDataClient;
	static function getConquestDataThriftClient(){
		if (Util::$conquestDataClient == false) {
			Util::$conquestDataClient = new ConquestDataThriftClient();
		}

		return Util::$conquestDataClient;
	}

	static function conquestDataServiceImportCubeData($org_id, $org_name)
	{
		global $logger;
		$logger->info("Calling Import Cube Data for $org_id, $org_name");

		$conquestClient = Util::getConquestDataThriftClient();
		$conquestClient->conquestDataServiceImportCubeData($org_id, $org_name);
	}

	//CONQUEST DATA THRIFT HANDLING


	//CONQUEST SETUP THRIFT HANDLING

	public static $conquestClient;
	static function getConquestSetupThriftClient(){
		if (Util::$conquestClient == false) {
			Util::$conquestClient = new ConquestSetupThriftClient();
		}

		return Util::$conquestClient;
	}

	/**
	 * Helps in getting back the current date given
	 * the timezone based on UTC format
	 *
	 * @param unknown_type $utc
	 *
	 * @return $current_time [ format : Y-m-d H:i:s ]
	 */
	public static function UTCOffsetTimeZone( $offset = '+05:30' ){

		global $logger;

		$logger->debug( 'Timezone offset provided '.$offset );
		$offset = str_replace( 'UTC', '', $offset );

		if( self::StringBeginsWith( $offset, '+' ) ){

			$operator = '+';
		}else{

			$operator = '-';
		}

		$offset_details = explode( ':', $offset );
		$axis_details = explode( $operator, $offset_details[0] );

		$minutes = $offset_details[1];
		$hours = $axis_details[1];

		$logger->debug( "OPerator : '$operator' hour : $hours minute  $minutes ");

		$offset_seconds = 60*60*$hours + 60*$minutes;
		$logger->debug( 'Offset Seconds '.$offset_seconds );

		$gmt_seconds = strtotime( gmdate( 'Y-m-d H:i:s' ) );
		$logger->debug( 'GMT Seconds '.$gmt_seconds );

		if( $operator == '+' ){

			$timestamp = $gmt_seconds + $offset_seconds ;
		}else{

			$timestamp = $gmt_seconds - $offset_seconds ;
		}

		$logger->debug( 'Final time '.$timestamp );

		return date( 'Y-m-d H:i:s', $timestamp );
	}

	/*
	 * @param $orgDetails array( array('org_id' => 123, 'org_name' => 'asdasd'), .. )
	 * */
	static function notifyConquestOfFreshDataImported($orgDetails)
	{
		global $logger;
		$logger->info("Notifying for Fresh Data Imported for ".print_r($orgDetails, true));
		$conquestClient = Util::getConquestSetupThriftClient();
		$conquestClient->notifyConquestForFreshImport($orgDetails);
	}

	/*
	 * Calls SetupOrganization on ConquestSetupService
	 * */
	static function notifyConquestSetupForSetupOrg($org_id, $org_name)
	{
		global $logger;
		$logger->info("Calling Setup Organization for $org_id, $org_name");
		$conquestClient = Util::getConquestSetupThriftClient();
		$conquestClient->notifyConquestSetupOfSetupOrganization($org_id, $org_name);
	}

	/*
	 * Calls DisableOrganization on ConquestSetupService
	 * */
	static function notifyConquestSetupForDisableOrg($org_id)
	{
		$logger->info("Calling Disable Organization for $org_id");
		$conquestClient = Util::getConquestSetupThriftClient();
		$conquestClient->notifyConquestSetupOfDisableOrganization($org_id);
	}

	//CONQUEST SETUP THRIFT HANDLING

	/**
	 * Function that sends out the sms.
	 * @param $to The recepient mobile number
	 * @param $message Message as a string
	 * @param $sender_org_id OrgID of the sender org. Their credits are reduced and SENDER ID is used
	 * @param $sms_type Type of the SMS . Use MESSAGE_% definitions -> 0 - Personalized, 1-Priority, 2 - Bulk SMS
	 * @param $truncate boolean should be message be truncated
	 * @param $override_gateway Set to override the default gateway selection logic of nsadmin
	 * @param $is_immediate set to select the sms immediately irrespective of the time
	 *
	 * @return boolean true for success
	 */
	static function sendSms($to, $message, $sender_org_id, $sms_type = 0, $truncate = false, $scheduled_time = '', $override_gateway = false, $is_immediate = false, $tags = array()) { //sms_type of 0 is Value SMS
		global $logger, $cfg;
		$logger->info("==SMS==\n<br/>Sending [TO: $to] [FROM: $sender_org_id] \n<br/> $message ");

		if ($sender_org_id == '') {
			$logger->debug("No sender selected. Not sending SMS");
			return;
		}
		if ($to == false) {
			$logger->debug("No Recepient number. Not sending SMS");
			return;
		}

		if ($cfg['sms']['outenabled'] == false || $cfg['sms']['outenabled'] == 'false') {

			$logger->info("SMS not enabled so skipping sending");
			return;
		}

		if ($message == '') return false;
                /*
		$db = new Dbase('users');
		$ndnc = $db->query_scalar("SELECT is_ndnc FROM organizations WHERE id = $sender_org_id");
		if ($ndnc)	$message = "NDNC\n".$message;
                */
		//$smsOutGateway = new SmsOutgoingGateway();
		//return $smsOutGateway->send($to, $message, $sender_org_id, $sms_type);

		if(!$scheduled_time){
		   $scheduled_time = date('Y-m-d H:i:s');
		   $logger->debug("nsadmin time: $scheduled_time");
		}

		if(!sizeof($tags)){
		  $tags[] = 'transaction'; //default transaction tag
		}

		$ndnc = false;
		$status = Util::isNDNCorInvalidMobileNumber($to, $sender_org_id);
		if($status == 'INVALID')
			return -1;
		else if($status == 'NDNC'){
			$ndnc = true;
			$conf = new ConfigManager($sender_org_id);
			$opt_out_text = $conf->getKey('ORG_OPT_OUT_MESSAGE');
			if(strcasecmp($opt_out_text, "null") != 0) $message .= " $opt_out_text";
			if(strlen($message) > 160)
				Util::sendEmail("gaurav.m@dealhunt.in", "Util::SendSMS msg>160 chars", "org_id: $sender_org_id, message:$message", $sender_org_id);
		}

		$nsadmin = Util::getNSAdmin();

		$type = "DEFAULT";
		if($sms_type==1) $type ="HIGH";
		else if($sms_type==2) $type ="BULK";


		return $nsadmin->sendSMS($to, $sender_org_id, $message, $type, $truncate, $scheduled_time, $override_gateway, $is_immediate, $tags, $ndnc);
	}

	/**
	 * Sends bulk SMS to subscribers using MSGING
	 * @param $categories List of Categories (no need to pass Ids, Codes is fine)
	 * @param $message Text of the message
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkSMSToSubscribers(array $categoryIds, $message, $org_id, $default_arguments){
		global $logger;
		$logger->info("==BULKSMS==\n<br/>Sending [TO: ".print_r($categoryIds, true)."] [FROM: $org_id] \n<br/> $message .<br />Default Args: ".print_r($default_arguments, true));
		$msging = new MsgingThriftClient();
		return $msging->addMessageForSubscribers($org_id, $message, $categoryIds, time(), $default_arguments);
	}

	/**
	 * Checks if the mobile number is Invalid or NDNC
	 */
	static function isNDNCorInvalidMobileNumber($number, $org_id=-1)
	{
		global $currentorg;
		$org_id = ($org_id == -1 ) ? $currentorg->org_id : $org_id;
		$sql =  "SELECT status FROM users_ndnc_status WHERE org_id = $org_id AND mobile = '$number'";

		$db = new Dbase('users');
		$status = $db->query_scalar($sql);
		return $status;
	}


	/**
	 * Sends bulk SMS to Loyalty customers using MSGING
	 * @param $list List of customer ids
	 * @param $message Text of the message
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkSMSToLoyaltyCustomers($list, $message, $org_id, $default_arguments){
		global $logger;
		$logger->info("==BULKSMS==\n<br/>Sending [TO: ".print_r($list, true)."] [FROM: $org_id] \n<br/> $message .<br />Default Args: ".print_r($default_arguments, true));
		$msging = new MsgingThriftClient();
		return $msging->addMessageForFilteredRecepients($org_id, $message, $list, time(), $default_arguments);
	}

	/**
	 * Sends bulk SMS to grouped customers using MSGING
	 * @param $list List of customer ids
	 * @param $message Text of the message
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkSMSToGroupsnew( $msg, $org_id, $groupIds, $default_arguments , $queue_id ){

		global $logger;
		$cm = new CampaignController();

		$logger->debug("==BULKSMS==\n<br/>Sending [TO: ".$groupIds."] [FROM: $org_id] \n<br/> $message .<br />Default Args: ".print_r($default_arguments, true));

		$msging = new MsgingThriftClient();
		$group_id_array = array();
		array_push( $group_id_array, $groupIds );

		$msg_id = $msging->addMessageForGroupedRecepients($org_id, $msg, $group_id_array,time(),$default_arguments);
		$group_id = $groupIds;
		if($msg_id > 0)
		$cm->reduceBulkCredits( $group_id );

		$campaign_id = $cm->getCampaignIdByGroupId( $groupIds );
		$cm->addFieldsToBulkSmsCampaign( $campaign_id, $msg_id, $groupIds , $queue_id);
		$cm->updateLastSentDateForGroup( $group_id );

		return $msg_id;
	}

	/**
	 * Sends bulk SMS to grouped customers using MSGING
	 * @param $list List of customer ids
	 * @param $message Text of the message
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkSMSToGroups( $msg, $org_id, array $groupIds, $default_arguments ){

		global $logger;
		$cm = new CampaignsModule();

		$logger->info("==BULKSMS==\n<br/>Sending [TO: ".print_r($groupIds, true)."] [FROM: $org_id] \n<br/> $message .<br />Default Args: ".print_r($default_arguments, true));
		$msging = new MsgingThriftClient();
		$msg_id = $msging->addMessageForGroupedRecepients($org_id,$msg,$groupIds,time(),$default_arguments);

		$group_id = $groupIds[0];
		if($msg_id > 0)
		$cm->campaignsController->reduceBulkCredits( $group_id );

		$campaign_id = $cm->campaignsController->getCampaignIdByGroupId( $group_id );
		$cm->campaignsController->addFieldsToBulkSmsCampaign( $campaign_id, $msg_id, $group_id );
		$cm->campaignsController->updateLastSentDateForGroup( $group_id );

		return $msg_id;
	}



	static function flash($str) {
		global  $flash_message;
		$flash_message .= "<BR />".$str;
	}

	static function StringBeginsWith($string, $search)
	{
		return (strncmp($string, $search, strlen($search)) == 0);
	}

	static function isInternationalOrg(){
		global $logger, $currentorg;

		if(isset($currentorg)
		&& $currentorg->org_id == 138)
		return true;

		return false;

	}

	//////////////////////////////////////////////////////// CHECK MOBILE /////////////////////////////////////////////////////////////////////

	/**
	 * Deprecated : uses  checkMobileNumberNew.
	 *
	 * @param $mobile The mobile to be checked. Also will be modified accordingly
	 *
	 * @return boolean Whether the mobile is valid for the org or not
	 */
	static function checkMobileNumber( &$mobile ) { //pass by reference so that argument can mutate

		return self::checkMobileNumberNew( $mobile );
	}

	//////////////////////////////////////////////////////// NEW CHECK MOBILE /////////////////////////////////////////////////////////////////////

	/**
	 *
	 * Checks if the country code is there in the begining
	 * and then matches the length
	 *
	 * @param unknown_type $temp_mobile
	 * @param unknown_type $country_details CONTRACT(
	 *
	 * 	`mobile_country_code` ,
	 * 	`mobile_regex` ,
	 * 	`mobile_length_csv` ,
	 * )
	 */
	private function checkRegExWithCountryCode( $mobile, $country_details ){

		global $logger;

		//if country detail is not sent dont check
		if( !is_array( $country_details ) ) return false;

		$country_reg_ex = $country_details['mobile_regex'];
		$country_code = $country_details['mobile_country_code'];
		$country_mobile_length = explode( ',', $country_details['mobile_length_csv'] );

		$min_length = trim( $country_mobile_length[0] );
		$max_length = trim( $country_mobile_length[ count( $country_mobile_length ) - 1 ] );

		$logger->debug( 'Check mobile number begins with country code or not min len :'.
		$min_length.' max length '.$max_length );

		$starts_with = Util::StringBeginsWith( $mobile, $country_code );

		if(
			$starts_with
			 &&
			( strlen( $mobile ) >= $min_length && strlen( $mobile ) <= $max_length )
		){

			$logger->debug( 'Valid range for mobile returning true'."\n");

			return true;
		}else{

			return false;
		}
	}

	/**
	 * Algo :
	 *
	 * 1 ) Check if the number matches the regex
	 * 2 ) If it matches check if the country code needs to be
	 * appended [
	 * 				a) starts with the country code
	 * 				b) lower limit of mobile length csv <= country_code+mobile
	 * 			]
	 * if true return mobile ; [ it has country code in it ]
	 *
	 *
	 * else
	 *
	 * add country code and check.
	 *
	 * @param $mobile
	 * @param $country_details CONTRACT(
	 *
	 * 	`mobile_country_code` ,
	 * 	`mobile_regex` ,
	 * 	`mobile_length_csv` ,
	 * )
	 */
	private static function matchMobileRegexForCountry( &$mobile, $country_details, $default_country_check = false ){

		global $logger;

		$logger->debug( 'Checking for mobile : '.$mobile.' for country details : '.
		print_r( $country_details, true ).' and default country ' .$default_country_check );

		$logger->debug( 'Step 1  : Checks for reg ex match ' );

		//so that mobile gets
		$temp_mobile = $mobile;
		$country_reg_ex = $country_details['mobile_regex'];
		$country_code = $country_details['mobile_country_code'];
		$country_reg_ex_with_code = trim( $country_code.$country_reg_ex );
		$logger->debug( 'Country Code '.$country_reg_ex_with_code.' mobile '.$temp_mobile );
		$matched = preg_match( "/^$country_reg_ex_with_code$/", $temp_mobile );
		if( !$matched && $default_country_check ){

			$logger->debug( 'Number did not match without appending
			country code to number so adding and checking again only for default country' );

			$temp_mobile = $country_code.$temp_mobile;
			$matched = preg_match( "/^$country_reg_ex_with_code$/", $temp_mobile );
		}

		if( $matched ){

			$logger->debug( '
				Passed mobile matched the country reg ex : checking for mobile length .
			' );

			//if starts with country code . Then check mobile length if pass return true else false
			$status = self::checkRegExWithCountryCode( $temp_mobile, $country_details );
			if( $status ){

				$mobile = $temp_mobile;
				$logger->debug( 'Matching successfull for mobile '.$mobile.' for country '.$country_details['name']);

				return true;
			}
		}

		$logger->debug( 'Reg Ex for the country '.$country_details['name'].
		' did not match for mobile. '.$mobile
		);

		return false;
	}

	/**
	 * Returns if other country is configured
	 * @param unknown_type $country_details
	 */
	public function getOtherCountryDetails( $country_details ){

		global $logger;

		foreach( $country_details as $country ){

			foreach( $country as $key => $details ){

				if( $details['short_name'] == 'OTH' ){

					$logger->debug( 'Key Found :-) with id '.$key."\n\n" );
					return $details;
				}
			}

			$logger->debug( 'searching continues for other country : key was '.$key );
			continue;
		}

		$logger->debug( 'Default Country Not Found :-( '."\n\n" );
		return false;
	}

	/**
	 * Check if the default country is configured.
	 *
	 * Returns the details of the country.
	 *
	 * @param unknown_type $country_details
	 */
	public function getDefaultCountryDetails( &$country_details ){

		global $logger, $currentorg;

		$default_country_id = $currentorg->getDefaultCountryID();
		$logger->debug( 'default country selected : '.$default_country_id );

		foreach( $country_details as $country ){

			foreach( $country as $key => $details ){

				if( $key == $default_country_id ){

					unset( $country_details[$default_country_id] );

					$logger->debug( 'Key Found :-) with id '.$key."\n\n" );
					return $details;
				}
			}

			$logger->debug( 'searching continues for default : key was '.$key );
			continue;
		}

		$logger->debug( 'Default Country Not Found :-( '."\n\n" );
		return false;
	}

	/**
	 * checks if any string character is there
	 * in provided mobile and strips it to make it
	 * integer
	 */
	public static function cleanInteger( $integer ){

		//Clean up the mobile number. Only Digits allowed
		$clean = '';
		$numerals = array('0','1','2','3','4','5','6','7','8','9');
		$str = trim( strval( $integer ) ); //convert to string ... extra check for octal numbers ..

		for( $i = 0 ; $i < strlen( $str ) ; $i++ ){

			$char = $str[$i];
			if ( in_array( $char, $numerals ) ){

				$clean .= $char;
			}
		}

		return $clean; // convert to number
	}

	/**
	 * @param unknown_type $mobile
	 * @param unknown_type $country_details
	 */
	public static function checkMobileNumberNew( &$mobile , $country_details = array() ){

		global $logger, $currentorg, $request_type;

		if( $mobile == '1111111' ) return true;

		$logger->debug( 'Mobile To Check : '. $mobile );
		$mobile = self::cleanInteger( $mobile );
		$logger->debug( 'Mobile To Check : '. $mobile );

		//if character is le
		if( strlen( $mobile ) <= 5 ) {

			$logger->debug( 'mobile number with length 5 or less so rejected : ' );
			return false;
		}

		if( ! isset( $currentorg ) ){
			require_once "common_func.php";
			//intl/currentorg not enabled, use defalult checking [ not possible ]
			return checkMobileNumber( $mobile ); # pick up from common_func.php in www/portal/lib/
		}

		if(
			!is_array( $country_details )
			 ||
			( is_array( $country_details ) && count( $country_details ) < 1 )
		)
		{

			$country_details = $currentorg->getCountryDetailsForMobileCheck();
			$logger->debug( 'configured country details : '.print_r( $country_details, true ) );
		}

		//first check for the country details
		$default_country_details = self::getDefaultCountryDetails( $country_details );

		$status = self::matchMobileRegexForCountry( $mobile, $default_country_details, true );
		if( $status ) return true;

		//check all other countries that is configured except Other that would be done at end
		foreach( $country_details as $country_detail ){

			$country = array_values( $country_detail );
			$details = $country[0];

			//it would be checked at the end
			if( $details['short_name'] == 'OTH' ) continue;

			$status = self::matchMobileRegexForCountry( $mobile, $details );
			if( $status ) return true;
		}

		//now is time for other country
		$other_country_details = self::getOtherCountryDetails( $country_details );
		$status = self::matchMobileRegexForCountry( $mobile, $other_country_details );
		if( $status ) return true;

		$mobile = '';
		$logger->debug( '@@@Invalid Mobile Number@@@' );
		return false;
	}

	///////////////////////////////////////////////////// END CHECK MOBILE //////////////////////////////////////////////////////////////////////

	static function checkEmailAddress($email){

		return preg_match(Util::$email_pattern,$email);
	}

	/**
	 * Function that sends out the email.
	 * @param $to The recepient email address
	 * @param $message Message as a string
	 * @param $sender_org_id OrgID of the sender org. Their credits are reduced and SENDER ID is used
	 * @param $email_type Type of the EMAIL . Use MESSAGE_% definitions -> 0 - Personalized, 1-Priority, 2 - Bulk Email
	 * @param $attached_file_id
	 * @return boolean true for success
	 */
	static function sendEmail($to, $message, $body, $sender_org_id, $cc = null,
					$email_type = 0, $attached_file_id = -1, $tags = array() ,
					$schedule_time = 0, $html_decode = true ) { //email_type of 0 is Value Email
		global $logger, $cfg;

		//1st decode
		if( $html_decode ){

			$body = html_entity_decode( $body );
		}

		if (is_array($to)) $to = implode(',', $to);
		if (is_array($cc)) $cc = implode(',', $cc);

		$logger->info("==EMAIL==\n<br/>Sending [TO: ".$to."] [CC: ".$cc."] [FROM: $sender_org_id] \n<br/> Subject: $message<br /><pre>$body</pre> ");
		$logger->debug("Attaching file id: $attached_file_id");

		if ($sender_org_id === false) {
			$logger->debug("No sender selected. Not sending EMAIL");
			return;
		}
		if ($to == false) {
			$logger->debug("No Recepient number. Not sending EMAIL");
			return;
		}

		 if ($cfg['email']['enabled'] == false ) {

			$logger->info("EMAIL not enabled so skipping sending");
			return;
		}


		if ($message == '') return false;

		if(!$tags ){
		  $tags = array('transaction');
		}

		$nsadmin = Util::getNSAdmin();

		$type = "DEFAULT";
		if($email_type==1) $type ="HIGH";
		else if($email_type==2) $type ="BULK";
		$nsadmin_id = $nsadmin->sendEmail($to, $cc, $sender_org_id, $message, $body, $type, false, $attached_file_id, $tags, $schedule_time);

		$logger->debug( 'Nadmin Id Recieved '.$nsadmin_id );
		return $nsadmin_id;
	}

	/**
	 * Function that sends out a template email.
	 * @param $template_file_id The stored file id of the template
	 * @param $to The recepient email address
	 * @param $message Message as a string
	 * @param $sender_org_id OrgID of the sender org. Their credits are reduced and SENDER ID is used
	 * @param $email_type Type of the EMAIL . Use MESSAGE_% definitions -> 0 - Personalized, 1-Priority, 2 - Bulk Email
	 * @param $truncate boolean should be message be truncated
	 * @return boolean true for success
	 */
	static function sendEmailUsingTemplate( $template_file_id, $to, $message,
											$body, $sender_org_id, $cc = null,
											$email_type = 0 , $file_id = -1,
					 						$schedule_time = 0
										  ) { //email_type of 0 is Value Email

		global $logger, $cfg;

		if ($message == '') return false;
		$logger->debug( "template File Id :".$template_file_id." : body ".$body );
		if( $template_file_id ){

			$sf = new StoredFiles(new OrgProfile($sender_org_id));
			$row = $sf->retrieveContents($template_file_id);
			$logger->debug( "Row fetched ".print_r( $row, true ) );
			if ( $row ){

				$template = $row['file_contents'];

				$template = stripslashes($template);
				$args = array('intouch-main-contents' => $body,
						'intouch-footer' => 'This is an auto-generated mail.
						Please contact your Account Manager for any questions. For more information,
						visit <a href="http://capillary.co.in">here</a>');

				$final_body = Util::templateReplace($template, $args);
			}else{

				$final_body = $body;
			}
		}else{

			$final_body = $body;

			$logger->debug( "Final Body*** ".$final_body );
		}

		return Util::sendEmail($to, $message, $final_body, $sender_org_id, $cc, $email_type, $file_id, array(), $schedule_time, false );
	}

	/**
	 * Sends bulk Email to subscribers using MSGING
	 * @param $categories List of Categories (no need to pass Ids, Codes is fine)
	 * @param $message Subject of the email
	 * @param $body Text of the Email
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkEmailToSubscribers(array $categoryIds, $message, $body, $org_id, $default_arguments){
		global $logger;
		$logger->info("==BULKEMAIL==\n<br/>Sending [TO: ".print_r($categoryIds, true)."] [FROM: $org_id] \n<br/> $message .<br />Default Args: ".print_r($default_arguments, true));
		$msging = new MsgingThriftClient();
		return $msging ->addEmailForSubscribers($org_id, $message, $body, $categoryIds, time(), $default_arguments);
	}
	/**
	 * Sends bulk Email to groups using MSGING
	 * @param $group_id
	 * @param $message Subject of the email
	 * @param $body Text of the Email
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkEmailToGroups($group_id, $message, $body, $org_id, $default_arguments){
		global $logger;
		$logger->info("==BULKEMAIL==\n<br/>Sending [TO: ".print_r($group_id, true)."] [FROM: $org_id] \n<br/> $message .<br />Default Args: ".print_r($default_arguments, true));
		$msging = new MsgingThriftClient();
		return $msging->addEmailForGroups($org_id, $message, $body, $group_id, time(), $default_arguments);
	}


	/**
	 * Sends bulk Email to groups using MSGING
	 * @param $group_id
	 * @param $message Subject of the email
	 * @param $body Text of the Email
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkEmailToGroupsNew($group_id, $message, $body, $org_id, $default_arguments,$queue_id){

		global $logger;
		$logger->info("==BULKEMAIL==\n<br/>Sending [TO: $group_id] [FROM: $org_id] \n<br/> $message .<br />Default Args: ".print_r($default_arguments, true));
		$group_id_array = array();
		array_push( $group_id_array, $group_id );

		$cm = new CampaignController();

		$msging = new MsgingThriftClient();
		$msg_id = $msging->addEmailForGroups($org_id, $message, $body, $group_id_array, time(), $default_arguments);

		$campaign_id = $cm->getCampaignIdByGroupId( $group_id );
		$cm->addFieldsToBulkSmsCampaign( $campaign_id , $msg_id , $group_id , $queue_id );
		$cm->updateLastSentDateForGroup( $group_id );

		return $msg_id;
	}


	/**
	 * Sends a template bulk Email to subscribers
	 * @param $template_file_id The stored file id of the template
	 * @param $categories List of Categories (no need to pass Ids, Codes is fine)
	 * @param $message Subject of the email
	 * @param $body Text of the Email
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkEmailToSubscribersUsingTemplate($template_file_id, array $categoryIds, $message, $body, $sender_org_id, $default_arguments){
		global $logger;

		if ($message == '') return false;
		$sf = new StoredFiles(new OrgProfile($sender_org_id));
		$row = $sf->retrieveContents($template_file_id);
		if ($row)
		$template = $row['file_contents'];

		$template = stripslashes($template);
		$args = array('intouch-main-contents' => $body, 'intouch-footer' => 'This is an auto-generated mail. Please contact your Account Manager for any questions. For more information, visit <a href="http://capillary.co.in">here</a>');
		$final_body = Util::templateReplace($template, $args);

		return Util::sendBulkEmailToSubscribers($categoryIds, $message, $final_body, $sender_org_id, $default_arguments);
	}

	/**
	 * Sends a template bulk Email to campaign groups
	 * @param $template_file_id The stored file id of the template
	 * @param $categories List of Categories (no need to pass Ids, Codes is fine)
	 * @param $message Subject of the email
	 * @param $body Text of the Email
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkEmailToGroupsUsingTemplate($template_file_id, $group_id, $message, $body, $sender_org_id,
	$default_arguments,$track_tag=''){
		global $logger, $currentorg;
		if ($message == '') return false;
		$sf = new StoredFiles( $currentorg );
		$row = $sf->retrieveContents($template_file_id);
		if ($row)
		$template = $row['file_contents'];

		$template = stripslashes($template);
		$template .= $track_tag != '' ? $track_tag : '';

		//$args = array('intouch-main-contents' => $body, 'intouch-footer' => 'This is an auto-generated mail. Please contact your Account Manager for any questions. For more information, visit <a href="http://capillary.co.in">here</a>');
		$args = array('intouch-main-contents' => $body, 'intouch-footer' => '<a href="http://capillary.co.in"></a>');
		$final_body = Util::templateReplace($template, $args);

		$logger->debug("Final Call Body before send: ".$final_body." :END");
		$final_body_encode =  htmlentities($final_body);
		return Util::sendBulkEmailToGroups($group_id, $message, html_entity_decode($final_body_encode), $sender_org_id, $default_arguments);

	}

	/**
	 * Sends a template bulk Email to campaign groups
	 * @param $template_file_id The stored file id of the template
	 * @param $categories List of Categories (no need to pass Ids, Codes is fine)
	 * @param $message Subject of the email
	 * @param $body Text of the Email
	 * @param $org_id Org ID sending from
	 * @return boolean : if sending was successful
	 */
	static function sendBulkEmailToGroupsUsingTemplateNew($template_file_id, $group_id, $message, $body, $sender_org_id,
	$default_arguments,$track_tag='',$queue_id,$link=false){
		global $logger, $currentorg;
		if ($message == '') return false;
		$template = "";
		if( $template_file_id ){

			if( $body )
				$template .= $body."<br/>";

			$sf = new StoredFiles( $currentorg );
			$row = $sf->retrieveContents($template_file_id);
			if ($row)
			$template .= $row['file_contents'];

			$template = stripslashes($template);
			//$template .= $track_tag != '' ? $track_tag : '';

			$args = array('intouch-main-contents' => $body,
						  'intouch-footer' => '<a href="http://capillary.co.in"></a>');
			$final_body = Util::templateReplace($template, $args);
		}
		else
			$final_body = $body;

		//Replace unsubscribe tag
//		$append_unsublink = '<a href="http://unsubscribe.capillary.co.in" target="_blank">unsubscribe</a><br/>';
//
//		$unsubscribe_tag = array( 'unsubscribe' => $append_unsublink );
//		$final_body = Util::templateReplace( $final_body , $unsubscribe_tag );
		//END of Replacement

		// If true then add links tracking
		if( $link ){
			//gets new HTML replaced with Tracker Links
			list( $final_body , $link_row_ids ) = self::getHtmlWithTrackerLinks( $final_body );

			$final_body = html_entity_decode( $final_body );

			$final_body .= $track_tag != '' ? $track_tag : '';

			$logger->debug("Final Call Body after 1st decoding : ".$final_body." :END");

			$msg_id = Util::sendBulkEmailToGroupsNew($group_id, $message, $final_body, $sender_org_id, $default_arguments,$queue_id);

			//updates Message ID for tracker links.
			self::updateMessageIdForTrackerLinks( $msg_id , $link_row_ids );

			return $msg_id;
		}

		$final_body = html_entity_decode( $final_body );

		$final_body .= $track_tag != '' ? $track_tag : '';

		$logger->debug("Final Call Body after 1st decoding : ".$final_body." :END");

		return Util::sendBulkEmailToGroupsNew($group_id, $message, $final_body, $sender_org_id, $default_arguments,$queue_id);
	}

	static function calculateDateDifference( $start_date, $end_date ){

		$db = new Dbase('users');

		$sql = " SELECT DATEDIFF('$end_date', '$start_date') ";
		return $db->query_scalar($sql);
	}

	static function isToday($timestamp){
		return ((strtotime("today")<=$timestamp) && ($timestamp < strtotime("tomorrow")));
	}

	static function parseName($name) {
		//TODO: Add logic for empty names, for small names, or if only one part of name is given
		$parts = explode(' ', $name);
		$c = count($parts);

		if ($name == '' || $name == null){//empty name
			$first_name = 'customer';
		}
		else if ($c == 1){//only first name given (assume it to be first name when only one part given)
			$first_name = $name;
		}
		else if (strlen($parts [0] ) > 2) { //north indian style
			$last_name = $parts[$c - 1];
			$first_name = join(" ", array_splice($parts, 0, $c - 1));
		} else { //south indian style
			$last_name = $parts[0];
			$first_name = join(" ", array_splice($parts, 1, $c - 1));
		}
		return array($first_name, $last_name);
	}

	static function convertUserIdToNiceString($row, array $params) {
		global $selected_module;

		$u = UserProfile::getById($row[user_id]);

		if ($u) {
			$e = new ExtendedUserProfile($u, $selected_module->currentorg);
			return $e->getNiceString();
		} else {
			return 'Invalid User';
		}
	}

	static function serializeInto8601($php_timestamp) {
		//echo "tp : $php_timestamp: is_string=".is_string($php_timestamp);
		$d1 = $php_timestamp;
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);

		if ($d1 == false) return false;
		//echo "d1 = $d1";
		$iso_8601 = date('c', $d1);
		//echo "8601: $iso_8601";
		return $iso_8601;
	}

	static function deserializeFrom8601($timestamp_8601) {
		return strtotime($timestamp_8601);
	}

	static function replaceColumnByField($filter,$column,$include_and = true){

		if($filter != ''){
			$filter = str_replace('{{COLUMN}}',$column,$filter);
			$include_and = ($include_and)?('AND'):('') ;
			$filter =  "  ".$include_and . $filter;
		}
		return $filter;
	}
	static function excludeFraudUsers($org_id,$conf_fraud_status = array()){

		if(count($conf_fraud_status) < 1)
		return '';

		$db = new Dbase('users');
		$sql = " SELECT `user_id`
				FROM `fraud_users`
				WHERE `org_id` = '$org_id' AND `status` IN ( ". Util::joinForSql($conf_fraud_status) .")";

		$fraud_users = $db->query($sql);
		$fraud_list = array();
		foreach($fraud_users as $fu){
			array_push($fraud_list,$fu['user_id']);
		}
		$filter = '';
		if(count($fraud_list) > 0){
			$fraud_list = Util::joinForSql($fraud_list);
			$filter =  " {{COLUMN}} NOT IN ($fraud_list) ";
		}

		return $filter;
	}

	/**
	 * @param $loyalty_log_alias alias for loyalty_log used in the query. No alias by default
	 * @param $status array any/all of 'NORMAL','INTERNAL','FRAUD','OUTLIER'. By default takes only 'NORMAL'
	 * @param $include_and adds AND to the beginning of the query (default)
	 * @return string
	 */
	static function includeOnlyBillsWithStatus($loyalty_log_alias = '', $status = false, $include_and = true){
		if(!$status)
		$status = array('NORMAL');
		if($loyalty_log_alias != '')
		$loyalty_log_alias = $loyalty_log_alias.'.';
		$and = 'AND';
		return " $and (".$loyalty_log_alias.'outlier_status IN ('.Util::joinForSql($status).') )';
	}

	static function getLimitFilter(array $paging,$tablename){

		if(count($paging) > 0 && $paging['table_name'] == $tablename)
		$pageId = $paging['page_id'];
		else
		$pageId = 1;

		$start = ($pageId -1) * 10 ;
		$limit = 10;

		return array(" LIMIT $start,$limit",$pageId);
	}
	static function getPermissionsAsOptions($module = -1) {
		$db = new Dbase('stores');
		$perms = $db->query("SELECT * FROM permissions WHERE id > -1 AND (assoc_module = $module OR assoc_module = -1)");
		$rtn = array();
		foreach ($perms as $row) {
			$rtn[$row['name']] = $row['id'];
		}
		return $rtn;
	}

	static function getDateAsString($php_timestamp) {
		$d1 = $php_timestamp;
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);

		if ($d1 == false) return false;
		return date("j-M-Y", $d1);
	}

	static function getMysqlDate($php_timestamp) {
		if ($php_timestamp == false) $php_timestamp = time();
		$d1 = $php_timestamp;
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);

		if ($d1 == false) return false;
		return date ("Y-m-d", $d1);
	}

	static function getMysqlDateTime($php_timestamp) {
		if ($php_timestamp == false) $php_timestamp = time();
		$d1 = $php_timestamp;
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);
		if ($d1 == false) return false;
		return date ("Y-m-d H:i:s", $d1);
	}

	/**
	 * Returns a temporary file in a location accessible publicly
	 * @param $fileprefix Prefix to use for the file
	 * @param $extension Extension for mime type
	 * @return array($system_file, $http_file)
	 */
	static function getTemporaryFile($fileprefix, $extension) {
		global $prefix;

		$system_file = tempnam(TMP_LOCATION, $fileprefix).".$extension";


		$http_file =  $prefix . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . end(explode(DIRECTORY_SEPARATOR, $system_file));

		return array($system_file, $http_file);
	}

	static function valueOrDefault($value, $default) {
		return $value ? $value : $default;
	}

	/**
	 * Replace a template with actual values. The template is a message with parameters given as {{user}}, {{name}} etc.,
	 * and the options would contain the mapping from 'user' => 'actual username'
	 * @param $template
	 * @param $options
	 * @param $defaults
	 * @return unknown_type
	 */
	static function templateReplace($template, array $options, array $defaults = NULL) {
		if ($defaults == NULL) $defaults = array();

		foreach ($options as $k => $v) {
			if ($v == false) $v = $defaults[$k];
 			//echo "replacing $k with $v <br>";
			$template = str_ireplace('{{'.$k.'}}', $v, $template);
		}
		//if something didn't get replaced, just replace all the defaults once again
		foreach ($defaults as $k => $v) {
			$template = str_ireplace('{{'.$k.'}}', $v, $template);
		}

		return $template;
	}

	/**
	 * Generates a random Code of specified Length
	 * @param $length
	 * @return returns a string with the random code
	 */
	static function generateRandomCode( $length = 8, $alphanumeric = true ) {

		// define possible characters
		$microtime = microtime( false );
		$integers = str_replace( ' ', '',str_replace( '.', '', $microtime ) );
		$possible = str_shuffle( $integers );
		if( $alphanumeric )
		$possible .= str_shuffle( "ABCDEFGHIJKLMNOPQRSTUVWXYZ" );

		//Use the current timestamp as the seed
		$code = '';
		srand( (double) microtime()*1000000 );
		for($i = 0; $i < $length; $i++) {

			$possible = str_shuffle( $possible );
			$code .= substr( $possible, ( rand()%( strlen( $possible ) ) ), 1 );
		}

		return $code;
	}

	static function joinForSql($array = NULL) {
		if ($array == NULL) return "''";

		if(count($array) == 1 && !is_array($array))
		return "'$array'";

		return "'".implode("', '", $array)."'";
	}
	static function is_assoc($_array) {
		if ( !is_array($_array) || empty($_array) ) {
			return -1;
		}
		foreach (array_keys($_array) as $k => $v) {
			if ($k !== $v) {
				return true;
			}
		}
		return false;
	}

	static function kpiHtml($obj, $table_id , $family_id , $measure_id = false) {

		if (isset($obj) && is_object($obj) && method_exists($obj, 'generateKpiTableHTML'))
		return $obj->generateKpiTableHTML( $table_id, $family_id, $measure_id  );

		return "";
	}

	static function html($obj, $report = false ) {

		if (isset($obj) && is_object($obj) && method_exists($obj, 'generateHTML'))
		return $obj->generateHTML( $report );

		return "";
	}

	static function die_with_log($error_msg) {
		global $logger;
		$logger->debug($error_msg);
		$logger->printLog();
		die($error_msg);
	}

	static function makeReadable( $code ){

		return str_replace( 'l', 'L', strtolower( $code ) );
	}

	/**
	 * Wrapper around in_array to check, each element in the needle, for existence in the haystack
	 * @param $needle Can be an array
	 * @param $haystack
	 * @return true or false based on existence of needle in haystack
	 */
	static function isInArray($needle, $haystack){
		$present = false;

		if(!is_array($needle))
		$present = in_array($needle, $haystack);
		else{
			foreach($needle AS $n){
				$present = in_array($n, $haystack);
				if($present)
				break;
			}
		}

		return $present;
	}


	/**
	 * Test Helper Utility...
	 * Used when there is join across database...
	 * @param $database DataBase-Name
	 * @param $test true or false
	 * @return DataBase DataBase-name
	 */
	static function dbName($database,$test = false){

		if($test == false){
			$db = $database;
			return $db;
		}else
		$db = "test_".$database;
		return $db;
	}
	static function ServerLoad(){

		$stats = exec('uptime');

		preg_match('/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/', $stats, $regs);

		return round((($regs[1] + $regs[2] + $regs[3]) / 3)*100);

	}

	/**
	 * Stores performance metrics
	 * @param $type API/WEB/CLI/SMS_IN/THRIFT
	 * @param $module Name of the module
	 * @param $action Name of the action
	 * @param $total_time_taken Total time taken
	 * @param $memusage_start In MB
	 * @param $cpuload_start output of Util::ServerLoad()
	 * @param $etc Any specific stuff to store based on the type
	 * 			For API, etc['cache_hit'] = true/false
	 * @return unknown_type
	 */
	static function storePerformanceInfo($type, $module, $action, $total_time_taken, $memusage_start, $cpuload_start, $perf_log_insert_id, $etc){
		//Collect the metrics for peak cpu, memory and the end values
		$memusage_end = memory_get_usage(true)/1000000; //MB
		$memusage_peak = memory_get_peak_usage(true)/1000000; //MB
		$mem_used = array();
		$mem_used['start'] = $memusage_start;
		$mem_used['end'] = $memusage_end;
		$mem_used['peak'] = $memusage_peak;
		$cpuload_end = Util::ServerLoad(); //percentage
		$cpu_load = array();
		$cpu_load['start'] = $cpuload_start;
		$cpu_load['end'] = $cpuload_end;

		//convert etc specific to the service type..   csv output
		$info = "";
		switch($type){
			case 'API' : $info = $etc['cache_hit'];
			break;
			case 'WEB' :
			case 'CLI' :
			case 'SMS_IN' :
			case 'THRIFT' :
				break;
		}

		//Util::storePerformanceInfoInLog($type, $module, $action, $total_time_taken, $mem_used, $cpu_load, $info);
		Util::storePerformanceInfoInDB($type, $module, $action, $total_time_taken, $mem_used, $cpu_load, $perf_log_insert_id, $info);
	}

	static function startEntryIntoPerformanceLogs($type, $module, $action){

		global $currentuser, $currentorg, $performance_dump, $log_performance;
		if(!isset($log_performance))
		$log_performance = true;
		if(!isset($performance_dump))
		$performance_dump = "";
		if($log_performance){
			$org_id = 0;
			$user_id = '4';
			if(isset($currentorg)){

				$org_id = $currentorg->org_id;
			}
			if(isset($currentuser)){

				$user_id = $currentuser->user_id;
			}

			$db = new Dbase('users');
			if ($info == NULL){
				$info = 'NULL';
			}
			$sql = "INSERT INTO `performance_logs`.`performancelog`
			(`id`, `time_stamp`, `apache_thread_id`, `type`, `org_id`, `store_id`,
			`module`, `action`, `time_taken`, `init_mem`, `end_mem`, `peak_mem`,
			`init_cpu`, `final_cpu`, `cache_hit`, `action_dump`, `status`, `count`) VALUES ";
			$data = "(NULL, '".date('Y-m-d H:i:s')."', '".$_SERVER['UNIQUE_ID']."','".$type."',".$org_id.",'".$user_id."', '".$module."','".$action."', -1, -1, -1, -1, -1, -1,".$info.",'".$performance_dump."', 'OPEN', 0)";
			$sql = $sql.$data;
			// $return = $db->insert($sql);
			Util::TriggerAlerts($module, $action);
			return $return;
		}
	}
	/**
	 *
	 * The performance info is directly stored in the db in the performance logs tables.
	 * @param $type
	 * @param $module
	 * @param $action_new
	 * @param $total_time_taken
	 * @param $memory_used
	 * @param $cpu_load
	 * @param $info
	 */
	private static function storePerformanceInfoInDB($type, $module, $action_new, $total_time_taken, $memory_used, $cpu_load, $perf_log_insert_id, $info){

		global $currentuser, $currentorg, $performance_dump, $log_performance;
		if(!isset($log_performance))
		$log_performance = true;
		if(!isset($performance_dump))
		$performance_dump = "";
		if($log_performance){
			$org_id = 0;
			$user_id = '4';
			if(isset($currentorg)){

				$org_id = $currentorg->org_id;
			}
			if(isset($currentuser)){

				$user_id = $currentuser->user_id;
			}

			$db = new Dbase('users');
			$count = Dbase::$request_count;
			if ($info == NULL){
				$info = 'NULL';
			}

			global $time_breakup;
			$breakup = $time_breakup;
                        /*
			if(!PROFILE_MODE){
			  $breakup = "";
			}*/


			$sql = "UPDATE `performance_logs`.`performancelog`
			SET  `time_taken` = $total_time_taken, `init_mem` = ".$memory_used['start'].",
			 `end_mem` = ".$memory_used['end'].", `peak_mem` = ".$memory_used['peak'].",
			`init_cpu` = ".$cpu_load['start'].", `final_cpu` = ".$cpu_load['end'].", `cache_hit` = 0,
			`action_dump` =  '".$performance_dump."', `status` = 'CLOSED',
			`count` = $count, `time_breakup` = '$breakup'
			WHERE `id` = $perf_log_insert_id AND `apache_thread_id` = '".$_SERVER['UNIQUE_ID']."'";

			// $return = $db->update($sql);
			/*if($count > 500){
				$message = "Excessive calls of the db by ".$module."/".$action_new;
				$body = "The count of the db calls is ".$count;
				$contact_list = array('suryajith@dealhunt.in', 'abhishek@dealhunt.in');
				foreach ($contact_list as $to)
				Util::sendEmail($to, $message, $body, 1);
				}*/
		}
	}

	private static function storePerformanceInfoInLog($type, $module, $action_new, $total_time_taken, $memory_used, $cpu_load, $info){

		global $currentuser, $currentorg;

		$org_id = 0;
		$user_name = 'kpowerinfinity';
		if(isset($currentorg)){

			$org_id = $currentorg->org_id;
		}
		if(isset($currentuser)){

			$user_name = $currentuser->username;
		}


		$date = date('Ymd');
		$file = $_ENV['DH_LOG']."/www/performancelog.csv";
		$performance_log_file = fopen ($file, "a");

		//Time, request id, Service Type, Orgid, currentuser, Module, Action, total time taken, memory used, cpu load, etc converted into info
		$mem = $memory_used['start'].",".$memory_used['peak'].",".$memory_used['end'];
		$load = $cpu_load['start'].",".$cpu_load['end'];
		if(strlen($info) > 0)
		$info = ','.$info;
		$lineToWrite = date('Y-m-d H:i:s').','.$_SERVER['UNIQUE_ID'].','.$type.",".$org_id.",".$user_name.",$module,$action_new,$total_time_taken,$mem,$load$info\n";

		fwrite ($performance_log_file, $lineToWrite);
		fclose ($performance_log_file);
	}

	private static function TriggerAlerts($module, $action){

		global $currentuser, $currentorg;

		if( !$currentuser || !$currentorg ){

			return;
		}

		$user_id = $currentuser->user_id;
		$org_id = $currentorg->org_id;

		$db = new Dbase('stores');

		$sql = "SELECT nc.*, o.name as org_name FROM notification_configs nc
				JOIN actions a ON a.id = nc.action_id
				JOIN modules m ON m.id = a.module_id
				JOIN user_management.organizations o ON o.id = $org_id
				WHERE m.code = '$module' AND a.code = '$action' AND nc.org_id = $org_id";

		$result = $db->query_firstrow($sql);

		if($result){
			$report_to = json_decode($result['report_to'], true);
			$send_sms = ($result['send_sms'] == 'YES') ? true : false;
			$send_email = ($result['send_email'] == 'YES') ? true : false;
			$action_id = $result['action_id'];
			$apache_thread_id = $_SERVER['UNIQUE_ID'];
			$org_name = $result['org_name'];
			$user_name = $currentuser->username;
			$time = date('Y-m-d G:i:s');

			$sql = "INSERT INTO access_logs
					(action_id, params, user_id, org_id, time, apache_thread_id)
					VALUES
					($action_id, '', $user_id, $org_id, NOW(), '$apache_thread_id')";

			$ret = $db->insert($sql);

			$subject = "$module / $action accessed by $user_name";
			$msg = "The user $user_name from $org_name has accessed $module / $action at $time";

			$sql = "SELECT mobile, email FROM user_management.users WHERE id IN (".Util::joinForSql($report_to).")";
			$result = $db->query($sql);

			foreach($result as $row){
				if($send_email)
				Util::sendEmail($row['email'], $subject, $msg, $org_id);
				if($send_sms)
				Util::sendSms($row['mobile'], $msg, $org_id);
			}
		}
	}

	/**
	 *Get the number of hours, minutes, seconds given the seconds
	 *@param $secs Number of seconds to be converted
	 *@return array( 'd' => number of days, 'h' => number of hours, 'm' => number of minutes, 's' => numer of seconds)
	 */
	static function convertSeconds($secs, $to_string = false){

		$vals = array(
			'd' => $secs / 86400 % 7,
			'h' => $secs / 3600 % 24,
			'm' => $secs / 60 % 60,
			's' => $secs % 60
		);

		if($to_string){
			$str = "";
			foreach($vals as $k => $v){
				$str .= "$v$k ";
			}
			return $str;
		}

		return $vals;
	}

	/**
	 * Converts the array $data and writes to the file using the handle
	 * @param $data Each element in the array converted to XML with root and the default tag name 'item'
	 * @param $file_handle Needs to be opened and closed externally. Data is just written using the handle
	 */
	static function serializeXMLToFile(&$data, $file_handle){

		$serialized = "";
		$xml = new Xml();
		$xml->setupSerializer(false, 'item');

		foreach($data as $datum){
			$serialized .= $xml->serializeXml($datum)."\n";
		}

		fwrite($file_handle,"$serialized");
	}

	static function setMemoryLimit($memory_limit) {
		//TODO: log which file called this
		ini_set("memory_limit", $memory_limit);
	}

	static function removeCacheFile($org_id, $module, $action){

		//Find all the files in the cache directory
		//Each file is of the form
		//$cachefile = $cachedir . DIRECTORY_SEPARATOR . $currentorg->org_id . '_' . $module . '_' .$action . '_' . $urlhash . '.' . $urlParser->getReturnType();
		$cachedir = $_ENV['DH_WWW'] . DIRECTORY_SEPARATOR . 'cache';

		if($cache_dir_handle = opendir($cachedir)){

			//Directory opened
			//Now fetch all files which with a different module action pair
			//Read each file
			while(false !== ($file = readdir($cache_dir_handle))){

				if ($file == "." || $file == "..")
				continue;

				$file_splits = explode('_', $file);
				//[0] = org_id
				//[1] = module
				//[2] = action

				if(
				$file_splits[0] == $org_id &&
				$file_splits[1] == $module &&
				$file_splits[2] == $action
				){
					if(!unlink("".$cachedir.DIRECTORY_SEPARATOR.$file."")){
						return false;
					}
				}
			}
		}

		return true;
	}


	static function arrayToString($data){
		$str = $data[0];
		$i = 0;
		foreach( $data as $v){
			if($i++ == 0){
				continue;
			}
			$str .=  ','.$v;

		}
	}

	static function timeminute(){

		$time_minutes = array( 'mm' , '00' , '05' );

		for( $i = 10; $i < 56; ){

			array_push( $time_minutes , $i );
			$i = $i + 5;
		}

		return $time_minutes;
	}


	static function timeHours(){

		$time_hrs = array('HH');

		for( $i = 0; $i < 24; $i++ ){

			if( $i < 10 )
			$i = ( string ) '0'.$i;

			array_push( $time_hrs , $i );
		}

		return $time_hrs;
	}

	static function weekOption(){
		$week = array( 'All Days of Week' => '*', 'Mon' => 1, 'Tue' => 2, 'Wed' => 3,
			 			'Thu' => 4, 'Fri' => 5, 'Sat' => 6, 'Sun' => '0'
			 			);
			 			return $week;

	}

	static function monthOption(){

		$month = array( 'All Month' => '*', 'Jan' => 1, 'Feb' => 2, "Mar" => 3, 'Apr' => 4, 'May' => 5,
						'Jun' =>6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12
		);

		return $month;
	}

	static function dayofMonthOption(){

		$day_of_month['All'] = '*';

		$day_of_month['Last Day Of Month'] = 'l';

		for( $i = 1 ; $i <= 31 ; $i++){

			$key = ( $i < 10 )?( '0'.$i ):( $i );
			$day_of_month[$key] = $i;
		}

		return $day_of_month;
	}


	/***********************************************************************
	 * function isDate
	 * boolean isDate(string)
	 * Summary: checks if a date is formatted correctly: dd/mm/yyyy (european)
	 */
	static function isDate($date){
		$status = true;


		$arrDate = explode("-", $date); // break up date by -
		$intYear = $arrDate[0];
		$intMonth = $arrDate[1];
		$intDay = $arrDate[2];
		$intIsDate = checkdate($intMonth, $intDay, $intYear);

		if(!$intIsDate)
		$status = false;

		return $status;

	}

	static function getCurrentDateTime(){

		return date( 'Y-m-d H:m:s ' );
	}

	static function getDateByDays( $use_negative, $days, $date_from = false, $date_format = "%Y-%m-%d" ){

		global $logger;
		if( !$date_from ){
			$date_from = time();
		}else{
			$date_from = strtotime($date_from);
		}

		if($use_negative)
		$days = "-$days";
		$newtimestamp = strtotime( "$days days", $date_from );
		// change to readable date
		$mynewdate = strftime( $date_format, $newtimestamp );

		return $mynewdate;
	}

	static function getNextDate($date){
		return date('Y-m-d', strtotime("+1 day", strtotime($date)));
	}

	static function addHoursToDate($date, $hours)
	{
		return date('Y-m-d H:i:s', strtotime($date . " +$hours hours"));
	}

	static function checkIfXMLisMalformed($xml_input){

		global $performance_dump;

		try {
			$xml_element = new SimpleXMLElement($xml_input);
			return false;
		} catch (Exception $e) {
			$performance_dump .= "\n Invalid XML : ".$xml_input;

			return true;
		}
	}


	/*
	 * Only numeric array can be used
	 * @params $array : array in which the new value has to be inserted
	 * @params $insert : array which needs to be pushed to array
	 * @params $position : position in which array needs to be inserted (-1 will insert the element in last)
	 */
	static 	function array_insert(&$array, $insert, $position = -1) {

		global $logger;

		$position = ($position == -1) ? (count($array)) : $position ;
		if($position != (count($array))) {
			$ta = $array;
			for($i = $position; $i < (count($array)); $i++) {
				if(!isset($array[$i])) {
					$logger->debug("Invalid array: All keys must be numerical and in sequence.");
				}
				$tmp[$i+1] = $array[$i];
				unset($ta[$i]);
			}
			$ta[$position] = $insert;
			$array = $ta + $tmp;
		} else {
			$array[$position] = $insert;
		}

		ksort($array);
		return true;
	}

	function curl_get_request($url) {
		global $logger;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_ENCODING, "" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$html = @curl_exec($ch);
		if (!$html) {
			$logger->debug("cURL error number:".curl_errno($ch));
			$logger->debug("cURL error:".curl_error($ch));
			$logger->debug(var_dump(curl_getinfo($ch)));
		}
		return $html;
	}

	static function isMainServer(){
		if(preg_match("/sb.capillary.co.in$/", $_SERVER['SERVER_NAME']))
		return false;
		return (preg_match("/capillary.co.in$/", $_SERVER['SERVER_NAME'])) ? true : false;
	}

	/**
	 * This function returns true iff its second argument is zero.
	 *
	 * @param int/float $x
	 * @param int/float $y
	 * @return boolean
	 */
	static function div_check( $x, $y ){

		return @($x / $y) === FALSE;
	}

	static function getRuleHeader($id, $salience = 0){

		$header = <<<HEAD
rule "{{RULENAME}}"
     salience {{SALIENCE}}
     dialect "mvel"
     when

HEAD;
		if($salience > 0)
		$rh = preg_replace("/{{RULENAME}}/", "$id-prerequisite", $header); //assuming a single aggregate in a rule
		else
		$rh = preg_replace("/{{RULENAME}}/", $id, $header);

		$rh = preg_replace("/{{SALIENCE}}/", $salience, $rh);
		error_log("rule header: $rh");
		return $rh;
	}

	static function getWeightedRuleFooter($voucher_series, $weight){
		$footer = <<<FOOT

     then
         VoucherSeries fact0 = new VoucherSeries();
         fact0.setSeriesCode( "{{VOUCHER}}" );
         fact0.setPriority({{WEIGHT}});
         insert(fact0);
end


FOOT;

		$footer = preg_replace("/{{VOUCHER}}/", "$voucher_series", $footer);
		$footer = preg_replace("/{{WEIGHT}}/", $weight, $footer);
		return $footer;
	}


	static function isRaymondOrg($org_id)
	{
		return $org_id == 93 || $org_id == 470;
	}

	static function isMOMnMeOrg($org_id)
	{
		return $org_id == 154;
	}

	static function isStore21Org($org_id)
	{
		return $org_id == 189;
	}

	static function isBCBGorg($org_id)
	{
		return $org_id == 459;
	}

	static function isPeterEnglandOrg($org_id)
	{
		return $org_id == 29;
	}

	static function isVLCCDubaiOrg($org_id)
	{
		return $org_id == 431;
	}

	static function addRuleStats($voucher_series, $user_id, $bill_number, $rule_map, $issued = true)
	{
		//populating the rule_stats table with the rule info
		//global $logger;
		global $currentorg, $currentuser;
		$org_id = $currentorg->org_id;
		$store_id = $currentuser->user_id;
		$rule_id = 0;
		if($rule_map){
			$rulearray = json_decode($rule_map, true);
			//$rule_id = intval($rulearray[0]);
			$insertTemplate = "(rule_id, '$voucher_series', $org_id, $store_id, $user_id, " . intval($issued) . ", NOW(), '$bill_number')";
			$insertString = '';
			foreach($rulearray as $rule_id)
			{
				$insertString .= preg_replace('/rule_id/', intval($rule_id), $insertTemplate) . ',';
			}

			$insertString = rtrim($insertString, ',');
			$sql = "INSERT INTO rule_stats(rule_id, voucher_series_id, org_id, store_id, user_id, issued, created_time, bill_number)
              values $insertString";
			$db = new Dbase("campaigns");
			$db->insert($sql);
		}


	}

		static function momnmeToPosPath(){

		//$path = "smb://retail:M@rpl,1@10.2.203.61/capillary/TO_POS/postxn.asc";
		//$path = "smb://retail:M@rpl,1@10.2.152.42/storedata/capillary/TO_POS/postxn.asc";
		$config_manager = new ConfigManager();
		$username = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_USERNAME' ), false);
		$password = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_PASSWORD' ), false);
		$host = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_HOST' ), false);
		$path = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_PATH' ), false);
		$filename = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_FILENAME' ), false);

		$path = "smb://$username:$password@$host$path$filename";
		return $path;
	}

	static function momnmeToSapPath(){

		//$output_folder = "smb://retail:M@rpl,1@10.2.203.61/capillary/TO_SAP/";
		//$output_folder = "smb://retail:M@rpl,1@10.2.152.42/storedata/capillary/TO_SAP/";
		$config_manager = new ConfigManager();
		$username = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_USERNAME' ), false);
		$password = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_PASSWORD' ), false);
		$host = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_HOST' ), false);
		$path = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_PATH' ), false);
		$filename = self::valueOrDefault($config_manager->getKey( 'MOMNME_TO_POS_FILENAME' ), false);

		$output_folder = "smb://$username:$password@$host$path";
		return $output_folder;
	}


	static function getSupportedTimeZones()
	{
		return array(
			'-08:00 USA' => '-08:00',
			'-07:00 USA' => '-07:00',
			'+00:00 (UK/London)' => '+00:00',
			'+01:00 (UK/London - Summer)' => '+01:00',
			'+04:00 (UAE/Dubai)' => '+04:00',
			'+05:30 (India)' => '+05:30'
			);
	}


	/**
	 * Generates a url to be used for the cheetah code base
	 *
	 * @param unknown_type $namespace page path
	 * @param unknown_type $page     page name
	 * @param unknown_type $params   assoc array containing url parameters
	 */

	static function genCheetahUrl($namespace, $page, $params){
		global $prefix;
		$param_string = '';
		foreach($params as $k=>$v){
			$param_string .= "&$k=$v";
		}
		return "$prefix/$namespace/$page$param_string";
	}


	/**
	 * Returns the list of gateways which can be configured.
	 */

	static function getGatewayList(){
		$sql = "SELECT short_gateway_name FROM nsadmin.gateways";
		$db = new Dbase('nsadmin');
		$list = $db->query_firstcolumn($sql);
		return array_merge(array('', 'netcoretrans'), $list);
	}

	/**
	 * This function will fetch the overridden gateway
	 * for the organization.
	 */

	static function getOverrideGateway()
	{
		global $currentorg;
		$gateway = Util::valueOrDefault($currentorg->getConfigurationValue('CONF_OVERRIDE_GATEWAY', false), 'cardboardfishsmpp');
		return $gateway;
	}

	private static function variable_map_func($v)
	{return '$'.$v;}

	static function getVariableList($supplied_data) {
		/*if (!function_exists(variable_map_func)) {
			function variable_map_func($v) { return '$'.$v; }
			}*/
		$after_map = array_map('Util::variable_map_func', array_keys($supplied_data));
		$variables = implode(", ", $after_map);
		return $variables;
	}


	/**
	 * Function to merge each row of the two arrays.
	 * @param unknown_type $array1
	 * @param unknown_type $array2
	 */
	static function mergeArrays(&$array1,&$array2)
	{
		foreach($array1 as $k=>$v)
		$array1[$k]=array_merge($array1[$k],$array2[$k]);
	}

	static function getSecretQuestions(){
		$options = array(

			'How many stock options do you have?' => 'How many stock options do you have?',
			'Who was your first online date?' => 'Who was your first online date?',
			'What is your World of Warcraft name?' => 'What is your World of Warcraft name?',
			'What was the name of your first startup?' => 'What was the name of your first startup?',
			'What is your Facebook username?' => 'What is your Facebook username?',
			'What was your first email address?' => 'What was your first email address?',
			'When was the last time you went out on a date?' => 'When was the last time you went out on a date?'
			);

			return $options;
	}

	public static function getPaymentTypes(){

		$sql = "SELECT id, type FROM payment_types";
		$db = new Dbase('users');
		return $db->query_hash($sql, 'type', 'id');
	}


	/**
	 * This is a generic string padding function
	 * built using str_pad php function
	 *
	 * @param $input : String to be padded
	 * @param $length : Final length of the padded string
	 * @param $type : Padding alignment, LEFT/RIGHT/CENTRE
	 * 				   Default is CENTRE
	 * @param $fill : Characters to be used for padding
	 */

	public static function padString($input, $length = -1, $type = 'CENTRE', $fill = " ")
	{
		global $logger;
		$output = "";
		switch($type)
		{
			case 'LEFT':
				$output = str_pad($input, $length, $fill, STR_PAD_LEFT);
				break;
			case 'RIGHT':
				$output = str_pad($input, $length, $fill, STR_PAD_RIGHT);
				break;
			case 'CENTRE':
				$output = str_pad($input, $length, $fill, STR_PAD_BOTH);
				break;
			default:
				$output = $input;
		}
		//$logger->debug("Input string: $input, output string: $output\n");
		return $output;
	}

	public static function convertOldErrorCodes($error_code)
	{
		$old_error_codes=array("0" => "ERR_LOYALTY_SUCCESS",
		  "1000"   => "ERR_LOYALTY_USER_NOT_REGISTERED",
		 "-2000"   => "ERR_LOYALTY_DUPLICATE_BILL_NUMBER",
		 "-3000"   => "ERR_LOYALTY_INVALID_VOUCHER_CODE",
		 "-4000"   => "ERR_LOYALTY_LISTENER",
		 "-5000"   => "ERR_LOYALTY_INSUFFICIENT_POINTS",
		-"6000"   => "ERR_LOYALTY_PROFILE_UPDATE_FAILED",
		-"7000"   => "ERR_LOYALTY_REGISTRATION_FAILED",
		-"8000"   => "ERR_LOYALTY_BILL_ADDITION_FAILED",
		-"9000"   => "ERR_LOYALTY_UNKNOWN",
		-"10000"  => "ERR_LOYALTY_REDEMPTION_SERIES_INVALID",
		-"11000"  => "ERR_LOYALTY_INVALID_BILL_NUMBER",
		-"12000"  => "ERR_LOYALTY_INVALID_VALIDATION_CODE",
		-"13000"  => "ERR_LOYALTY_INVALID_BILL_AMOUNT",
		-"14000"  => "ERR_LOYALTY_INSUFFICIENT_REDEMPTION_POINTS",
		-"15000"  => "ERR_LOYALTY_INSUFFICIENT_CURRENT_POINTS",
		-"16000"  => "ERR_LOYALTY_INSUFFICIENT_LIFETIME_POINTS",
		-"17000"  => "ERR_LOYALTY_INSUFFICIENT_LIFETIME_PURCHASE",
		-"18000"  => "ERR_LOYALTY_REDEMPTION_POINTS_NOT_DIVISIBLE",
		-"19000"  => "ERR_LOYALTY_INVALID_MOBILE",
		-"20000"  => "ERR_LOYALTY_COMMUNICATION",
		-"21000"  => "ERR_LOYALTY_INVALID_EXTERNAL_ID",
		-"22000"  => "ERR_LOYALTY_INSUFFICIENT_POINTS_CLMS",
		-"23000"  => "ERR_LOYALTY_UNABLE_TO_FETCH_CLMS_POINTS",
		-"24000"  => "ERR_LOYALTY_FRAUD_USER",
		-"25000"  => "ERR_LOYALTY_BILL_POINTS_USED",
		-"26000"  => "ERR_LOYALTY_INVALID_MOBILE_AND_EMAIL",
		-"27000"  => "ERR_LOYALTY_INVALID_EMAIL");
		if (empty($old_error_codes[$error_code]))
		return $error_code;
		else
		return $old_error_codes[$error_code];
	}

	/**
	 * it will returns days of months as option
	 */
	public static function getDOM(){

		$dom = array();

		for( $i = 0 ; $i<=31 ; $i++ ){

			if( $i == 0 ){
				$dom['ALL'] = -1;
				continue;
			}
			$dom[$i] = $i;
		}
		return $dom;
	}

	/**
	 * it will returns days of week as option
	 * format ( Mon , Tue , etc)
	 */
	public static function getDOW(){

		$dow = array();

		for( $i = 0 ; $i<=7 ; $i++ ){

			switch( $i ){
				case 0 :
					$dow['ALL'] = -1;
					break;
				case 1 :
					$dow['Mon'] = 1;
					break;
				case 2 :
					$dow['Tue'] = 2;
					break;
				case 3 :
					$dow['Wed'] = 3;
					break;
				case 4 :
					$dow['Thu'] = 4;
					break;
				case 5 :
					$dow['Fri'] = 5;
					break;
				case 6 :
					$dow['Sat'] = 6;
					break;
				case 7 :
					$dow['Sun'] = 7;
					break;
			}

		}
		return $dow;

	}

	/**
	 * it will returns days of hours as option
	 * format ( 00 to 23 )
	 */
	public static function getHours(){

		$hours = array();

		for( $i = 0 ; $i<=24 ; $i++ ){
			$j = $i;
			if( $i == 0 ){
				$hours['ALL'] = ($j-1);
				continue;
			}
			if( $i <= 10)
			$hours['0'.($j-1)] = ($j-1);
			else
			$hours[($j-1)] = ($j-1);
		}
		return $hours;
	}


	/**
	 * Converts arrays to objects+
	 *
	 */
	public static function arrayToObject($array)
	{
		global $logger;
		$logger->debug("converting array to object");
		foreach($array as $key => $value)
		{
			if(is_array($value))
                                $array[$key] = self::arrayToObject($value);
		}

		$obj = (object)$array;
		$logger->debug("converted object: " . print_r($obj, true));
		return $obj;
	}


	public static function getApacheThreadId($org_id,$user_id,$type,$action)
	{

		$sql="SELECT performance_logs.performancelog WHERE org_id=$org_id
 	AND user_id=$user_id AND type=$type
 	AND action=$action order by id desc";
		$dbconn=new Dbase('users');
		$res=$dbconn->query_firstrow($sql);
		return $res;

	}

	/**
	 * Generate a series of key value mapping pairs for the gift cards
	 */

	public static function generateCardMapping($key_prefix, $key_start_id, $key_id_len, $key_suffix, $value_prefix, $value_start_id, $value_id_len, $value_suffix, $count)
	{
		$res = array();

		global $logger;
		$res[0][0] = "Published Card Number";
		$res[0][1] = "Magnetic Card Number ";

		$logger->debug("input $key_prefix $key_start_id $key_id_len $key_suffix $value_prefix $value_start_id $value_id_len $value_suffix $count");

		for($i = 0; $i < $key_start_id + $count; ++$i)
		{
			$row = array();
			$k = $key_prefix . Util::padString($key_start_id + $i, $key_id_len, 'LEFT', '0') . $key_suffix;
			$v = $value_prefix . Util::padString($value_start_id + $i, $value_id_len, 'LEFT', '0') . $value_suffix;

			$row[0] = $k;
			$row[1] = $v;
			$res[] = $row;
		}

		return $res;
	}

	/**
	 * It will reconfigure program for Points Engine by program id
	 * @param unknown_type $program_id
	 */
	static function reConfigureProgramForPointsEngine( $program_id )
	{
		global $logger;
		$logger->info("Calling Re-Configure Program For PointsEngine for Program ID : $program_id");

		try{

			$event_management = new EventManagementThriftClient();
			$status = $event_management->reconfigureProgram( $program_id );

			$logger->info( "Return Result : $status , Output : ".$status->errorMessage );
			return $status;
		}catch( Exception $e ){
			return $e->getMessage();
		}
	}

/**
	 * Accepts html in which every hyper links needs to be replaced by tracker links
	 * @param $html contains Plain HTML
	 * @return returns array that consist converted html and row ids of links has been inserted.
	 */
	static function getHtmlWithTrackerLinks( $html ){

		global $logger;

		$link_ids = array();
		$pattern = '/href=\"([^\"]*)\"/';
		$links = array();
		$db = new Dbase("msging");

		$num_links = preg_match_all( $pattern , $html, $links , PREG_PATTERN_ORDER)."\n";

		$links = $links[1];

		$links = array_unique( $links );

		$num_links = count( $links );

		$new_html = $html;

		$values = array();

		foreach( $links as $link ){

			if( $link != '' || $link != '#'){
				$value = " ( -1 , '" . $link . "' , 0 )";
				array_push($values, $value);
			}
		}

		$values = implode(',', $values);
		$sql = "INSERT INTO `email_links_redirection`( `message_id` , `url` ,`clicks` ) VALUES $values";

		$first_value = $db->insert( $sql );

		if( $first_value )
		{
			$logger->info("Success: $sql");
			$cnt = 0;
			foreach( $links as $link )
			{
				if( $link != '' || $link != '#'){
					$link_ids[ $cnt++ ] = $first_value;

					$str = base64_encode( $first_value );
					$url = "http://intouch.capillary.co.in/linktracker.php?link_id=".urlencode( $str );

					$logger->info("set tracker Link: $url");
					$count = 1;
					$new_html= str_replace( $link , $url , $new_html , $count );

					$first_value++ ;
				}
			}
		}

		return array( $new_html , $link_ids );
	}

	/**
	 * updates Message ID for every links.
	 * @param $message_id represents Message ID that needs to be updated.
	 * @param $link_ids represents link id for which the message id is being updated.
	 */
	static function updateMessageIdForTrackerLinks( $message_id , $link_ids ){

		global $logger;
		if( count($link_ids) > 0 ){

			$logger->info( "Ready for Update Message ID in email_redirection." );
			$link_ids = implode( " , " , $link_ids );
			$sql = "UPDATE `email_links_redirection` SET `message_id` = $message_id
						WHERE `id` IN ( $link_ids ) ";

			$db = new Dbase("msging");
			if( $db->update( $sql ) )
				$logger->info( "Message ID has been updated." );
			else
				$logger->info( "Message ID has updation is failed" );
		}
		else
			$logger->info("There is not any links in this Message.");
	}


        /**
           checks if we should route calls to points engine or not
        **/
        static function canCallPointsEngine()
        {
                global $currentorg, $cfg, $logger;

                $cm = new ConfigManager();
                $points_engine_status = $cm->getKey('CONF_POINTS_ENGINE_STATUS');

                if($cfg['event_framework'] && ($points_engine_status == POINTS_ENGINE_ENABLED || $points_engine_status == POINTS_ENGINE_PASSIVE))
                {
                        $logger->debug("points engine is enabled for org: $currentorg->org_id");
                        return true;
                }

		$logger->debug("points engine is disabled for org: $currentorg->org_id");
                return false;
        }

        /**
           checks if points engine is running in full mode
           and data needs to be overwritten
        **/
        static function isPointsEngineActive()
        {
            global $currentorg, $cfg, $logger;

            $cm = new ConfigManager();
            $points_engine_status = $cm->getKey('CONF_POINTS_ENGINE_STATUS');

            if($cfg['event_framework'] && ($points_engine_status == POINTS_ENGINE_ENABLED))
            {
                $logger->debug("points engine is active.. we can overwrite on the tables");
                return true;
            }
            $logger->debug("points engine is disabled..not overwriting");
            return false;
        }

        /**
        returns the points engine mode of the current org.
         **/
        static function getPointsEngineMode()
        {
        	$cm = new ConfigManager();
        	$points_engine_status = $cm->getKey('CONF_POINTS_ENGINE_STATUS');
        	return $points_engine_status;
        }


        static function convertPointsEngineErrorCode($error_code)
        {
           $errors = array(
                            3301 => ERR_LOYALTY_UNKNOWN,
                            3302 => ERR_LOYALTY_INSUFFICIENT_CURRENT_POINTS,
                            3303 => ERR_LOYALTY_INSUFFICIENT_CURRENT_POINTS,
                            3304 => ERR_LOYALTY_INSUFFICIENT_POINTS,
                            3305 => ERR_LOYALTY_INSUFFICIENT_LIFETIME_POINTS,
                            3306 => ERR_LOYALTY_INSUFFICIENT_LIFETIME_POINTS,
                            3307 => ERR_LOYALTY_INSUFFICIENT_LIFETIME_PURCHASE,
                            3308 => ERR_LOYALTY_REDEMPTION_POINTS_NOT_DIVISIBLE
                          );
           return isset($errors[$error_code]) ? $errors[$error_code] : ERR_LOYALTY_UNKNOWN;
        }

        static function getServerUniqueRequestId()
        {
        	return $_SERVER['UNIQUE_ID'];
        }

        static function replaceXmlCharactersWithOriginalOnes($str)
        {
        	$str=str_replace("&quot;",'"',$str);
        	$str=str_replace("&apos;","'",$str);
        	$str=str_replace("&lt;",'<',$str);
        	$str=str_replace("&gt;",'>',$str);
        	$str=str_replace("&amp;",'&',$str);
        	return $str;
        }

        /**
         * Replace all non ascii characters in the passed string
         *
         */
        static function replaceAllNonAsciiCharacters($str)
        {
        	return preg_replace( '/[^(\x20-\x7F)]*/' , '' , $str );
        }

		static function arrayToXml($array) {
			$xml = new Xml();
			$xml->setupSerializer(false, 'item');
			$serialized = $xml->serialize($array);
			return $serialized;
		}
}
?>
