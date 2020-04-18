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

$googleID = $_GET['i'];

$sql2 = "UPDATE employee SET employee_status = 'removed' WHERE googleId = '" . $googleID."'";
$result2 = $con->query($sql2);

if ($result2 === TRUE) {
    // $sql3 = "DELETE FROM my_requests WHERE googleId = " . $googleID;
    // $result2 = $con->query($sql3);
    
    // $sql4 = "DELETE FROM employee_offsite WHERE googleId = " . $googleID;
    // $result3 = $con->query($sql4);

    $sql5 = "UPDATE department_head SET googleId = null WHERE googleId = " . $googleID;
    $result4 = $con->query($sql5);

    if($result2 === TRUE && $result3 === TRUE && $result4 === TRUE){
        echo "1";
    }
    else {
        echo "f";
    }
} else {
    echo "false";
}
