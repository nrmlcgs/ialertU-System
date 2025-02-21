<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "ialertu";
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data from the app
$username1 = $_POST['uname'];
$password1 = $_POST['pass'];

// Query to check if the user exists
$sql = "SELECT * FROM account WHERE username='$username1' AND password='$password1'";
$result = $conn->query($sql);

// If user is found
if ($result->num_rows > 0) {
    $data=$result->fetch_assoc();
    // User authenticated
    echo json_encode($data);
} else {
    // User not found or incorrect credentials
    echo "Login failed:". $username1 . " " . $password1;
}

$conn->close();
