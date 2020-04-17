
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$googleId = $_GET["i"];
$off = "SELECT * FROM employee_offsite E 
JOIN offsite O ON E.offsiteID = O.offsiteID
WHERE O.removed is null AND googleId = '" . $googleId . "'";
$offer = $conn->query($off);
$offNum = $offer->num_rows;

$c = 0;
echo '{"Total": ' . $offNum . ', "off": [';
while ($row = $offer->fetch_assoc()) {
    $c = $c + 1;
    if ($c > 1) {
        echo ",";
    }
    echo '{"name":"' . $row["category"] . '", 
        "id": "' . $row["Oid"] . '", 
        "color": "' . $row["color"] . '", 
        "googleId": "' . $row["googleId"] . '", 
        "taken": "' . $row["taken_amount"] . '", 
        "remaining": "' . $row["remaining_amount"] . '", 
        "value": "'.$row["entitled_amount"].'"}';
}
echo "]}";
$conn->close();
