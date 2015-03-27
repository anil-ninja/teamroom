<?php 
/*********************************************************************************
 * InitPHP 2.0 PHP  Dao-Nosql-Mongo 
 *-------------------------------------------------------------------------------
 * : CopyRight By initphp.com
 * ???
 *-------------------------------------------------------------------------------
 * $Author:zhuli
 * $Dtime:2011-10-09 
***********************************************************************************/
class MongoDBUtil {

	private $mongo; //mongo
	private $db; //db mongodb
	private $collection; //? 
	
	/**
	 * Mongo
	 * $config = array(
	 * 'server' => ‘127.0.0.1' 
	 * ‘port’   => '27017' 
	 * ‘options’ => array('connect' => true) 
	 * 'db_name'=> 'test' 
	 * ‘username’=> 'zhuli' 
	 * ‘password’=> '123456' 
	 * )
	 * Enter description here ...
	 * @param unknown_type $config
	 */
	public function init() {
		global $configs;

		$server = '';
		if ($configs ['mongo'] ['username'] != '' && $configs ['mongo'] ['password'] != '') 
			$server = $configs ['mongo'] ['username'] . ':' . $configs ['mongo'] ['password'] . '@';
		$server = 'mongodb://' . $server . $configs ['mongo'] ['server'] . ':' . 
											$configs ['mongo'] ['port'];

		try {
			$this -> mongo = $this -> getMongoClient($server);//, $configs ['mongo'] ['options']);
		}
		catch(Exception $e) {
		    /* Can't connect to MongoDB! */
		    $logger -> error($e);
		    die("Dying since unable to connect!");
		}
		$this -> db = $this -> mongo -> selectDB($configs ['mongo'] ['db_name']);
	}

	function getMongoClient($seeds = "", $options = array(), $retry = 3) {
	    try {
	        return new MongoClient($seeds, $options);
	    }
	    catch(Exception $e) {
	        /* Log the exception so we can look into why mongod failed later */
	        $logger -> error($e);
	    }

	    if ($retry > 0) {
	        return getMongoClient($seeds, $options, --$retry);
	    }
	    throw new Exception("Tried several times to get MongoClient.. Is mongod really running?");
	}
	
	/**
	 * ?
	 * @param string $collection 
	 */
	public function selectCollection($collection) {
		return $this -> collection = $this -> db -> selectCollection($collection);
	}
	
	/**
	 * 
	 * @param array $data  ?array('title' => '1000', 'username' => 'xcxx')
	 * @param array $option 
	 */
	public function insert($data, $option = array()) {
		global $logger;
		$logger -> debug("Mongo insert() :: Data: " . json_encode($data));
		$logger -> debug("Mongo insert() :: Option: " . json_encode($option));

		$result = $this -> collection -> insert($data, $option);
		$logger -> debug("Mongo insert() :: Result: " . json_encode($result));

		return $result;
	}
	
	/**
	 * 
 	 * @param array $data  ?array(0=>array('title' => '1000', 'username' => 'xcxx'))
	 * @param array $option 
	 */
	public function batchInsert($data, $option = array()) {
		return $this -> collection -> batchInsert($data, $option);
	}

	/* As of Mongo-Driver-1.5.0 MongoCollection::batchInsert() is discouraged */
	public function multiInsert($data, $writeOptions = array('w' => 1)) {

		global $logger;
		$logger -> debug("Mongo multiInsert() :: Data: " . json_encode($data));
		$logger -> debug("Mongo multiInsert() :: Option: " . json_encode($writeOptions));

		$batch = new MongoInsertBatch($this -> collection, $writeOptions);
		foreach ($data as $document) {
			$batch -> add($document);
		}

		$result = $batch -> execute($writeOptions);
		$logger -> debug("Mongo multiInsert() :: Result: " . json_encode($result));
		return $result;
	}
	
	/**
	 * ????
 	 * @param array $data  ?array(0=>array('title' => '1000', 'username' => 'xcxx'))
	 * @param array $option 
	 */
	public function save($data, $option = array()) {
		return $this -> collection -> save($data, $option);
	}
	
