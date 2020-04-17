
<?php
    header('Access-Control-Allow-Origin: *');
    
    $servername = "ett_db";
    $username = "root";
    $password = "";
    $conn = new mysqli("localhost", $username, $password, $servername);
    if ($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
    }

    $sql2 = "SELECT * FROM employee E JOIN department_head D ON E.deptID = D.id 
    WHERE E.employee_status != 'removed'";
    $result2 = $conn->query($sql2);
    $rows = $result2->num_rows;

    if($rows > 0){
        $c = 0;
        echo '{"Total": '.$rows.', "employee": [';

        while($row = $result2->fetch_assoc()) {
            $c= $c+1;
            if($c > 1){ echo ','; }

            echo '{'.
                 '"employeeID": "'.$row["employeeID"].'",'.
                 '"first_name": "'.$row["first_name"].'",'.
                 '"last_name": "'.$row["last_name"].'",'.
                 '"dept": "'.$row["name"].'",'.
                 '"googleId": "'.$row["googleId"].'",'.
                 '"img": "'.$row["img"].'",'.
                 '"email": "'.$row["email"].'",'.
                 '"employee_status": "'.$row["employee_status"].'" }';
        }
        echo ']}';
    } else{
        echo '{"Total": 0}';
    }
$conn->close();
