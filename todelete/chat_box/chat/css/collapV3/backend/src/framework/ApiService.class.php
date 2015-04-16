
<?php

	/**
	 * @author Rahul Lahoria (rahul_lahoria@yahoo.com)
	 */

	require_once 'utils/Util.php';
	require_once 'utils/Timer.php';
	require_once 'utils/ShopbookLogger.php';
	require_once 'cache/AppCacheRegistry.class.php';
	require_once 'exceptions/ApiException.class.php';
	require_once 'exceptions/UnauthorizedException.class.php';
	require_once 'framework/RequestParser.class.php';
	require_once 'framework/RequestHandler.class.php';
	require_once 'framework/ResponseHandler.class.php';	

	//require_once 'auth/Auth.class.php';	

	class ApiService {

		private static $pageTimer;

		/* Intial setup logic */
		public static function setup() {

			/* Setting up the app-configurations globally for use across classes */
			global $configs;
			$configs = json_decode (file_get_contents('collap-configs.json'), true);
			//var_dump($configs); die();
			/* Setting up the logger globally for use across classes */
			global $logger;
			$logger = new ShopbookLogger();
			$logger -> enabled = true;
			$logger -> debug ("Setting up ...");

			/* Setting up the cache object globally for use across classes */
			global $cache;
			$cache = AppCacheRegistry :: getCacheObject('redis');

			/* Setting up the warnings payload as a global variable to be able 
			to dump warnings along the API flow */
			global $warnings_payload;

			/* Logging API stats */
			$memoryUsage = memory_get_usage (true) / (1024 * 1024); 
			$cpuLoad = Util :: ServerLoad ();
			self :: $pageTimer = new Timer ('page_timer');
			self :: $pageTimer -> start ();
			$logger -> debug ("Init Memory: $memoryUsage MB; Init CPU: $cpuLoad%");	
		}

		/* Parse and process request */
		public static function processRequest() {
			global $logger;
			$request = $rawResponse = $response = null;

			try {
				/* Authenticate */
				$valid = self :: authenticateRequest($_SERVER); 

				/* Fetch POST data */
				$post = file_get_contents ("php://input");
				$logger -> debug ("POST Data Received: " . $post);

				/* Formulate the request object */
				$request = RequestParser :: parseInput ($_SERVER, $_GET, $post);				
				$logger -> debug ("REQUEST Object: " . $request -> toString());

				/* Handle the request */
				$rawResponse = RequestHandler :: process ($request);
				$logger -> debug ("RESPONSE Object: " . json_encode($rawResponse));

			} catch (ApiException $e) {
				/* Generate response from Exception details */
				$logger -> error ("ApiException encountered!! " . $e -> toString());
				$rawResponse = array(
					'httpStatusCode'		=> $e -> getHttpStatusCode(),
					'httpStatusCodeMessage' => $e -> getHttpStatusCodeMessage(),
					'otherHeaders'			=> $e -> getOtherHeaders(), 
					'code'					=> $e -> getCode(),
					'message'				=> $e -> getMessage(),
					'debug'					=> false,
					'data'					=> null
				);
			}

			// Format the $rawResponse variable and output 
			$format = (! isset($request) ? 'json' : $request -> getFormat());
			$debug = (! isset($request) ? false : $request -> getDebug());
			$response = ResponseHandler :: respond ($rawResponse, $format, $debug);
			$logger -> debug ("Output: " . $response);
		}

		/* Intial setup logic */
		public static function cleanup() {
			global $logger;
			
			if ($request) {
				$resource = $request -> getResource ();
				$action = $request -> getResourceMethod ();
				$logger -> debug ("EXECUTED:  $resource/$action, " . $username);
			}
			$logger -> debug ("Peak Memory used: ". (memory_get_peak_usage()/ 1000000)." MB");

			self :: $pageTimer -> stop ();
			$pageTime = self :: $pageTimer -> getTotalElapsedTime ();

				//Taking pageTime as total time for an api call too
			$gbl_item_total_time = $pageTime;
			$logger -> debug ("Time Taken: " . $gbl_item_total_time);
		}

		/* HTTP Basic authentication */
		public static function authenticateRequest($server) {
			global $logger;
			
		}
	}