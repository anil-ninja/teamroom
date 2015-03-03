<?php

/**
 * @author Jessy James
 */
require_once 'utils/XML2Array.php';
require_once 'models/Request.class.php';

class RequestParser
{
    
    private $request;
    
    public static function parseInput($server, $get, $post) {
        global $logger;
        
        /* Fetch request method */
        $method = strtolower($server['REQUEST_METHOD']);
        $logger -> debug("HTTP Method: " . $method);
        
        /* Fetch Protocol */
        $protocol = ($server['SERVER_PORT'] == 443) ? 
        				'https' : 
        				($server['SERVER_PORT'] == 80 ? 'http' : '');
        $logger -> debug("Request protocol: " . $protocol);
        
        /* Fetch URL */
        $requestUrl = strtolower($server['REQUEST_URI']);
        $logger -> debug("Request URL: " . $requestUrl);
        
        $urlComponents = parse_url($server["REQUEST_URI"]);
        $path = trim($urlComponents['path'], "/");
        $queryString = $urlComponents['query'];
        $pathComponents = explode("/", $path, 2);
        
        /* Fetch auth credentials */
        $authCredentials = array(
            'username' => $server["PHP_AUTH_USER"], 
            'password' => $server['PHP_AUTH_PW']
        );
        $logger -> debug("Request URL: " . json_encode($authCredentials));

        $debug = ($get['debug'] === 'true') ? true : false;
        unset($get ['debug']);
        $logger -> debug("Debug? " . (int) $debug);
        
        /* Fetch version */
        $version = $pathComponents[0];
        $logger -> debug("Version: " . $version);
        
        /* Commenting out the line below - not supporting .format pattern for now
         since data-field's will contain '.' symbol */
        
        //$resourceAndFormat = explode('.', $pathComponents[1], 2);
        
        /* Fetch format */
        $format = (!empty($get['format'])) ? strtolower($get['format']) : 'json';
        
        //$format = (isset($resourceAndFormat [1])) ? $resourceAndFormat [1] : $format;
        $logger -> debug("Format: " . $format);
        
        /* Fetch resourceType and resourceVals */
        
        //$resource = $resourceAndFormat [0];
        $resource = $pathComponents[1];
        $resources = explode('/', $resource);
        for ($i = 0; $i < count($resources); $i++) {
            
            /* An even number index shall be a resource-name and
             an odd number index shall be the resource-name's ID */
            if ($i % 2 == 0) {
                $resourceType.= "/" . $resources[$i];
                $resourceVals[$resources[$i]] = $resources[$i + 1];
            }
        }
        $logger -> debug("Resource Type: " . $resourceType);
        $logger -> debug("Resource Values: " . json_encode($resourceVals));
        
        /* Set rawdata */
        $rawData = array(
            'get' => $get, 
            'post' => $post
        );
        $logger -> debug("Request Vars: " . json_encode($rawData));
        
        $data = array();
        switch ($method) {
            case 'get':
            case 'delete':
                $logger -> debug("Parsing GET data ...");
                $data = $get;
                $logger -> debug("Parsed GET data: " . json_encode($data));
                break;

            case 'post':
            case 'put':
                $resourceVals ['get'] = $get;
                $resourceVals ['request_id'] = $_SERVER ['UNIQUE_ID'];

                $rawPostData = $post;
                $postData = array();
                if ($format === 'json') {
                    $logger -> debug("Parsing JSON POST Data ...");
                    $postData = json_decode($rawPostData, true);
                    
                    if ($postData == false) {
                        $logger -> debug("Malformed JSON POST Data!");
                        require_once 'exceptions/MalformedRequestDataException.class.php';
                        throw new MalformedRequestDataException("JSON Malformed");
                    }
                } else if ($format === 'xml') {
                    try {
                        $logger -> debug("Parsing XML POST Data ...");
                        $postData = XML2Array::createArray($rawPostData);
                    }
                    catch(Exception $e) {
                        $logger -> debug("Malformed XML POST Data!");
                        require_once 'exceptions/MalformedRequestDataException.class.php';
                        throw new MalformedRequestDataException("XML Malformed");
                    }
                } else {
                    $logger -> debug("Format Specified Invalid...");
                    require_once 'exceptions/DataInUnsupportedFormatException.class.php';
                    throw new DataInUnsupportedFormatException("Support only for JSON/XML formats");
                }
                $data = $postData['root'];
                $logger -> debug("Parsed POST Data: " . json_encode($postData));
                break;
            }
            
            $requestArray = array(
            	'method' => $method, 
            	'protocol' => $protocol, 
            	'url' => $requestUrl, 
            	'authCredentials' => $authCredentials, 
            	'apiVersion' => $version, 
            	'format' => $format, 
            	'resourceType' => $resourceType, 
            	'resourceVals' => $resourceVals, 
            	'rawData' => $rawData, 
            	'data' => $data, 
                'debug' => $debug
            );
            
            return new Request($requestArray);
    }
}
