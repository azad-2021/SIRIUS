<?php      
    $host = "localhost";  
    $user = "root";  
    $password = 'root@123';  
    $db_name = "cyrus";  
      
    $con = mysqli_connect($host, $user, $password, $db_name);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
?>  