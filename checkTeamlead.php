
<?php
    header('Access-Control-Allow-Origin: *');
    
    session_start();
    $host = "localhost";
    $port = 3306;
    $socket = "";
    $user = "root";
    $password = "";
    $dbname = "ett_db";
    
    $conn = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die('Could not connect to the database server' . mysqli_connect_error());
    
    $empy_id = $_GET['i'];
    $sql2 = "SELECT * FROM department_head where googleId = ".$empy_id;
    $result2 = $conn->query($sql2);
    $rows = $result2->num_rows;

    if($rows > 0){
        echo '1';
    } else{
        echo 'ss';
    }
$conn->close();
