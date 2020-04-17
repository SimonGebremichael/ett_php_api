
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
$id = $_GET['i'];
$sql2 = "SELECT * FROM employee_offsite R JOIN employee E ON R.googleId = E.googleId 
    WHERE R.googleId = " . $id;
$result = $conn->query($sql2);
$rows = $result->num_rows;

if ($rows > 0) {
    $c = 0;
    echo '{"Total": ' . $rows . ', "report":[';
    while ($row = $result->fetch_assoc()) {
        $c = $c + 1;
        if ($c > 1) {
            echo ',';
        }
        $off = "SELECT * FROM offsite WHERE offsiteID = " . $row["offsiteID"];
        $listOfOff = $conn->query($off);
        $offInfo = $listOfOff->fetch_assoc();

        echo '{' .
            '"first_name": "' . $row["first_name"] . '",' .
            '"last_name": "' . $row["last_name"] . '",' .
            '"Entitled": "' . $row["entitled_amount"] . '",' .
            '"remaing": "' . $row["remaining_amount"] . '",' .
            '"taken": "' . $row["taken_amount"] . '",' .
            '"category": "' . $offInfo["category"] . '",' .
            '"googleId": "' . $row["googleId"] . '" }';
    }
    echo ']}';
} else {
    echo '{"Total":0}';
}
$conn->close();
