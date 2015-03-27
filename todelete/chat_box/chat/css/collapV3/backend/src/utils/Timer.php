<?php
class Timer extends Base {
	private $lastlap;
	private $total;
	private $laststart;
	private $is_running;
	private $num_laps;
	private $timername;
	
	function __construct($name) {
		parent::__construct();
		$this->timername = $name;
		$this->total = 0;
		$this->lastlap = 0;
		$this->laststart = 0;
		$this->is_running = false;
		$this->num_laps = 0;
	}

	// diff_microtime *********************************************************
	// Calculate the difference between two different microtimes
	// I like this better than the `getmicrotime()` option on PHP.net
	// from: http://edoceo.com/creo/php-diffmicrotime
	private function diff_microtime($mt_old,$mt_new)
	{
			
		//list($old_usec, $old_sec) = explode(' ',$mt_old);
		//list($new_usec, $new_sec) = explode(' ',$mt_new);
		//$old_mt = ((float)$old_usec + (float)$old_sec);
		//$new_mt = ((float)$new_usec + (float)$new_sec);
		//return $new_mt - $old_mt;
		
		return $mt_new - $mt_old;
	}


	function start() {
		if ($this->is_running) {
			$this->end();
		}
		$this->laststart = microtime(true);
		$this->is_running = true;
		$this->num_laps++;
	}

	function stop() {
		if ($this->is_running) {
			$this->is_running = false;
			$end = microtime(true);

			$diff = $this->diff_microtime($this->laststart, $end);
			if ($diff < 0) return; //wierd!
			$this->total = $this->total + $diff;
			$this->lastlap = $diff;
		}
	}
	
	function getTotalElapsedTime() {

	        return $this->total;
		//return number_format($this->total, 2, '.', '');
	}
	
	function getLastLapTime() {
		return $this->lastlap;        
                //return number_format($this->lastlap, 2, '.', '');
	}
	
	function isRunning() {
		return $this->is_running;
	}
	
	function getNumLaps() {
		return $this->num_laps;
	}
}
?>
