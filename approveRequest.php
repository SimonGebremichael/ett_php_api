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
$type = $_GET['t'];

if ($type == "true") {
    $sql = "UPDATE my_requests SET approved = 1 WHERE id = " . $id;
    if ($con->query($sql) === TRUE) {
        $sql22 = "SELECT * FROM employee_offsite O JOIN my_requests M ON O.googleId = M.googleId
        WHERE O.offsiteId = m.type
        AND M.id = '" . $id . "'";
        $result2 = $con->query($sql22);
        $info = $result2->fetch_assoc();
        $taken = $info["taken_amount"] + $info["days"];
        $remaining = $info["remaining_amount"] - $info["days"];

        $take = "UPDATE employee_offsite SET taken_amount = " . $taken . " WHERE Oid = " . $info["Oid"];
        $rem =  "UPDATE employee_offsite SET remaining_amount = " . $remaining . " WHERE Oid = " . $info["Oid"];

        if ($con->query($take) === TRUE && $con->query($rem) === TRUE) {
        }else{
            "false";
        }
    } else {
        echo "false";
    }
} else {
    $sql = "UPDATE my_requests SET approved = 2 WHERE id = " . $id;
    if ($con->query($sql) === TRUE) {
    } else {
        echo "false";
    }
}
