
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
$googleId = $_GET['i'];
$sort = "";
if($order != "all"){
    $sort = " AND O.category = '".$order."'";
}

$sql = "SELECT id FROM department_head WHERE googleId = '".$googleId."'";
$grab_d = $conn->query($sql);
$dep = $grab_d->fetch_assoc();

$sql2 = "SELECT * FROM my_requests M JOIN employee E ON M.googleId = E.googleid 
JOIN offsite O ON M.type = O.offsiteID
WHERE approved = 0 AND E.employee_status != 'removed'
$sort 
AND E.deptID = '".$dep["id"]."'";

$result2 = $conn->query($sql2);
$rows = $result2->num_rows;

if ($rows > 0) {
    $c = 0;
    echo '{"Total": '.$rows .', "request": [';

    while ($row = $result2->fetch_assoc()) {
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
            '"dept": "' . $depper2["name"] . '",' .
            '"color": "' . $offInfo["color"] . '",' .
            '"days": "' . $row["days"] . '",' .
            '"category": "' . $offInfo["category"] . '",' .
            '"start": "' . $row["start"] . '",' .
            '"id": "' . $row["id"] . '",' .
            '"end": "' . $row["end"] . '",' .
            '"memo": "' . $row["memo"] . '",' .
            '"first_name": "' . $row["first_name"] . '",' .
            '"last_name": "' . $row["last_name"] . '",' .
            '"email": "' . $row["email"] . '",' .
            '"img": "' . $row["img"] . '",' .
            '"employee_status": "' . $row["employee_status"] . '" }';
    }
    echo ']}';
} else {
    echo '{"Total": 0}';
}
$conn->close();
