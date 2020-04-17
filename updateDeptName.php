
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$name = $_GET['n'];
$dept = $_GET['d'];
$sql = "UPDATE department_head SET name = '".$name."' WHERE id = " . $dept;
$result = $conn->query($sql);
if($result === TRUE){
    echo "t";
}else{
    echo "false";
}
$conn->close();
