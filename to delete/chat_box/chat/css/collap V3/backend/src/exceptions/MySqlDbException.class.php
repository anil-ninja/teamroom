<?php

/* author: Jessy James

  Details:
  - All DB exceptions including DuplicateEntity will be modelled as an instance of this class
  - CustomMessage in Exception will contain native database exception codes / messages
  - MySQL uses 1000-1999 for server errors, 2000-2999 for client errors */

require_once 'exceptions/ApiException.class.php';
require_once 'exceptions/DuplicateEntityException.class.php';

class MySqlDbException extends ApiException {

    private $errNo;
    private $error;

    public function __construct($mysqlErrorNo, $mysqlErrorMessage, $previous = null) {
	$this->errNo = $mysqlErrorNo;
	$this->error = $mysqlErrorMessage;

	$errorCode = '900';
	if ($mysqlErrorNo == '1062') {
        throw new DuplicateEntityException(); 
	} else {
	    $customMessage = "MySQL Error => " . $this->errNo . ": " . $this->error;
	}
	parent::__construct(
		/* Code */ $errorCode,
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
