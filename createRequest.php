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

$googleId = $_GET['g'];
$type = $_GET['t'];
$start = $_GET['s'];
$end = $_GET['e'];
$memo = $_GET['m'];
$days = $_GET['days'];

$sql = "INSERT INTO my_requests (googleId, type, start, end, approved, memo, days) 
        VALUES ('$googleId', $type, '$start', '$end', 0, '$memo', $days)";

$sql22 = "SELECT * FROM employee_offsite O
          WHERE O.offsiteId = $type AND O.googleId = '" . $googleId . "'";

$result2 = $con->query($sql22);
$info = $result2->fetch_assoc();
$remaining = $info["remaining_amount"] - $days;

if ($remaining > 0) {
    if ($type == 2) {
        if (date($end) <= date("y-m-d")) {
            if ($con->query($sql) === TRUE) {
            } else {
                echo "Error: " . $sql . "<br>" . $con->error;
            }
        } else {
            echo "sick days can't be past today";
        }
    } else {
        if ($con->query($sql) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo "You have <b>".$info["remaining_amount"]." day(s)</b> remaining<br />And requested <b>$days day(s)</b>";
}
