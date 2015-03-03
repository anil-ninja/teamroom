<?php
/**
 * @package Logger
 * Used as a logger, can turn on or off file level and view level logging.
 */
define('LOG4PHP_DIR', "log4php");
if (!defined('LOG4PHP_CONFIGURATION')) {
    define('LOG4PHP_CONFIGURATION', "log4php.properties");
}
require_once(LOG4PHP_DIR . '/LoggerManager.php');
require_once(LOG4PHP_DIR . '/LoggerNDC.php');

class LogEntry {

    var $level;
    var $msg;
    var $stack;
    var $timestamp;
    var $memory_usage;
    var $log4php;

    //new vars (2)
    //var $moduletime;
    //var $modulemem;

    function __construct($level, $msg, $stack, $timestamp, $memory_usage) {


	//error_log("in constructor of entry");
	$this->level = $level;
	$this->msg = $msg;
	$this->stack = $stack;
	$this->timestamp = $timestamp;
	$this->memory_usage = $memory_usage;
	ini_set('memory_limit', '250M');
    }

    static function getHeader() {
	return <<<EOT
		<tr>
			<th>Level</th>
			<th>Stack</th>
			<th>Timestamp</th>
			<th>Memory</th>
			<th>Message</th>
		</tr>
EOT;
    }

    function __toString() {
	return "$stack[1][file]:$stack[1][line] - $msg";
    }

    function getStackElement($st, $str, $key) {
	$str .= "$key. [$st[file]:$st[line]] $st[class]::$st[function](";

	if (isset($st[params]) && is_array($st[params])) {
	    $params = array();
	    foreach ($st[params] as $pkey => $pval) {

		if (is_object($pval))
		    $pval = "objectof-" . $pval->getClass();

		$pval = strlen($pval) > 30 ? substr($pval, 0, 30) : $pval;

		array_push($params, "$pkey=$pval");
	    }
	    $str.= implode(', ', $params);
	}
	return $str;
    }

    function getStack($str, $arr) {
	foreach ($arr as $key => $st) {
	    if ($st['class'] == 'ShopbookLogger')
		continue;
	    $str = $this->getStackElement($st, $str, $key);
	    $str.= ")\n";
	}
	return $str;
    }

    function getEntry() {

	$level = ShopbookLogger::$levels[$this->level];
	$msg = wordwrap($this->msg, 50, "\n");
	if (is_array($this->stack)) {
	    $str = "";
	    $arr = array_reverse($this->stack, true);
	    $stack_depth = 0;
	    foreach ($arr as $key => $st) {
		$stack_depth++;

		if ($stack_depth > 3)
		    break;
		if ($st['class'] == 'ShopbookLogger')
		    continue;
		$str .= "$key. [$st[file]:$st[line]] $st[class]::$st[function](";
		if (isset($st[params]) && is_array($st[params])) {

		    $params = array();
		    foreach ($st[params] as $pkey => $pval) {
			if (is_object($pval))
			    $pval = "objectof-" . $pval->getClass();
			$pval = strlen($pval) > 30 ? substr($pval, 0, 30) : $pval;
			array_push($params, "$pkey=$pval");
		    }
		    $str.= implode(', ', $params);
		}
		$str .= ")\n";
	    }
	    $stack = $str;
	} else
	    $stack = $this->stack;

	$stack = wordwrap($stack, 60, "\n");
	//$memory_usage = sprintf("%.3f MB", ($this->memory_usage / 1000000));
	//$timestamp = sprintf("%.3f ms", $this->timestamp * 1000);
	$memory_usage = $this->memory_usage / 1000000;
	$timestamp = $this->timestamp * 1000;
	return <<<EOT
		<tr>
		<td>$level</td>
		<td><pre>$stack</pre></td>
		<td>$timestamp ms</td>
		<td>$memory_usage MB</td>
		<td><pre>$msg</pre></td>
		</tr>
EOT;
    }

}

