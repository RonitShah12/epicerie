<?php

    $uname = $_GET["username"];
    $pass = $_GET["pass"];

    $conn = new mysqli("localhost:3306", "root", "", "epicerie");

    $pass = hash("md5", $pass);

    $sql = "SELECT * from login where username='$uname' and password='$pass'";
    $result = $conn->query($sql);    

    if( !$result ){
        echo mysqli_error($conn);
    }

    if($result->num_rows > 0){
        echo "present";
    }else{
        echo "not present";
    }
    
    $conn->close();
?>