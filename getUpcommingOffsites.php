
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$order = $_GET['o'];
$d = (date("m") - 1);
$grab = "";
if ($order == "recent") {
    $grab = "WHERE MONTH(M.start) > $d";
} else if ($order == "month") {
    $m = date("m");
    $from = date("y-m-0");
    $to = date("y-".($m+1)."-0");
    $grab = "WHERE M.start > '$from' AND M.start < '$to'";
} else if ($order == "year") {
    $y = date("y");
    $from = date($y."-0-0");
    $to = date(($y+1)."-0-0");
    $grab = "WHERE M.start > '$from' AND M.start < '$to'";
}

$upcomming = "SELECT * FROM my_requests M JOIN employee E ON M.googleId = E.googleid 
JOIN offsite O ON M.type = O.offsiteID 
$grab AND E.employee_status != 'removed' AND M.approved = 1  ORDER BY M.start";

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

        $get_my_dept = "SELECT * FROM department_head WHERE id = " . $row["deptID"];
        $depper = $conn->query($get_my_dept);
        $depper2 = $depper->fetch_assoc();

        $off = "SELECT * FROM offsite WHERE offsiteID = " . $row["type"];
        $listOfOff = $conn->query($off);
        $offInfo = $listOfOff->fetch_assoc();

        echo '{' .
            '"googleId": "' . $row["googleId"] . '",' .
            '"color": "' . $offInfo["color"] . '",' .
            '"category": "' . $offInfo["category"] . '",' .
            '"start": "' . $row["start"] . '",' .
            '"dept": "' . $depper2["name"] . '",' .
            '"end": "' . $row["end"] . '",' .
            '"start": "' . $row["start"] . '",' .
            '"first_name": "' . $row["first_name"] . '",' .
            '"last_name": "' . $row["last_name"] . '",' .
            '"email": "' . $row["email"] . '",' .
            '"img": "' . $row["img"] . '",' .
            '"employee_status": "' . $row["employee_status"] . '" }';
    }
    echo ']}';
} else {
    echo '{"Total": "0"}';
}
$conn->close();
