<?php      
    $host = "localhost";  
    $user = "root";  
    $password = '';  
    $db_1 = "test";
    $db_2 = "backend";
    $db_3 = "billing";  
      
    $con = mysqli_connect($host, $user, $password, $db_1);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }

    $con2 = mysqli_connect($host, $user, $password, $db_2);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    } 
?>  