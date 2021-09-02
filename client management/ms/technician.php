<?php 



  include 'connection.php';

  $UID=5;
  $queryTech="SELECT * FROM employees"; 
  $resultTech=mysqli_query($con2,$queryTech);  //select all products
  $queryTechnicianList= "SELECT * FROM employees inner join add_technician on employees.EmployeeCode=add_technician.TechnicianID where add_technician.EmployeeUID=$UID";
  $resultTechnicianList=mysqli_query($con2,$queryTechnicianList);


  if(isset($_POST['Addtech']))
  {
    $EmployeeID=$_POST['EmployeeCode'];
    $querytechnician="SELECT * From employees where EmployeeCode=$EmployeeID";
    $resultTechnician=mysqli_query($con2,$querytechnician);
  }


    if(isset($_POST['Addtech']))
  {
    $EmployeeID=$_POST['EmployeeCode'];

    $queryCheckTechnician="SELECT * From employees where EmployeeCode=$EmployeeID";
    $resultCheckTechnician=mysqli_query($con2,$queryCheckTechnician);
    $dataCheckTechnician=mysqli_fetch_assoc($resultCheckTechnician);
    $TechnicianName = $dataCheckTechnician['Employee Name'];
    $TechnicianContact = $dataCheckTechnician['Phone'];
    $TechnicianCode = $dataCheckTechnician['Employee Code'];

      $queryAdd="INSERT INTO `add_technician` (`tanid`, `EmployeeUID`, `TechnicianID`, `TechnicianName`, `TechnicianContact`, `TechnicianCode`) VALUES ('', '$UID', '$EmployeeID', '$TechnicianName', $TechnicianContact, 'TechnicianCode');";
      mysqli_query($con2,$queryAdd);  
    }


?>


<?php if(isset($_POST['removeTechnician']))
  {
    $ttid=$_POST['ttid'];
    $tid=$_POST['tid'];
    $tCode= $_POST['tCode'];

    $queryRemove="DELETE FROM `add_technician` WHERE  `TechnicianID`='$ttid' and `EmployeeUID`='$UID' and `TechnicianCode`='$tCode'";
    $resultRemove=mysqli_query($con2,$queryRemove);
    if($resultRemove){

      //echo "<meta http-equiv='refresh' content='0'>";
    echo 'success';
    }
  }
?>
