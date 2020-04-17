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

$m = date("m") - 1;
$d = date("y-".$m."-d");
$everyone = "SELECT * FROM my_requests M 
where M.approved = 1 AND M.type != 3 AND M.start <= '$d' AND M.end >= '$d'";
$everyone2 = $con->query($everyone) or die("Connection failed:" . $con->connect_error);

$onsite = "UPDATE employee SET employee_status = 'onsite'
where employee_status != 'pending' AND employee_status != 'removed'";
$onsite2 = $con->query($onsite);

if (!empty($everyone2)) {
    while ($row = $everyone2->fetch_assoc()) {
        $offsite = "UPDATE employee SET employee_status = 'offsite'
        where googleId = '" . $row["googleId"] . "'";
        $offsite2 = $con->query($offsite);
    }
}else{ echo "<br />fail $everyone2"; }
