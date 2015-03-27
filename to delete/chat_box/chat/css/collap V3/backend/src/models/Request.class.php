<?php

	/**
     * @author Rahul Lahoria
     */

    class Request {

	    private $method;
		private $protocol;
		private $url;
		private $authCredentials;
		private $debug;
		private $apiVersion;
		private $format;
		private $resourceType;
		private $resourceVals;
		private $rawData;
		private $data;
		
		public function __construct ($requestArray) {
			$this -> method	 		= $requestArray ['method'];
		    $this -> protocol 		= $requestArray ['protocol'];
		    $this -> url 	 		= $requestArray ['url'];
		    $this -> authCredentials= $requestArray ['authCredentials'];
		    $this -> debug 			= $requestArray ['debug'];
		    $this -> apiVersion	 	= $requestArray ['apiVersion'];
		    $this -> format			= $requestArray ['format'];
		    $this -> resourceType 	= $requestArray ['resourceType'];
		    $this -> resourceVals	= $requestArray ['resourceVals'];
		    $this -> rawData 		= $requestArray ['rawData'];
		    $this -> data	 		= $requestArray ['data'];
		}

		public function toString() {
			return "Method: " . $this -> method . 
					"; Protocol: " . $this -> protocol . 
					"; URL: " . $this -> url . 
					"; Auth : " . json_encode($this -> authCredentials) . 
					"; Debug Logs? " . $this -> debug . 
					"; Version: " . $this -> apiVersion . 
					"; Format: " . $this -> format . 
					"; Resource Type: " . $this -> resourceType . 
					"; Resource Values: " . json_encode($this -> resourceVals) . 
					"; RawData: " . json_encode($this -> rawData) . 
					"; Data: " . json_encode($this -> data);
		}
    
	    public function getMethod()
	    {
	        return $this -> method;
	    }

	    public function getProtocol()
	    {
	        return $this -> protocol;
	    }

	    public function getUrl()
	    {
	        return $this -> url;
	    }

	    public function getAuthCredentials()
	    {
	        return $this -> authCredentials;
	    }

	    public function getDebug()
	    {
	        return $this -> debug;
	    }

	    public function getApiVersion()
	    {
	        return $this -> apiVersion;
	    }

	    public function getFormat()
	    {
	        return $this -> format;
	    }

	    public function getResourceType()
	    {
	        return $this -> resourceType;
	    }

	    public function getResourceVals()
	    {
	        return $this -> resourceVals;
	    }

	    public function getRawData()
	    {
	        return $this -> rawData;
	    }

	    public function getData()
	    {
	        return $this -> data;
	    }
}