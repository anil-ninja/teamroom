<?php
require_once "utils/ThriftBase.php";

class NSAdminThriftClient extends BaseThriftClient
{
	function __construct() {
		parent::__construct();

		$this->logger->debug("nsadmin: " . get_include_path());

		$this->include_file('nsadmin/nsadmin_types.php');
		$this->include_file('nsadmin/NSAdminService.php');
		$this->logger->debug("nsadmin: ready");
		try {
			$this->get_client('nsadmin', 120000);
		} catch (Exception $e) {
			$this->logger->error("Exception caught while trying to connect");
		}
	}

	public function getStatus() {
		try {
			# Send using NSADMIN
			$this->transport->open();
			$ret = $this->client->getStatus();
			$this->transport->close();
		} catch (TException $te) {
			$this->logger->error("Exception: ".$te->getMessage());

			//$this->transport->close();
			return false;
		} catch(Exception $e) {
			$this->logger->error("Exception: ".$e->getMessage());
			try {
				$this->transport->close();
			} catch (Exception $e) {
				//do nothing
			}
			return false;
		}
		return $ret;
	}

	/**
	 *
	 * @param $type The type from - enum ('SMS', 'EMAIL', 'IM')
	 * @param $to
	 * @param $msg
	 * @param $sender_org_id
	 * @param $priority
	 * @param $gsm_sender
	 * @param $cdma_sender
	 * @return unknown_type
	 */
	private function createMessageObject(
		$type, $to, $msg, $sender_org_id = 0, $priority, $gsm_sender, $cdma_sender,
		$truncate, $scheduled_time, $cc, $body, $sender_label, $replyto_email, $gateway = false, $is_immediate = false, $attached_file_id = -1,
		$tags = array(), $campaignId = -1, $ndnc = false
	){
		$m = new nsadmin_Message();
		$m->clientId = NSADMIN_CLIENT_ID;
		$m->message = $msg;
		$m->messageClass = strtoupper(trim($type));
		$m->receiver = $to;
		//$m->sender = '"'.$sender_label.'" <'.$replyto_email.'>';
		$m->sender = '"'.$sender_label.'" <noreply@intouch-mailer.com>, <'.$replyto_email.'>';
		$m->sendingOrgId = $sender_org_id;
		$m->priority = strtoupper(trim($priority));
		$m->gsmSenderId = $gsm_sender;
		$m->cdmaSenderId = $cdma_sender;
		$m->truncate = $truncate;
		$m->ccList = $cc;
		$m->body = $body;
		$m->scheduledTimestamp = strtotime($scheduled_time) * 1000;
		$m->gateway = $gateway;
		$m->immediate = $is_immediate;
		$m->attachmentId = $attached_file_id;
		$m->campaignId = $campaignId;
		$m->tags = $tags;
		$m->ndnc = $ndnc;
		return $m;
	}

	public function makeSendMessageCall($to, $from_org_id, $message, $priority, $sender_gsm, $sender_cdma, $truncate, $scheduled_time, $gateway, $is_immediate, $tags = array(), $ndnc = false,  $campaign_id = -1){
		$m = $this->createMessageObject('SMS', $to, $message, $from_org_id, $priority, $sender_gsm, $sender_cdma, $truncate, $scheduled_time, '', '', '', '', $gateway,
										$is_immediate, -1, $tags, $campaign_id, $ndnc);

		try {
			# Send using NSADMIN
			$this->transport->open();


			$this->logger->debug("nsadmin client: " . get_class($this->client));

			$ret = $this->client->sendMessage($m);
			$this->transport->close();
		} catch (TException $te) {
			$this->logger->error("NSAdmin Exception: ".$te->getMessage());

			//$this->transport->close();
			return false;
		} catch(Exception $e) {
			$this->logger->error("NSAdmin Exception: ".$e->getMessage());
			try {
				$this->transport->close();
			} catch (Exception $e) {
				//do nothing
			}
			return false;
		}
		return $ret;
	}

	public function makeSendMultipleMessagesCall($msgs){

		try {
			# Send using NSADMIN
			$this->transport->open();


			$this->logger->debug("nsadmin client: " . get_class($this->client));

			$ret = $this->client->sendMultipleMessages($msgs);
			$this->transport->close();
		} catch (TException $te) {
			$this->logger->error("NSAdmin Exception: ".$te->getMessage());

			//$this->transport->close();
			return false;
		} catch(Exception $e) {
			$this->logger->error("NSAdmin Exception: ".$e->getMessage());
			try {
				$this->transport->close();
			} catch (Exception $e) {
				//do nothing
			}
			return false;
		}
		return $ret;
	}

