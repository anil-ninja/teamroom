<?php

/* author: Jessy James

  Details:
  - All DB exceptions including DuplicateEntry will be modelled as an instance of this class
  - CustomMessage in Exception will contain native database exception codes / messages
  - MySQL uses 1000-1999 for server errors, 2000-2999 for client errors */

    require_once 'exceptions/ApiException.class.php';
    require_once 'exceptions/DuplicateEntityException.class.php';

    class MongoDbException extends ApiException {

        private $errNo;
        private $error;

        public function __construct($mongoException, $previous = null) {
            $errorCode = $customMessage = null;

        	if ($mongoException instanceof MongoDuplicateKeyException) {
        	    throw new DuplicateEntityException();
        	} else {
                $errorCode = '800';
        	    $customMessage = "Exception: Type => " . get_class($mongoException) . 
                                 ": " . $mongoException -> getMessage();
        	}

        	parent::__construct(
        		/* Code */     $errorCode,
        		/* Message */  $customMessage,
        		/* Previous */ $previous
        	);
        }

        public function getErrNo() {
    	   return $this -> errNo;
        }

        public function getError() {
    	   return $this -> error;
        }
    }
