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

$googleId = $_GET['i'];
$id = $_GET['d'];

$sql = "UPDATE department_head SET googleId = '" . $googleId . "' WHERE id = " . $id;
if ($con->query($sql) === FALSE) {
    echo "1";
} else {
    echo "f";
}
