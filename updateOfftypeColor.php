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

$offsiteID = $_GET['i'];
$color = $_GET['c'];
$sql = "UPDATE offsite SET color = '" . $color . "' WHERE offsiteID = " . $offsiteID;

if ($con->query($sql) === TRUE) {
    echo "added";
} else {
    echo "false";
}
