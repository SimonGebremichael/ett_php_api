
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$m = $_GET["m"];
$y = $_GET["y"];

$off = "SELECT * FROM offsite WHERE
removed is null";
$offer = $conn->query($off);
$offNum = $offer->num_rows;

$c = 0;
echo '{"Total": ' . $offNum . ', "off": [';
while ($row = $offer->fetch_assoc()) {
    $c = $c + 1;
    if ($c > 1) {
        echo ",";
    }
    echo '{"id": "'.$row["offsiteID"].'", "name":"' . $row["category"] . '", "color": "' . $row["color"] . '", "value": "';

    $an1 = "SELECT * FROM my_requests M 
        JOIN offsite O ON M.type = O.offsiteID
        WHERE 
       
        (MONTH(M.start) = $m OR
        MONTH(M.end) = $m)
        AND YEAR(M.start) = $y
        AND M.approved = 1  AND M.type = " . $row['offsiteID'];
    $result = $conn->query($an1);
    $reg_amt = $result->num_rows;

    echo $reg_amt;
    echo "\"}";
}
echo "]}";
$conn->close();