	public function doSendEmailMessage($to, $cc, $from_org_id, $message, $body, $priority, $truncate, $sender_label, $replyto_email, $attached_file_id = -1, $tags = array(), $schedule_time) {
		$m = $this->createMessageObject('EMAIL', $to, $message, $from_org_id, $priority, '', '', $truncate, $schedule_time, $cc, $body, $sender_label, $replyto_email, '', 0, $attached_file_id, $tags );

		try {
			# Send using NSADMIN
			$this->transport->open();


			$this->logger->debug("nsadminattached id: " . $m->attachmentId);
			$ret = $this->client->sendMessage($m);
			$this->transport->close();
		} catch (TException $te) {
			$this->logger->error("Exception: ".$te->getMessage());

			//$this->transport->close();
			return false;
		} catch(Exception $e) {
			$this->logger->error("Exception: ".$e->getMessage());
			try {
				$this->transport->close();
			} catch (Exception $e) {
				//do nothing
			}
			return false;
		}
		return $ret;
	}

	/**
	 * Replaces Sender ID
	 * @param $to
	 * @param $from_org_id
	 * @param $message
	 * @param $priority
	 * @param $truncate
	 * @return unknown_type
	 */
	private function sendMessage($to, $from_org_id, $message, $priority = 'DEFAULT', $truncate, $scheduled_time, $gateway, $is_immediate, $tags, $ndnc, $campaign_id) {

		# Find Sender
		$db = new Dbase('users');
		$sql = "SELECT * FROM custom_sender WHERE org_id = '$from_org_id'";
		$row = $db->query_firstrow($sql);
		$gsm = Util::valueOrDefault($row['sender_gsm'], "CAPLRY");
		$cdma = Util::valueOrDefault($row['sender_cdma'], "919874400500");
		# Create object

		$this->logger->debug("nsadmin gsm: $gsm");
		$this->logger->debug("nsadmin cdma:  $cdma");

		return $this->makeSendMessageCall($to, $from_org_id, $message, $priority, $gsm, $cdma, $truncate, $scheduled_time, $gateway, $is_immediate, $tags, $ndnc, $campaign_id);
	}

	/**
	 * Creates a message object that NSADmin accepts
	 * @param $priority enum ('DEFAULT', 'HIGH');
	 */
	function sendSMS($to, $from_org_id, $message, $priority = 'DEFAULT', $truncate = false, $scheduled_time = '',
					 $override_gateway = false, $is_immediate = false, $tags = array(), $ndnc, $campaign_id = -1) {
		global $logger;
		$logger->debug("Sending SMS through NSAdmin");
		//error_reporting(E_ALL);
		Util::checkMobileNumber($to);
		$scheduledTime_8601 = Util::serializeInto8601($scheduled_time);
		$this->logger->debug("nsadmin scheduled8601: $scheduledTime_8601 . " . strtotime($scheduledTime_8601));
		$gateway = '';
		if($override_gateway){
			$gateway = Util::getOverrideGateway();
		}

		$ret = $this->sendMessage($to, $from_org_id, $message, $priority, $truncate, $scheduledTime_8601, $gateway, $is_immediate, $tags, $ndnc, $campaign_id);
		$this->logger->debug("Sent SMS: $ret $message");
		return $ret;
	}


	// handle sender_gsm sender_cdma beforehand
	function createMessageObjectForMultipleSMS($to, $from_org_id, $message, $sender_gsm='CAPILLARY', $sender_cdma='919874400500', $priority = 'DEFAULT', $truncate = false, $scheduled_time = '',
					 $override_gateway = false, $is_immediate = false, $tags = array(), $campaign_id = -1){

		Util::checkMobileNumber($to);
		$scheduledTime_8601 = Util::serializeInto8601($scheduled_time);
		$gateway = '';
		if($override_gateway){
			$gateway = Util::getOverrideGateway();
		}

		return $this->createMessageObject('SMS', $to, $message, $from_org_id, $priority, $sender_gsm, $sender_cdma, $truncate, $scheduled_time, '', '', '', '', $gateway,
										$is_immediate, -1, $tags, $campaign_id);
	}


	/**
	 * Sends out a bulk SMS. Implodes the list of senders into a String separated by commas. This is always sent with Default Priority
	 * @param $to
	 * @param $from_org_id
	 * @param $message
	 * @return unknown_type
	 */
	function sendBulkSMS($to_list, $from_org_id, $message) {
		$numbers = array();
		if (!is_array($to_list)) {
			$to_list = array($to_list);
		}
		foreach ($to_list as $to) {
			array_push($numbers, $to);
		}
		$to = implode(', ', $numbers);

		$ret = $this->sendMessage($to, $from_org_id, $message, 'DEFAULT');

		$this->logger->debug("Bulk Message Queued");
		return $ret;
	}