class ShopbookLogger {

    var $enabled = false;
    var $printed = false;
    private $level = self::NONE;
    private $l4plogger;
    private $entries;

    const ALL = 100;
    const DEBUG = 50;
    const SQL = 35;
    const INFO = 25;
    const WARN = 10;
    const ERROR = 5;
    const NONE = 0;

    static public $levels = array(self::ALL => 'ALL', self::DEBUG => 'DEBUG', self::SQL => 'SQL', self::INFO => 'INFO', self::WARN => 'WARN', self::ERROR => 'ERROR', self::NONE => 'NONE');

    function __construct() {
	//read enabled and level from config file
	$this->enabled = false;
	$this->level = self::ALL;
	$this->entries = array();
	$this->l4plogger = & LoggerManager::getLogger('');
	LoggerNDC::push($_SERVER['UNIQUE_ID']);
    }

    function __destruct() {
	if ($this->enabled && function_exists("xdebug_is_enabled") && xdebug_is_enabled()) {
	    
	}
	LoggerNDC::pop();
	LoggerManager::shutdown();
    }

    private function log($level, $message) {
	//return;		
	//error_log("hello buddy in log()");
	global $cfg;

	if (!$this->enabled)
	    return;

	if (function_exists("xdebug_is_enabled") && xdebug_is_enabled()) {
	    //print "$level: $message";
	    //print_r(debug_backtrace(), true);
	    //using the xdebug version is failing with Canary Mismatch error
	    ///$stack = xdebug_get_function_stack();
	    $stack = debug_backtrace();
	    $time = xdebug_time_index();
	    $mem = xdebug_memory_usage();

	    $entry = new LogEntry($level, $message, $stack, $time, $mem);
	    //error_log("finally here?");
	} else {

	    $bt = debug_backtrace();

	    //print_r($bt);
	    // get class, function called by caller of caller of caller
	    $cl_f_msg = "";
	    if (isset($bt[2])) {
		$class = isset($bt[2]['class']) ? $bt[2]['class'] : "";
		$function = isset($bt[2]['function']) ? $bt[2]['function'] : "";

		$cl_f_msg = ":$class::$function";
	    }
	    // get file, line where call to caller of caller was made
	    $file = $bt[1]['file'];
	    $file = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
	    $line = $bt[1]['line'];

	    // build & return the message
	    $back_trace = "$file:$cl_f_msg:$line ";

	    $entry = new LogEntry($level, $message, $back_trace, 0, 0);
	}

	if ($cfg['servertype'] != 'prod')
	    array_push($this->entries, $entry);
    }

    public function logException(Exception $exception, $level) {

	global $cfg;

	$level = strtoupper($level);
	if ($cfg['servertype'] == 'dev') {

	    $msg = "' with message '" . $exception->getMessage() .
		    "' in " . $exception->getFile() . ":" . $exception->getLine() .
		    "\nStack trace:\n" . $exception->getTraceAsString();

	    $this->debug($msg);
	} else {


	    switch ($level) {

		case 'WARN' :

		    break;

		case 'FATAL' :

		    break;

		case 'INFO' :

		    break;
	    }
	}
    }

    public function logCustomexception($exception, $level) {

	global $cfg;
	$level = strtoupper($level);
	if ($cfg['servertype'] == 'dev') {
	    $msg = $exception->__toString();
	    $this->debug($msg);
	} else {
	    switch ($level) {
		case 'WARN' :
		    break;
		case 'FATAL' :
		    break;
		case 'INFO' :
		    break;
	    }
	}
    }

    function warn($message) {
        $this->log(self::WARN, $message);
        $logEntry = end($this->entries);
        $message = str_replace("\n", chr(248), $logEntry->stack . ' - ' . $message);
        if ($this->l4plogger)
            $this->l4plogger->warn($message);
    }

