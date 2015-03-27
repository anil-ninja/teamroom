<?php

/**
 * Object executes sql queries
 *
 * @author: Rahul Lahoria (rahul_lahoria@capillarytech.com)
 * @date: 9.12.2014
 */
require_once 'exceptions/MySqlDbException.class.php';

class QueryExecutor {

    /**
     *
     * @param processed sql query
     * @return query result
     */
    public static function execute($sqlQuery) {
	global $logger;

	$transaction = Transaction::getCurrentTransaction();
	if (!$transaction) {
	    $connection = new Connection();
	} else {
	    $connection = $transaction->getConnection();
	}
	$query = $sqlQuery->getQuery();
	$logger->sql($query);

//                $pos = strpos($query, "null");
//                if ($pos != false) {
//                    if(true) {
//                      writeToFile($query);
//                    }
//                }
	$result = $connection->executeQuery($query);
	$logger->debug("executeQuery Result: " . print_r($result, true));
	if (!$result) {
	    throw new MySqlDbException(mysql_errno(), mysql_error());
	}
	$i = 0;
	$tab = array();
	while ($row = mysql_fetch_array($result)) {
	    $tab[$i++] = $row;
	}
	mysql_free_result($result);
	if (!$transaction) {
	    $connection->close();
	}
	$logger->debug("executeQuery Fetched Data: " . json_encode($tab));
	return $tab;
    }

    public static function executeUpdate($sqlQuery) {
	global $logger;

	$transaction = Transaction::getCurrentTransaction();
	if (!$transaction) {
	    $connection = new Connection();
	} else {
	    $connection = $transaction->getConnection();
	}
	$query = $sqlQuery->getQuery();
	$logger->sql($query);

	$result = $connection->executeQuery($query);
	$logger->debug("executeQuery Result: " . print_r($result, true));
	if (!$result) {
	    throw new MySqlDbException(mysql_errno(), mysql_error());
	}
	//return mysql_affected_rows();
	return true;
    }

    public static function executeInsert($sqlQuery) {
	global $logger;

	$result = QueryExecutor::executeUpdate($sqlQuery);
	$logger->debug("Execute Update Result: " . print_r($result, true));

	$lastInsertedId = mysql_insert_id();
	$logger->debug("Execute Insert Result: '$lastInsertedId'");
	return $lastInsertedId;
    }

    /**
     *
     * @param sqlQuery obiekt typu SqlQuery
     * @return wynik zapytania 
     */
    public static function queryForString($sqlQuery) {
	$transaction = Transaction::getCurrentTransaction();
	if (!$transaction) {
	    $connection = new Connection();
	} else {
	    $connection = $transaction->getConnection();
	}
	$result = $connection->executeQuery($sqlQuery->getQuery());
	if (!$result) {
	    throw new MySqlDbException(mysql_errno(), mysql_error());
	}
	$row = mysql_fetch_array($result);
	return $row[0];
    }

}

?>