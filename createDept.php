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

$name = $_GET['n'];

$sql = 'INSERT INTO department_head (name)
            values ("' . $name . '")';

if ($con->query($sql)) {
    $sql2 = 'SELECT id FROM department_head WHERE name = "' . $name . '"';
    $result = $con->query($sql2);
    $row = $result->fetch_assoc();
    echo $row["id"];
} else {
    echo "Error: " . $sql . "<br>" . $con->error;
}
