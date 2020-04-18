
<?php
header('Access-Control-Allow-Origin: *');

$servername = "ett_db";
$username = "root";
$password = "";
$conn = new mysqli("localhost", $username, $password, $servername);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$dept = $_GET['d'];
$sql2 = "SELECT * FROM employee WHERE employee_status != 'removed' AND deptID = " . $dept;
$result2 = $conn->query($sql2);
$rows = $result2->num_rows;

$sql3 = "SELECT * FROM department_head D JOIN employee E ON D.googleId = E.googleId 
WHERE E.employee_status != 'removed' AND id = " . $dept;
$result3 = $conn->query($sql3);
$head = $result3->fetch_assoc();
$headAmt = $result3->num_rows;


$sql4 = "SELECT * FROM department_head";
$result4 = $conn->query($sql4);
$deptCount = $result4->num_rows;


echo '{';
if ($headAmt > 0) {
    $e = 0;
    echo '"headAmt": ' . $headAmt . ', "head": {' .
        '"employeeID": "' . $head["id"] . '",' .
        '"first_name": "' . $head["first_name"] . '",' .
        '"last_name": "' . $head["last_name"] . '",' .
        '"email": "' . $head["email"] . '",' .
        '"img": "' . $head["img"] . '",' .
        '"employee_status": "' . $head["employee_status"] . '",' .
        '"googleId": "' . $head["googleId"] . '" }';
} else {
    echo '"headAmt": 0';
}

if ($rows > 0) {
    echo ',"Total": ' . $rows . ', "employee": [';
    $c = 0;
    while ($row = $result2->fetch_assoc()) {
        $c = $c + 1;
        if ($c > 1) {
            echo ',';
        }
        echo '{' .
            '"employeeID": "' . $row["employeeID"] . '",' .
            '"first_name": "' . $row["first_name"] . '",' .
            '"last_name": "' . $row["last_name"] . '",' .
            '"dept": "' . $row["deptID"] . '",' .
            '"googleId": "' . $row["googleId"] . '",' .
            '"img": "' . $row["img"] . '",' .
            '"email": "' . $row["email"] . '",' .
            '"employee_status": "'.$row["employee_status"] . '" }';
    }
    echo ']';
} else { echo ',"Total": 0'; }

if ($deptCount > 0) {
    echo ',"deptCount":' . $deptCount . ',"dept": [';
    $e = 0;
    while ($item = $result4->fetch_assoc()) {
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
    echo ',"deptCount": 0';
}
echo '}';
$conn->close();
