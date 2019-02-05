<?php

    $uname = $_GET["username"];
    $pass = $_GET["password"];

    $conn = new mysqli("localhost:3306", "root", "", "epicerie");

    $pass = hash("md5", $pass);

    $sql = "SELECT * FROM login WHERE BINARY username='$uname' and password='$pass'";
    $result = $conn->query($sql);    

    if( !$result ){
        echo mysqli_error($conn);
    }

    if($result->num_rows > 0){
        echo "shopping.php";
    }else{
        echo "0";
    }
    
    $conn->close();
?>