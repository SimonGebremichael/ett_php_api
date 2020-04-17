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

$fName = $_GET['fname'];
$lName = $_GET['lname'];
$email = $_GET['email'];
$eStatus = $_GET['eStatus'];
$googleID = $_GET['gId'];
$deptID = 0;
$img = $_GET['img'];


$sql2 = "SELECT * FROM employee where googleId = " . $googleID;
$result2 = $con->query($sql2);
$rows = $result2->num_rows;
if ($rows == 0) {
    $sql = "INSERT INTO employee (first_name, last_name, email, employee_status, deptID, googleId, img) VALUES ('$fName','$lName','$email','$eStatus',$deptID,'$googleID', '$img')";
   
   if ($con->query($sql) === TRUE) {
        
        $grabSQL = "SELECT * FROM offsite";
        $grabber = $con->query($grabSQL);
        while($item = $grabber->fetch_assoc()) {
            $sql1 = "INSERT INTO employee_offsite (offsiteID, entitled_amount, taken_amount, remaining_amount, googleId)
            values (".$item['offsiteID'].",".$item['amount_of_days'].",0,".$item['amount_of_days'].",$googleID)";
            if ($con->query($sql1)) {
                echo "1";
            } else { echo "Error: " . $sql . "<br>" . $con->error; } }

    } else { echo "Error: " . $sql . "<br>" . $con->error; }
} else { echo "already"; }
