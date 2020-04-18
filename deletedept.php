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

$id = $_GET['d'];//grabs from url paramater

$sql = "DELETE FROM department_head WHERE id = " . $id;
$result = $con->query($sql);

if ($result === TRUE) {

    $sql5 = "UPDATE employee SET deptID = 0 WHERE deptID = " . $id; //sets employee's dept to 0 which is unassigned
    $result4 = $con->query($sql5);

    if($result4 === true){
        echo "1";
    } else {
        echo "false";//fails when parsed into int. then is false
    }

} else {
    echo "false";
}
