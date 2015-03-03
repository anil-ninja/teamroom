<?php
class BaseThriftClient {
	protected $class;
	protected $thrift_module;
	protected $transport;
	protected $client;
	protected $logger;
	
	function __construct() {
		global $logger;
		$this->logger = $logger;
		$class = get_class($this);
		$this->class = $class;
		if (preg_match("/([\w]*)ThriftClient/", $class, $args)) {
			$this->thrift_module = strtolower(trim($args[1]));
		}
		$this->logger->debug("Initialized the thrift-module: $this->thrift_module");
		$this->include_file('thrift_base.php');
		$this->logger->debug("returning");
	}
	
	protected function include_file($file) {
		$old_error = error_reporting('E_NONE');
		require_once $file;
		error_reporting($old_error);
		//print "<br />Error reporting after including $file: [should be $old_error] ".error_reporting($old_error);
	}
	
	protected function get_client($name, $timeout=0) {
		try {
		list($this->transport, $this->client) = getThriftServiceClient($name, $timeout);
    } catch (Exception $e) {
			return array(null, null);
		}
	}
	
}
?>
