	<?php
    
	/**
	 * @author rajnish
	 */
    
    require_once 'ResourceRegistryFactory.class.php';
    require_once 'utils/Array2XML.php';
	
    class RequestHandler {
	
		public static function process ($request) {
			global $logger;

			$apiVersion = $request -> getApiVersion();
			$resourceType = $request -> getResourceType();
			$resourceVals = $request -> getResourceVals();
			$method = $request -> getMethod();
			$data = $request -> getData();

			$logger -> debug ("Fetching ResourceRegistry for API version: $apiVersion");
			$resourceRegistry = ResourceRegistryFactory :: 
									getResourceRegistryByVersion($apiVersion);
			$logger -> debug ("Fetched ResourceRegistry: " . json_encode($resourceRegistry));
			
			$logger -> debug ("Fetching Resource for ResourceType: $resourceType");
			$resource = $resourceRegistry -> lookupResource($resourceType);
			$logger -> debug ("Fetched Resource: " . get_class($resource));
			
			if ($method == 'options'){
				$response = '';
				return $response;
			}

			$validRequestMethod = $resource -> checkIfRequestMethodValid($method);
			if (! $validRequestMethod) {
				require_once "exceptions/UnsupportedResourceMethodException.class.php";
				throw new UnsupportedResourceMethodException();
			}

			$result = $resource -> $method($resourceVals, $data, $userId);
			$code = $result ['code'];
			$message = $result ['message'];
			$message = (isset($message) ? "; $message" : '');
			$data = $result ['data'];
			
			$response = array(
				'httpStatusCode'=> trim(InternalStatuses :: $list [$code] ['httpStatusCode']),
				'code' 			=> $code, 
				'message' 		=> trim(InternalStatuses :: $list [$code] ['message']) . $message
            );
            if (! empty($data))
            	$response ['data'] = $result ['data'];

			return $response;
		}
    }