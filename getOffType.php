
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

$sql2 = "SELECT * FROM offsite WHERE removed IS NULL";
$result = $conn->query($sql2);
$rows = $result->num_rows;

if ($rows > 0) {
    $c = 0;
    echo '{"Total": ' . $rows . ', "offtype": [';
    while ($row = $result->fetch_assoc()) {
        $c = $c + 1;
        if ($c > 1) {
            echo ',';
        }
        echo '{' .
            '"id": "' . $row["offsiteID"] . '",' .
            '"name": "' . $row["category"] . '",' .
            '"color": "' . $row["color"] . '",' .
            '"limit": "' . $row["amount_of_days"] . '" }';
    }
    echo ']}';
} else {
    echo 'false';
}
$conn->close();
