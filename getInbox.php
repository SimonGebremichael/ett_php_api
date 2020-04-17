
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
$sql2 = "SELECT * FROM my_requests WHERE googleId = '".$id."' AND approved = 0";
$result = $conn->query($sql2);
$rows = $result->num_rows;

if ($rows > 0) {
    $c = 0;
    echo '{"Total": ' . $rows . ', "item":[';
    while ($row = $result->fetch_assoc()) {
        $c = $c + 1;
        if ($c > 1) {
            echo ',';
        }
        $off = "SELECT * FROM offsite WHERE offsiteID = " . $row["type"];
        $listOfOff = $conn->query($off);
        $offInfo = $listOfOff->fetch_assoc();

        echo '{' .
            '"googleId": "' . $row["googleId"] . '",' .
            '"color": "' . $offInfo["color"] . '",' .
            '"id": "' . $row["id"] . '",' .
            '"days": "' . $row["days"] . '",' .
            '"category": "' . $offInfo["category"] . '",' .
            '"start": "' . $row["start"] . '",' .
            '"end": "' . $row["end"] . '"}';
    }
    echo ']}';
} else {
    echo '{"Total": 0}';
}
$conn->close();
