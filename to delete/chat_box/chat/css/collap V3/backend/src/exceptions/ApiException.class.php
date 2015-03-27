<?php

    /**
     * @author Jessy James
     */

    require_once 'utils/HttpStatusCodes.php';
    require_once 'exceptions/InternalStatuses.class.php';

    class ApiException extends Exception {
    
        private $httpStatusCode;
        private $httpStatusCodeMessage;
        private $customMessage;
        private $otherHeaders = array();
        private $data;

        public function __construct ($apiExceptionCode, $customMsg, $otherHeaders = null, $previous = null) {

            $customMessage  = (! empty($customMsg)) ? "; $customMsg" : '';
            $errorMessage = trim(InternalStatuses :: $list [$apiExceptionCode] ['message']);
            $message = $errorMessage . $customMessage;

            parent::__construct($message, $apiExceptionCode, $previous);

            $httpStatusCode  = trim(InternalStatuses :: $list [$apiExceptionCode] ['httpStatusCode']);
            $this -> httpStatusCode = $httpStatusCode;
            $this -> httpStatusCodeMessage = HttpStatusCodes :: getStatusCodeMessage($httpStatusCode);
            $this -> customMessage = $customMsg;
            $this -> otherHeaders = InternalStatuses :: $list [$apiExceptionCode] ['otherHeaders'];
        }
        
        public function getHttpStatusCode () {
            return $this -> httpStatusCode;
        }
        
        public function getHttpStatusCodeMessage () {
            return $this -> httpStatusCodeMessage;
        }

        public function getCustomMessage () {
            return $this -> customMessage;
        }

        public function getOtherHeaders () {
            return $this -> otherHeaders;
        }

        public function toString() {
            return "ApiException => HTTP Status Code: " . $this -> httpStatusCode . 
            "; HTTP Status Code Message: " . $this -> httpStatusCodeMessage . 
            "; Code: " . $this -> code . 
            "; Message: " . $this -> message . 
            "; Other Headers: " . (empty($this -> otherHeaders) ? 
                                        '' : implode (',', $this -> otherHeaders)) . 
            "; Previous: " . $this -> previous;
        }
    }
    