    function debug($message) {
	$this->log(self::DEBUG, $message);
	$logEntry = end($this->entries);
	$message = str_replace("\n", chr(248), $logEntry->stack . ' - ' . $message);
	if ($this->l4plogger)
	    $this->l4plogger->debug($message);
    }

    function info($message) {
	$this->log(self::INFO, $message);
	$logEntry = end($this->entries);
	$message = str_replace("\n", chr(248), $logEntry->stack . ' - ' . $message);
	if ($this->l4plogger)
	    $this->l4plogger->info($message);
    }

    function error($message) {
	$this->log(self::ERROR, $message);
	$logEntry = end($this->entries);
	$message = str_replace("\n", chr(248), $logEntry->stack . ' - ' . $message);
	if ($this->l4plogger)
	    $this->l4plogger->error($message);
    }

    function sql($message) {
	$this->log(self::SQL, $message);
	$logEntry = end($this->entries);
	$message = str_replace("\n", chr(248), $logEntry->stack . ' - ' . $message);
	if ($this->l4plogger)
	    $this->l4plogger->warn($message); // todo create custom SQL level
    }

    function printLog() {

	if ($this->enabled && !$this->printed) {
	    echo "<h2>Log: " . $this->getLevel() . "</h2><pre>";
	    echo $this->fetchLog();
	    echo "</pre>";
	    $this->printed = true;
	}
    }

    function getEntries() {
        return $this -> entries;
    }

    function fetchLog() {
	global $cfg;
	if ($cfg['servertype'] == 'prod')
	    return "";
	if ($this->enabled) {
	    $this->printed = true;
	    ob_start();
	    ?>
	    <div id="log">
	        <table id="log" border="1" summary="table">
	    	<thead>
			<?php print LogEntry::getHeader() ?>
	    	</thead>
	    	<tbody>
			<?php
			for ($i = count($this->entries) - 1; $i >= 0; $i--) {
			    $row = $this->entries[$i];
			    print $row->getEntry();
			}
			?>
	    	    <tr>
			    <?php
			    $peak_mem = sprintf("%.3f MB", memory_get_peak_usage() / 1000000);
			    $memory_limit = ini_get('memory_limit');
			    if (function_exists("xdebug_is_enabled") && xdebug_is_enabled()) {
				$time_in_db = Dbase::get_all_timer_info();
				$time = sprintf("%.3f ms", xdebug_time_index() * 1000);
			    }
			    echo <<<EOT
		<pre>
		Final Debugging Info
		Total time taken      : $time
		Peak Memory Used      : $peak_mem
		Time spend in DB      : $time_in_db
		Memory Limit          : $memory_limit;
		</pre>
EOT;
			    ?>
	    	    </tr>
	    	</tbody>
	        </table>
	    </div>
	    <?php
	    return ob_get_clean();

	    //return  "Log: ".$this->getLevel()."\n".str_replace("<br />","\n", $this->msg)." ";
	}
    }

    function getLevel() {
	return ShopbookLogger::$levels[$this->level];
    }

    /**
     * Loads the appropriate function for loading log4php subclasses. If the
     * classname matches the key, then do a preg_replace with the value. Otherwise
     * return the default result (i.e. at root dir)
     */
    public static function Log4phpLoader($classname) {
	static $l4phpmap = array(
		"/^LoggerDOMConfigurator$/" => "/xml/LoggerDOMConfigurator",
		"/^LoggerAppender([\w]+)$/" => "/appenders/LoggerAppender\${1}",
		"/^LoggerLayout([\w]+)$/" => "/layouts/LoggerLayout\${1}"
	); // todo make this a class static instead of function static

	foreach ($l4phpmap as $key => $value) {
	    if (preg_match($key, $classname) != 0)
		return (LOG4PHP_DIR . preg_replace($key, $value, $classname) . ".php");
	}
	return (LOG4PHP_DIR . "/$classname.php");
    }

}
?>
