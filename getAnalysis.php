
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

$off = "SELECT * FROM offsite";
$offer = $conn->query($off);
$offNum = $offer->num_rows;

$c = 0;
$e = 0;
echo '{"Total": ' . $offNum . ', "off": [';
while ($row = $offer->fetch_assoc()) {
    $c = $c + 1;
    if ($c > 1) {
        echo ",";
    }
    echo '{"name":"' . $row["category"] . '", "color": "' . $row["color"] . '", "value": [';

    for ($i = 0; $i < 12; $i++) {
        $an1 = "SELECT * FROM my_requests M
        WHERE M.googleId = '$googleId' 
        AND M.type = " . $row['offsiteID'] . " AND MONTH(M.start) = $i";
        $result = $conn->query($an1) or die($conn->error);
        $days = 0;
        while ($offInfo = $result->fetch_assoc()) {
            $days = $days + $offInfo["days"];
        }
        echo $days;
        if ($i < 11) {
            echo ",";
        }
    }
    
    echo "]}";
}
echo "]}";
$conn->close();
