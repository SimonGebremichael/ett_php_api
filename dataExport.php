<?php
header("Content-Disposition: attachment; filename=employeeExport.xls");

$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "";
$dbname = "ett_db";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die('Could not connect to the database server' . mysqli_connect_error());



$googleId = $_GET['i'];
$from = $_GET['f'];
$to = $_GET['t'];
$getOrnot = $_GET['d'];
$grab = "";
$bool = filter_var($getOrnot, FILTER_VALIDATE_BOOLEAN);
echo $getOrnot;

if ($bool === TRUE) {
    $dept = "SELECT id FROM department_head where googleId = '$googleId'";
    $getDept = $con->query($dept);
    $info = $getDept->fetch_assoc();
    $grab = " AND E.deptID = ".$info["id"];
}else{
    $grab = "";
}
echo $grab;

$sql = "SELECT * FROM my_requests M 
JOIN employee E ON M.googleId = E.googleid 
JOIN offsite O ON M.type = O.offsiteID 
WHERE M.start > '" . $from . "' AND M.start < '" . $to . "'
$grab";
$resultt = mysqli_query($con, $sql);
$output = '
<table class="table" bordered="1">
<tr>
<th>first name</th>
<th>last name</th>
<th>email</th>
<th>department</th>
<th>googleId</th>
<th>request type</th>
<th>start date</th>
<th>end date</th>
<th>memo</th>
<th>status(1=appr, 2=decl)</th>
</tr>';
while ($row = $resultt->fetch_assoc())  //fetch_table_data
{
    $output .= '<tr>
    <td>' . $row["first_name"] . '</td>
    <td>' . $row["last_name"] . '</td>
    <td>' . $row["email"] . '</td>
    <td>' . $row["deptID"] . '</td>
    <td>' . $row["googleId"] . '</td>
    <td>' . $row["category"] . '</td>
    <td>' . $row["start"] . '</td>
    <td>' . $row["end"] . '</td>
    <td>' . $row["memo"] . '</td>
    <td>' . $row["approved"] . '</td>
    </tr>';
}
$output .= '<tr>
<td>Exported:' . date("Y-M-D") . '</td></tr></table>';

header("Content-Type: application/xls");
echo $output;
