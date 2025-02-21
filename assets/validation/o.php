<?php
include $_SERVER['DOCUMENT_ROOT'] . "/ialertu/config/db.php";
$test = new DB();
$conn = $test->getConnectionString();
session_start();

if (isset($_SESSION['id'])) {
    $id =  $_SESSION['id'];
    $sql = "SELECT * FROM `account` WHERE `id` = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        header("Location:" . "/ialertu/view/pages/");
        exit();
    }
}
