<?php

    $uname = $_GET["username"];
    $pass = $_GET["password"];

    $conn = new mysqli("localhost:3306", "root", "", "epicerie");

    $sql = "insert into login values('$uname', '". hash("md5", $pass) ."')";
    $result = $conn->query($sql);    

    if( $result ){
        echo "inserted";
    }else{
        echo "error";
        echo $conn->error;
    }
    
    $conn->close();
?>