<?php
include_once 'ninjas.inc.php';
if (!isset($_SESSION['first_name'])) {
    header('Location: index.php');
}

?>
