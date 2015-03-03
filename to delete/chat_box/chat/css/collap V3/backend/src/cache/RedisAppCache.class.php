<?php

    require_once 'cache/AppCache.interface.php';
    require_once 'utils/predis/autoload.php';

    class RedisAppCache implements AppCache {

        private $redis;

        public function __construct() {
            global $configs, $logger;

            try {
                $logger -> debug ("Creating REDIS cache object");
                Predis\Autoloader::register();
                $this -> redis = new Predis\Client($configs ['redis'] ['client']);
            } catch (Exception $e) {
                $logger -> warn ("Redis cache object could not be created");
                $this -> redis = null;
            }
        }

        public function checkIfHashExists($hashName) {
            if (is_null($this -> redis)) 
                return NULL;
            
            global $logger;    
            $logger -> debug ("CACHE: Removing $hashKey from '$hashName'");
            return $this -> redis -> EXISTS($hashName);
        }   

        public function removeHash($hashName) {
            if (is_null($this -> redis)) 
                return NULL;

            global $logger;
            $logger -> debug ("CACHE: Removing '$hashName' hash");
            return $this -> redis -> DEL($hashName);
        }

        public function setIntoHash($hashName, $hashKey, $hashValue, $expiryInSeconds = null) {
            if (is_null($this -> redis)) 
                return NULL;
            
            global $logger, $configs;
            $logger -> debug ("CACHE: Setting $hashKey into '$hashName'");
            $result = $this -> redis -> HSET($hashName, $hashKey, $hashValue);
            
            if (is_null($expiryInSeconds)) 
                $expiryInSeconds = $configs ['redis'] ['expiry'];
            $this -> redis -> EXPIRE($hashKey, $expiryInSeconds);

            return $result;
        }

        public function setMultipleIntoHash($hashName, $hashKey, $hashValue) {
            if (is_null($this -> redis)) 
                return NULL;
            
            return array();
        }

        public function getFromHash($hashName, $hashKey) {
            if (is_null($this -> redis)) 
                return NULL;

            global $logger;
            $logger -> debug ("CACHE: Loading $hashKey from '$hashName'");
            return $this -> redis -> HGET($hashName, $hashKey);
        }

        public function getMultipleFromHash($hashName, $hashKeys) {
            if (is_null($this -> redis)) 
                return NULL;

            global $logger;                
            return $this -> redis -> HMGET($hashName, $hashKeys);
        }

        public function getAllFromHash($hashName) {
            if (is_null($this -> redis)) 
                return NULL;

            global $logger;
            $logger -> debug ("CACHE: Loading all keys from '$hashName'");
            return $this -> redis -> HGETALL($hashName);
        }

        public function removeFromHash($hashName, $hashKey) {
            if (is_null($this -> redis)) 
                return NULL;
            
            global $logger;    
            $logger -> debug ("CACHE: Removing $hashKey from '$hashName'");
            return $this -> redis -> HDEL($hashName, $hashKey);
        }   
    }