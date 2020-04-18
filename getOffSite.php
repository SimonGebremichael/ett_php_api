
<?php
    header('Access-Control-Allow-Origin: *');
    
    $servername = "ett_db";
    $username = "root";
    $password = "";
    $conn = new mysqli("localhost", $username, $password, $servername);
    if ($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
    }
    

    $m = date("m") - 1;
    $d = date("y-".$m."-d");
    $sql = "SELECT * FROM my_requests M 
    JOIN employee E ON M.googleId = E.googleid 
    where E.employee_status = 'offsite'
    AND M.start <= '$d' AND M.end >= '$d'";
    $result = $conn->query($sql);
    $amount = $result->num_rows;


    if($amount > 0){
        $c = 0;
        echo '{"Total": '.$amount.', "employee": [';

        while($row = $result->fetch_assoc()) {
            $c= $c+1;
            if($c > 1){ echo ','; }

            $get_my_dept = "SELECT * FROM department_head WHERE id = " . $row["deptID"];
            $depper = $conn->query($get_my_dept);
            $depper2 = $depper->fetch_assoc();
            
            $off = "SELECT * FROM offsite WHERE offsiteID = ".$row["type"];
            $listOfOff = $conn->query($off);
            $offInfo = $listOfOff->fetch_assoc();

            echo '{'.
                 '"employeeID": "'.$row["employeeID"].'",'.
                 '"dept": "'.$depper2["name"].'",'.
                 '"first_name": "'.$row["first_name"].'",'.
                 '"last_name": "'.$row["last_name"].'",'.
                 '"start": "'.$row["start"].'",'.
                 '"end": "'.$row["end"].'",'.
                 '"color": "'.$offInfo["color"].'",'.
                 '"category": "'.$offInfo["category"].'",'.
                 '"img": "'.$row["img"].'",'.
                 '"email": "'.$row["email"].'",'.
                 '"employee_status": "'.$row["employee_status"].'" }';
        }
        echo ']}';
    } else{
        echo '{"Total": "0"}';
    }
$conn->close();
