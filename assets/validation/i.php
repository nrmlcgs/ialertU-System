<?php
include $_SERVER['DOCUMENT_ROOT'] . "/ialertu/config/db.php";
$test = new DB();
$conn = $test->getConnectionString();
session_start();

if (!isset($_SESSION['id'])) {
    header("Location:" . "/ialertu/");
    exit();
}
