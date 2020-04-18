
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

//this file isn't connected to the website. 
//It can be used to remove offsites that have been removed

$dept = $_GET['d']; //provided with the offsiteID
$sql2 = "DELETE FROM employee_offsite WHERE offsiteID = $dept";
$result2 = $conn->query($sql2);
echo $result2;
$conn->close();