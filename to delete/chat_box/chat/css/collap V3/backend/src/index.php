<?php

/**
 * @author Rahul Lahoria (rahul_lahoria@yahoo.com)
 * 
 */

ob_start();

require_once 'framework/ApiService.class.php';

// Do init setup - setup global $logger, $warnings_payload
ApiService :: setup();

// Process the request and generates the response
ApiService :: processRequest();

// Clean the place up!
ApiService :: cleanup();

ob_end_flush ();
