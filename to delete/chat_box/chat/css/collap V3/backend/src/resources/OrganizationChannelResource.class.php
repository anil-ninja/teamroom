<?php

/**
 * @author Jessy James
 */
require_once 'resources/Resource.interface.php';
require_once 'dao/DAOFactory.class.php';
require_once 'models/DataField.class.php';
require_once 'exceptions/MissingParametersException.class.php';

class OrganizationChannelResource implements Resource {

    private $orgDataFieldDAO;
    private $orgDAO;
    private $channelDAO;
    private $organizationChannels;

    public function __construct() {
	$DAOFactory = new DAOFactory();
	$this->orgDataFieldDAO = $DAOFactory->getOrgDataFieldsDAO();
	$this->orgDAO = $DAOFactory->getOrganizationDAO();
	$this->channelDAO = $DAOFactory->getChannelsDAO();
    }

    public function checkIfRequestMethodValid($requestMethod) {
	return in_array($requestMethod, array('get'));
    }

    public function delete($resourceVals, $data) {
	
    }

    public function put($resourceVals, $data) {
	
    }

    public function post($resourceVals, $data) {
	
    }

    public function get($resourceVals, $data) {
	global $logger;

	$orgId = $resourceVals ['organizations'];
	$channelName = $resourceVals ['channels'];

	if (!isset($orgId))
	    throw new MissingParametersException(
	    "Required parameter 'org_id' is missing; " .
	    "Please check your API URL pattern - /organizations/org_id/channels" .
	    isset($channelName) ? "/channel_name" : "");

	$logger->debug('CHECK - Fetch ORG Details with org_id: ' . $orgId);
	$organizationObj = $this->orgDAO->queryByOrgId($orgId);
	$logger->debug('CHECK - Fetched ORG: ' . $organizationObj->toString());
	$organization = $organizationObj->toArray();

	if (!$organization ['id']) {
	    return array('6105');
	}

	if (isset($channelName)) {
	    //This /organizations/<org_id>/channels/<channel_name> really doesn't make much sense
	    $logger->debug('CHECK - Fetch Channel Details with channel_name: ' . $channelName);
	    $channelObj = $this->channelDAO->queryByChannelName($channelName);

	    if (!is_object($channelObj))
		return array('code' => '6106');

	    $logger->debug('CHECK - Fetched Channel: ' . $channelObj->toString());
	    $channel = $channelObj->toArray();

	    if (!isset($channel ['id']))
		return array('code' => '6106');

	    $result = $this->getOrgChannelDetails($organization, $channel);
	} else {
	    $result = $this->getListOfOrgChannels($organization);
	}

	return $result;
    }

    private function getOrgChannelDetails($org, $channel) {
	global $logger;

	$logger->debug("Fetch OrgChannel Details with OrgId: " .
		$org ['org_id'] . "; ChannelId: " . $channel ['id']);
	$channelObjs = $this->orgDataFieldDAO->queryOrgChannelDetails($org ['org_id'], $channel ['id']);
	$channelObj = $channelObjs [0];
	$logger->debug('Fetched channel: ' . $channelObj->toString());
	$channel = $channelObj->toArray();

	if (!isset($channel ['id']))
	    return array('code' => '6104');

	$this->organizationChannels [] = $channel;

	return array('code' => '6100',
		'data' => array(
			'channels' => $this->organizationChannels
		)
	);
    }

    private function getListOfOrgChannels($org) {
	global $logger;

	$logger->debug("Fetch All OrgChannels with OrgId: $orgId");
	$channelObjs = $this->orgDataFieldDAO->getListOfChannelsOfOrg($org ['org_id']);

	if (empty($channelObjs))
	    return array('code' => '6104');

	foreach ($channelObjs as $channelObj) {
	    $channel = $channelObj->toArray();
	    $this->channels [] = $channel;
	}
	$logger->debug('Fetched list of Channels: ' . json_encode($this->channels));

	return array('code' => '6100',
		'data' => array(
			'channels' => $this->channels
		)
	);
    }

    private function sanitize($data) {
	
    }

}
