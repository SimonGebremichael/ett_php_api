
<?php
header('Access-Control-Allow-Origin: *');

session_start();
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "";
$dbname = "ett_db";

$conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die('Could not connect to the database server' . mysqli_connect_error());

$googleId = $_GET['i'];
$sql2 = "SELECT * FROM employee where employee_status != 'removed' AND googleId = '" . $googleId."'
";
$result2 = $conn->query($sql2);
$rows = $result2->num_rows;



if ($rows == 1) {
    $c = 0;
    echo '{"Total": ' . $rows . ', "employee":';
    $row = $result2->fetch_assoc();


    $off = "SELECT * FROM department_head WHERE id = " . $row["deptID"];
    $listOfOff = $conn->query($off);
    $offInfo = $listOfOff->fetch_assoc();


    echo '{' .
        '"first_name": "' . $row["first_name"] . '",' .
        '"googleId": "' . $row["googleId"] . '",' .
        '"last_name": "' . $row["last_name"] . '",' .
        '"email": "' . $row["email"] . '",' .
        '"deptID": "' . $row["deptID"] . '",' .
        '"dept": "' . $offInfo["name"] . '",' .
        '"img": "' . $row["img"] . '",' .
        '"employee_status": "' . $row["employee_status"] . '" }';
    echo '}';
} else {
    echo '{"Total":0}';
}
$conn->close();
