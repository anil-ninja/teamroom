<?php

	/**
	 * @author Jessy James
	 */
    require_once 'cache/RedisAppCache.class.php';

    class AppCacheRegistry{

        private static $cache;

        public static function getCacheObject ($appCacheType) {

            switch($appCacheType) {

            	/*case 'memcache': 
                    $this -> cache = new MemcacheAppCache();
                break;*/
                case 'redis': 
                    self :: $cache = new RedisAppCache();
                break;
            	default:
                    self :: $cache = new RedisAppCache();
                break;
            }
        	return self :: $cache;
        }

        public function toString() {
            return "Cache Object: " . $this -> cache;
        }
    }
