
<?php
    header('Access-Control-Allow-Origin: *');
    
    $servername = "ett_db";
    $username = "root";
    $password = "";
    $conn = new mysqli("localhost", $username, $password, $servername);
    if ($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
    }

    $order = $_GET['order'];
    $sql = "SELECT * FROM employee
    WHERE employee_status != 'removed'
    ORDER BY ".$order."";
    $result = $conn->query($sql);
    $rows = $result->num_rows;

    if($rows > 0){
        $c = 0;
        echo '{"Total": '.$rows.', "employee": [';

        while($row = $result->fetch_assoc()) {
            $c= $c+1;
            if($c > 1){ echo ','; }

            $get_my_dept = "SELECT * FROM department_head WHERE id = " . $row["deptID"];
            $depper = $conn->query($get_my_dept);
            $depper2 = $depper->fetch_assoc();

            echo '{'.
                 '"employeeID": "'.$row["employeeID"].'",'.
                 '"first_name": "'.$row["first_name"].'",'.
                 '"last_name": "'.$row["last_name"].'",'.
                 '"dept": "'.$depper2["name"].'",'.
                 '"googleId": "'.$row["googleId"].'",'.
                 '"img": "'.$row["img"].'",'.
                 '"email": "'.$row["email"].'",'.
                 '"employee_status": "'.$row["employee_status"].'" }';
        }
        echo ']}';
    } else{
        echo '{"lines": "none"}';
    }
$conn->close();