	/**
	 * 
 	 * @param array $query   ?array(('title' => '1000'))
	 * @param array $option 
	 */
	public function remove($query, $option = array()) {
		global $logger;
		$logger -> debug("Mongo remove() :: Query: " . json_encode($query)); 
		$logger -> debug("Mongo remove() :: Option: " . json_encode($option));

		$result = $this -> collection -> remove($query, $option);
		$logger -> debug("Mongo remove() :: Result: " . json_encode($result));

		return $result;
	}

	public function removeByObjectId($objectId, $fields = array()) {
		$query = array(
			'_id' => new MongoId($objectId)
		);
		return $this -> remove($query, $fields);
	}
	
	/**
	 * 
 	 * @param array $query   ?array(('title' => '1000'))
 	 * @param array $data    ?array(0=>array('title' => '1000', 'username' => 'xcxx'))
	 * @param array $option 
	 */
	public function update($query, $data, $option = array()) {
		global $logger;
		$logger -> debug("Mongo update() :: Query: " . json_encode($query)); 
		$logger -> debug("Mongo update() :: Data: " . json_encode($data));
		$logger -> debug("Mongo update() :: Option: " . json_encode($option));

		$result = $this -> collection -> update($query, $data, $option);
		$logger -> debug("Mongo update() :: Result: " . json_encode($result));

		return $result;
	}

	public function updateByObjectId($objectId, $data, $fields = array()) {
		$query = array(
			'_id' => new MongoId($objectId)
		);
		return $this -> update($query, $data, $fields);
	}
	
	/* As of Mongo-Driver-1.5.0 MongoCollection::batchInsert() is discouraged */
	public function multiUpdate($data, $writeOptions = array('w' => 1)) {

		global $logger;
		$logger -> debug("Mongo multiUpdate() :: Data: " . json_encode($data));
		$logger -> debug("Mongo multiUpdate() :: Option: " . json_encode($writeOptions));

		$batch = new MongoUpdateBatch($this -> collection, $writeOptions);
		foreach ($data as $document) {
			$batch -> add($document);
		}

		$result = $batch -> execute($writeOptions);
		$logger -> debug("Mongo multiUpdate() :: Result: " . json_encode($result));
		return $result;
	}

	/**
	 * 
 	 * @param array $query   ?array(('title' => '1000'))
	 * @param array $fields 
	 */
	public function findOne($query, $fields = array()) {
		global $logger;
		$logger -> debug("Mongo findOne() :: Query: " . json_encode($query));

		$result = $this -> collection -> findOne($query, $fields);
		$logger -> debug("Mongo findOne() :: Result: " . json_encode($result));

		return $result;
	}
	
	/**
	 * 
	 * @param array $query 
	 * @param array $sort   array('age' => -1, 'username' => 1)
	 * @param int   $skip 
	 * @param int   $limit 
	 * @param array $fields
	 */
	public function find($query, $sort = array(), $skip = 0, $limit = 0, $fields = array()) {
		global $logger;
		$logger -> debug("Mongo find() :: Mongo Query: " . json_encode($query));
		
		$cursor = $this -> collection -> find($query, $fields);
		
		if ($sort)  $cursor -> sort($sort);
		if ($skip)  $cursor -> skip($skip);
        if ($limit) $cursor -> limit($limit);
		$result = iterator_to_array($cursor);
		$logger -> debug("Mongo find() :: Result: " . json_encode($result));

		return $result;
	}
	
	public function findByObjectId($objectId, $fields = array()) {
		$query = array(
			'_id' => new MongoId($objectId)
		);
		return $this -> findOne($query, $fields);
	}

	/**
	 * 
	 */
	public function count() {
		return $this -> collection -> count();
	}
	
	/**
	 * 
	 */
	public function error() {
		return $this -> db -> lastError();
	}
	
	/**
	 * 
	 */
	public function getCollection() {
		return $this -> collection;
	}
	
	/**
	 * DB
	 */
	public function getDb() {
		return $this -> db;
	}	
}