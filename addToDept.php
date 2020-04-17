
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$googleId = $_GET['i'];
$dept = $_GET['d'];

$sql = "UPDATE employee SET deptID = " . $dept . " WHERE googleId = ". $googleId;

if ($conn->query($sql)) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}