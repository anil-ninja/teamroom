<?php

/**
 * Object represents sql query with params
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 9.12.2014
 */
require_once 'exceptions/InvalidAttributeTypeException.class.php';

class SqlQuery {

    var $txt;
    var $params = array();
    var $idx = 0;

    /**
     * Constructor
     *
     * @param String $txt Sql query 
     */
    function SqlQuery($txt) {
	$this->txt = $txt;
    }

    /**
     * Set string param
     *
     * @param String $value value set
     */
    public function setString($value) {
	//$value = mysql_real_escape_string($value);
	$this->params[$this->idx++] = $value;
    }

    public function escapeString($value) {
	return mysql_real_escape_string($value);
    }

    /**
     * Set string param
     *
     * @param String $value value to set
     */
    public function set($value) {
	/* Commenting out the line below - it doesn't work since 
	  the DB connection is established later in QueryExecutor class */
	//$value = mysql_real_escape_string($value);
	$this->params[$this->idx++] = $value;
    }

    /**
     *
     * @param String $value wartosc do wstawienia
     */
    public function setNumber($value) {
	if ($value === null) {
	    $this->params[$this->idx++] = "null";
	    return;
	}
	if (!is_numeric($value)) {
	    //throw new Exception($value.' is not a number');
	    throw new InvalidAttributeTypeException('904', $value . ' is not a number');
	}
	$this->params[$this->idx++] = $value;
    }

    /**
     * Get sql query
     *
     * @return String
     */
    public function getQuery() {
	if ($this->idx == 0) {
	    return $this->txt;
	}
	$p = explode("?", $this->txt);
	$sql = '';
	for ($i = 0; $i <= $this->idx; $i++) {
	    if ($i >= count($this->params)) {
		$sql .= $p[$i];
	    } else {
		if ("null" === $this->params[$i]) {
		    $columnName = $this->getColumnName($p[$i]);
		    if (isset($columnName)) {
			$sql .= $columnName . "is " . "'" . $this->escapeString($this->params[$i]) . "'";
		    } else {
			$sql .= $p[$i] . "'" . $this->escapeString($this->params[$i]) . "'";
		    }
		} else {
		    $sql .= $p[$i] . "'" . $this->escapeString($this->params[$i]) . "'";
		}
	    }
	}
	return $sql;
    }

    private function getColumnName($textCopy) {
	$trimmedUppercaseSql = trim(strtoupper($this->txt));
	if ($this->startsWith($trimmedUppercaseSql, "SELECT ")) {
	    $rightTrimmedTextCopy = rtrim($textCopy, " ");
	    $columnName = rtrim($rightTrimmedTextCopy, "=");
	    if (strlen($columnName) !== strlen($rightTrimmedTextCopy)) {
		return $columnName;
	    }
	}
	return null;
    }

    /**
     * Function replace first char
     *
     * @param String $str
     * @param String $old
     * @param String $new
     * @return String
     */
    private function replaceFirst($str, $old, $new) {
	$len = strlen($str);
	for ($i = 0; $i < $len; $i++) {
	    if ($str[$i] == $old) {
		$str = substr($str, 0, $i) . $new . substr($str, $i + 1);
		return $str;
	    }
	}
	return $str;
    }

    /**
     * Function to check if a string starts with a given text
     * 
     * @param type $haystack the string
     * @param type $needle the given text
     * @return type true if the string starts with the text
     */
    private function startsWith($haystack, $needle) {
	return !strncmp($haystack, $needle, strlen($needle));
    }

    /**
     * Function to check if the string ends with the given text
     * 
     * @param type $haystack the string
     * @param type $needle the given text
     * @return boolean true if the string ends with the text
     */
    private function endsWith($haystack, $needle) {
	$length = strlen($needle);
	if ($length == 0) {
	    return true;
	}

	return (substr($haystack, -$length) === $needle);
    }

}

?>