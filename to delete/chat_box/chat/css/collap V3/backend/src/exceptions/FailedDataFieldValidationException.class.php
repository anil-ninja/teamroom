<?php

/**
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 17.12.2014	 
 *
 * 	Details: 
 * - Type miss match from input attribute value from DB attribute value 
 * - CustomMessage in Exception will contain native database exception codes / messages
 * - MySQL uses 1000-1999 for server errors, 2000-2999 for client errors  
 */
require_once 'exceptions/ApiException.class.php';

class FailedDataFieldValidationException extends ApiException {

    private $errNo;
    private $error;

    public function __construct($errorNo, $errorMessage, $previous = null) {
	$this->errNo = $errorNo;
	$this->error = $errorMessage;

	$customMessage = "Error => " . $this->errNo . ": " . $this->error;

	parent::__construct(
		/* Code */ $this->errorNo,
		/* Message */ $customMessage,
		/* Previous */ $previous
	);
    }

    public function getErrNo() {
	return $this->errNo;
    }

    public function getError() {
	return $this->error;
    }

}
