<?php
header('Access-Control-Allow-Origin: *');
session_start();
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "";
$dbname = "ett_db";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die('Could not connect to the database server' . mysqli_connect_error());

$id = $_GET['i'];
$sql = "DELETE FROM my_requests WHERE id='$id'";

if ($con->query($sql) === TRUE) {
    echo "true";
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
