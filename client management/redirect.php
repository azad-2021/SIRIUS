<?php 


  $UID = $_GET['eid'];
  include 'ms/connection.php';

    $queryName="SELECT * FROM employees where EmployeeCode=$UID";
    $resultName=mysqli_query($con2,$queryName);
    $dataName=mysqli_fetch_assoc($resultName);
    $name = $dataName['Employee Name'];
    //echo $name;
    include 'home.php';

    ?>