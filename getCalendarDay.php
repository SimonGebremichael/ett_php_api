
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$y = $_GET['y'];
$m = $_GET['m'];
$d = $_GET['d'];
$datt = date("$y-$m-$d");
$upcomming = "SELECT * FROM my_requests M JOIN employee E ON M.googleId = E.googleId 
WHERE E.employee_status != 'removed' AND
M.start <= '$datt' AND 
M.end >= '$datt' AND M.approved = 1";
$result = $conn->query($upcomming);
$amount = $result->num_rows;

if ($amount > 0) {
    $c = 0;
    echo '{"Total": ' . $amount . ', "request": [';

    while ($row = $result->fetch_assoc()) {
        $c = $c + 1;
        if ($c > 1) {
            echo ',';
        }

        $off = "SELECT * FROM offsite WHERE offsiteID = " . $row["type"];
        $listOfOff = $conn->query($off);
        $offInfo = $listOfOff->fetch_assoc();

        echo '{' .
            '"id": "' . $row["id"] . '",' .
            '"googleId": "' . $row["googleId"] . '",' .
            '"color": "' . $offInfo["color"] . '",' .
            '"category": "' . $offInfo["category"] . '",' .
            '"End": "' . $row["end"] . '",' .
            '"Start": "' . $row["start"] . '",' .
            '"first_name": "' . $row["first_name"] . '",' .
            '"email": "' . $row["email"] . '",' .
            '"last_name": "' . $row["last_name"] . '",' .
            '"memo": "' . $row["memo"] . '",' .
            '"img": "' . $row["img"] . '",' .
            '"employee_status": "' . $row["employee_status"] . '" }';
    }
    echo ']}';
} else {
    echo '{"Total": "0"}';
}
$conn->close();
