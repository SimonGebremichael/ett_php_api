
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$sql = "SELECT * FROM department_head";
$result = $conn->query($sql);
$deptCount = $result->num_rows;

echo '{';
if ($deptCount > 0) {
    echo '"deptCount":' . $deptCount . ',"dept": [';
    $e = 0;
    while ($item = $result->fetch_assoc()) {
        $e = $e + 1;
        if ($e > 1) {
            echo ',';
        }
        echo '{' .
            '"id": "' . $item["id"] . '",' .
            '"googleId": "' . $item["googleId"] . '",' .
            '"name": "' . $item["name"] . '" }';
    }
    echo ']';
} else {
    echo '"deptCount": 0';
}
echo '}';
$conn->close();
