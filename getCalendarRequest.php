
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

$upcomming = "SELECT * FROM my_requests M 
JOIN employee E ON  M.googleId = E.googleid 
WHERE E.employee_status != 'removed' AND
MONTH(M.start) = $m 
AND M.approved = 1
AND YEAR(M.start) = $y OR
MONTH(M.end) = $m
AND YEAR(M.start) = $y
AND M.approved = 1
ORDER BY M.start";
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
            '"id": "' . $row["id"] . '",' .
            '"dept": "' . $depper2["name"] . '",' .
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