	/**
	 * Creates a message object that NSADmin accepts
	 * @param $priority enum ('DEFAULT', 'HIGH');
	 */
	function sendEmail($to, $cc, $from_org_id, $message, $body, $priority = 'DEFAULT', $truncate = false, $attached_file_id = -1 , $tags = array(), $schedule_time)
	{
		//Util::checkEmailAddress($to);
		# Find Sender
		$db = new Dbase('users');
		$sql = "SELECT * FROM custom_sender WHERE org_id = '$from_org_id'";
		$row = $db->query_firstrow($sql);
		$sender_label = Util::valueOrDefault($row['sender_label'], "Capillary Intouch");
		$replyto_email = Util::valueOrDefault($row['replyto_email'], "noreply@intouch-mailer.com");
		# Create object
		$ret  = $this->doSendEmailMessage($to, $cc, $from_org_id, $message, $body, $priority, $truncate, $sender_label, $replyto_email, $attached_file_id, $tags, $schedule_time);
		if($ret !== false)
		$this->logger->debug("Sent Email");
		return $ret;
	}


	/**
	 * Creates a message object that NSADmin accepts
	 * @param $priority enum ('DEFAULT', 'HIGH');
	 */
	function getMessageDistribution($to, $from_org_id, $message, $priority = 'DEFAULT', $tags = array(), $campaign_id = -1)
	{
		$db = new Dbase('users');
		$sql = "SELECT * FROM custom_sender WHERE org_id = '$from_org_id'";
		$row = $db->query_firstrow($sql);
		$gsm = Util::valueOrDefault($row['sender_gsm'], "CAPILLARY");
		$cdma = Util::valueOrDefault($row['sender_cdma'], "919874400500");

		$m = $this->createMessageObject('SMS', $to, $message, $from_org_id, $priority, $gsm, $cdma, false, $scheduled_time, '',
										'', '', '', '', '', '', $tags, $campaign_id);

		try {
			# Send using NSADMIN

			$this->logger->debug("starting distribution");

			$this->transport->open();
			$ret = $this->client->chooseGateways($m);
			$this->logger->debug("***  return: " . print_r($ret, true));

			$this->transport->close();
		} catch (TException $te) {
			$this->logger->error("NSAdmin Exception: ".$te->getMessage());
			throw new Exception("Error in NSAdmin: " . $te->getMessage(), -500);
		} catch(Exception $e) {
			$this->logger->error("NSAdmin Exception: ".$e->getMessage());
			try {
				$this->transport->close();
			} catch (Exception $e) {
				//do nothing
			}
			return false;
		}
		return $ret;

	}


	/**
		This will reload only the configs of the gateways
	**/
	public function reloadConfig() {
		try {
			# Send using NSADMIN
			$this->transport->open();
			$this->logger->debug("nsadmin: sending thrift call for reloadConfig");
			$ret = $this->client->reloadConfig();
			$this->transport->close();
		} catch (TException $te) {
			$this->logger->error("nsadmin TException in reloadConfig: ". $te->getMessage());

			//$this->transport->close();
			return false;
		} catch(Exception $e) {
			$this->logger->error("nsadmin Exception in reloadConfig: ". $e->getMessage());
			try {
				$this->transport->close();
			} catch (Exception $e) {
				//do nothing
			}
			return false;
		}
		return true;
	}

	/**
		This will reload the gateway information as well
	**/
	public function reloadGateways() {
		try {
			# Send using NSADMIN
			$this->transport->open();
			$this->logger->debug("nsadmin sending thrift call for reloadGateways");
			$ret = $this->client->reloadGateways();
			$this->transport->close();
		} catch (TException $te) {
			$this->logger->error("nsadmin : TException in reloadGateways: ".$te->getMessage());

			//$this->transport->close();
			return false;
		} catch(Exception $e) {
			$this->logger->error("nsadmin : Exception in reloadGateways: ".$e->getMessage());
			try {
				$this->transport->close();
			} catch (Exception $e) {
				//do nothing
			}
			return false;
		}
		return true;
	}

	/**
	 * Message Delivery notification method
	 * @author
	 */
	public function reportMessageDelivered( $msgRefId, $receiver, $status, $response ){

		try{
			$this->transport->open();

			$this->logger->debug("nsadmin client: " . get_class($this->client));
			$this->logger->debug("adding the message report, $msgRefId, $receiver, $status, $response");
			$this->client->reportMessageDelivered($msgRefId, $receiver, $status, $response);

			$this->transport->close();

		}catch(Exception $e){
			$this->logger->error('Error :'.$e->getMessage());
			$this->transport->close();
		}
	}
}
?>
