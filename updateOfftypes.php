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
$value = $_GET['v'];
$taken = $_GET['t'];
$res = $value - $taken;


$sql = "UPDATE employee_offsite SET entitled_amount = " . $value . " WHERE Oid = " . $id;
$sql2 = "UPDATE employee_offsite SET remaining_amount = " . $res . " WHERE Oid = " . $id;

if ($con->query($sql) === TRUE && $con->query($sql2) === TRUE) {
    echo "";
} else {
    echo "false";
}
