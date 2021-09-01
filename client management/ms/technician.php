<?php 



  include 'connection.php';

  $tid=2;
  $queryTech="SELECT * FROM technician"; 
  $resultTech=mysqli_query($con2,$queryTech);  //select all products
  $queryTechnicianList= "SELECT * FROM technician inner join add_technician on technician.tid=add_technician.taid where add_technician.taid=$tid";
  $resultTechnicianList=mysqli_query($con2,$queryTechnicianList);


  if(isset($_POST['Addtech']))
  {
    $tid=$_POST['tid'];
    $querytechnician="SELECT * From technician where tid=$tid";
    $resultTechnician=mysqli_query($con2,$querytechnician);
  }


    if(isset($_POST['Addtech']))
  {
    $tid=$_POST['tid'];

    $queryCheckTechnician="SELECT * From technician where tid=$tid";
    $resultCheckTechnician=mysqli_query($con2,$queryCheckTechnician);
    $dataCheckTechnician=mysqli_fetch_assoc($resultCheckTechnician);
    $tName = $dataCheckTechnician['tName'];
    $tContact = $dataCheckTechnician['tContact'];
    $tEmail = $dataCheckTechnician['tEmail'];

    echo $tName;
    echo $tContact;
    echo $tid;
    echo $tEmail;

      $queryAdd="INSERT INTO `add_technician` (`tanid`, `taid`, `taName`, `taContact`, `taEmail`) VALUES ('', '$tid', '$tName', $tContact, 'tEmail');";
      mysqli_query($con2,$queryAdd);
      if($queryAdd){
        sleep(5);
        echo "<meta http-equiv='refresh' content='0'>";
      }  
    }


?>