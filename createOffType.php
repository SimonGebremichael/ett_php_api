<?php
header('Access-Control-Allow-Origin: *');
session_start();
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "";
$dbname = "ett_db";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die('Could not connect to the database server' . mysqli_connect_error());

$name = $_GET['n'];
$limit = $_GET['l'];
$color = $_GET['c'];
preg_match_all('!\d+!', $limit, $matches);

$sql2 = "SELECT category FROM offsite WHERE category = " . $name;
$result2 = $con->query($sql2);

if (empty($result2)) {

    $sql = "INSERT INTO offsite (category, amount_of_days, color) VALUES ('$name', $limit, '$color')";
    if ($con->query($sql) === TRUE) {
        $sql_ID = "SELECT * FROM offsite  WHERE category = '".$name."'";
        $gettingId = $con->query($sql_ID);

        $sqll = "SELECT * FROM employee";
        $adder = $con->query($sqll);

        while ($_ID_ = $gettingId->fetch_assoc()) {
            while ($row = $adder->fetch_assoc()) {
                $new_offtype = "INSERT INTO employee_offsite 
                (offsiteID, entitled_amount, taken_amount, remaining_amount, googleId) VALUES 
                (" . $_ID_["offsiteID"] . ", " . $_ID_["amount_of_days"] . ", 0, " . $_ID_["amount_of_days"] . ", '" . $row["googleId"] . "')";
                $addingIt = $con->query($new_offtype);
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
} else {
    echo "already";
}
