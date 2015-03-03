<?php

	/**
	 * @author Jessy James
	 */
    
    require_once 'exceptions/ApiException.class.php';
    require_once 'utils/Array2XML.php';
	
    class ResponseHandler {
	
		public static function respond ($rawResponse, $format, $debug) {
		    
		    global $logger, $warnings_payload;

		    $httpStatusCode 		= $rawResponse ['httpStatusCode'];
		    $httpStatusCodeMessage 	= $rawResponse ['httpStatusCodeMessage'];
		    $otherHeaders	 		= $rawResponse ['otherHeaders'];
		    $internalStatusCode		= $rawResponse ['code'];
		    $internalStatusMessage	= $rawResponse ['message'];
		    $warnings				= $warnings_payload;
		    $resourceData 			= $rawResponse ['data'];

		    $response = array();
		    if ($httpStatusCode == 500) {
		    	$response ['internal_status'] = array(
				    		'code' => $httpStatusCode, 
				    		'message' => $httpStatusCodeMessage 
		    	);
		    } else {
		    	$response ['internal_status'] = array(
				    		'code' => $internalStatusCode, 
				    		'message' => $internalStatusMessage
		    	);
		    	if (! empty($warnings)) 
		    		$response ['warnings'] = implode(', ', $warnings);

		    	//TO-DO: Remove "data" key in response; directly show resource list
		    	if (! empty($resourceData))
		    		$response ['data'] = $resourceData;

		    	if ($debug)
		    		$response ['logs'] = $logger -> getEntries();
		    }

			ob_clean();
			ob_start();
			$logger -> debug("***** Result: " . json_encode($response));

			/* Set HTTP Status header */
			$statusHeader = 'HTTP/1.0 ' . $httpStatusCode . ' ' . $httpStatusCodeMessage;
			header($statusHeader);
			header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Credentials: true"); 
            header('Access-Control-Allow-Headers: X-Requested-With');
            header('Access-Control-Allow-Headers: Content-Type');
            header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
            header('Access-Control-Max-Age: 86400'); 


			/* Set Other headers, if any */
			if (isset($rawResponse ['otherHeaders'])) {
				foreach($otherHeaders as $header) {
					header($header);
				}
			}

			if(isset($format) && ($format == 'xml')) {
				header('Content-type:text/xml; charset=utf-8');
				$xml = Array2XML :: createXML('response', $response);
				$result = trim($xml -> saveXML());
			} else if(isset($format) && ($format == 'json')){
				header('Content-type:application/json; charset=utf-8');

				$result = trim(json_encode($response));
			} else {
				$result = serialize($response);
			}

			echo $result;

			$logger -> debug("Buffering: " . var_export (ob_get_status (true), true));
			if(ob_get_length() > 0) {
				ob_end_flush();
				ob_flush();
				flush();
			}

			return $result;
		}
    }