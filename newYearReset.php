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

$year = "SELECT y_name from yearreset where y_name = " . date("Y");
$grab_d = $con->query($year);
$y = $grab_d->fetch_assoc();


if ($y["y_name"] == "") {
    $sql = "UPDATE employee_offsite SET remaining_amount = entitled_amount";
    $sql2 = "UPDATE employee_offsite SET taken_amount = 0";

    $addYear = "INSERT INTO yearreset (y_name) VALUES (".date("Y").")";
    $adder = $con->query($addYear);

    if ($con->query($sql) === TRUE && $con->query($sql2) === TRUE) {
        echo "values reset for the new year";
    } else {
        echo "an error occured";
    }
}else{
    echo "already reset for this year";
}
