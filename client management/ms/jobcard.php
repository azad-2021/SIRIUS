<?php

include 'connection.php';
  function getjobcard() {
  if(isset($_POST['jobcard'])){
    $jobcard = $_POST['jobcard'];
    //echo $jobcard;
  return $jobcard;
  }

}
  echo $complaintID;
function getStatus() {
  if(isset($_POST['site'])){
    $status = $_POST['site'];
    //echo $status;

  }

  if (empty($_POST['site'])) {
    $status = 0;
    //echo $status;
  }
     
return $status;
}

/*
  function billingData() {
    $queryCheckTechnician="SELECT * From employees where EmployeeCode=$EmployeeID";
    $resultCheckTechnician=mysqli_query($con2,$queryCheckTechnician);
    $dataCheckTechnician=mysqli_fetch_assoc($resultCheckTechnician);
    $TechnicianName = $dataCheckTechnician['Employee Name'];
    $TechnicianContact = $dataCheckTechnician['Phone'];
    $TechnicianCode = $dataCheckTechnician['Employee Code'];

  }
*/

  if(isset($_FILES['image'])){
    $errors= array();
    $JOBCARD = getjobcard();
    //echo $JOBCARD;
    $file_name = $_FILES['image']['name'];
    $file_name = 'data';
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $tmp = explode('.', $_FILES['image']['name']);
    $file_ext = strtolower(end($tmp));
   // $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $newfilename=$JOBCARD.".".$file_ext;         
    $extensions= array("jpeg","jpg","pdf,");
              
    if(in_array($file_ext,$extensions)=== false){
      $errors ='<script>alert("File must be JPG, JPEG or pdf")</script>';
    }
              
    if($file_size > 2097152){
      $errors ='<script>alert("File must be less than 2MB")</script>';
    }
              
    if(empty($errors)==true){
    $JOBCARD = getjobcard();
    //echo $JOBCARD;
      move_uploaded_file($file_tmp,"image/".$newfilename);
      echo '<script>alert("File Upload Success and job card no. is '.$JOBCARD.'")</script>';

  $card = getjobcard();
  $siteStatus = getStatus();
  echo $card; 
  echo $siteStatus;
/*
 $queryAdd="INSERT INTO `approval`( `BranchCode`, `ComplaintID`, `OrderID`, `JobCardNo`, `Status`, `EmployeeID`) VALUES ('$BranchCode','$complaintID','', '$card', '$siteStatus', '$Employeeid')";
    mysqli_query($con2,$queryAdd);
  if($queryAdd){
    //echo "<meta http-equiv='refresh' content='0'>";
    echo 'success';
  }*/


  $queryTechnician="SELECT TechnicianID FROM add_technician"; 
  $resultTechnician=mysqli_query($con2,$queryTechnician);  //select all products
  //$dataTechnician=mysqli_fetch_assoc($resultTechnician);
  //echo $dataTechnician;
  while($data=mysqli_fetch_assoc($resultTechnician)){
   echo $te = $data['TechnicianID'];
    echo $te;

 $queryAdd="INSERT INTO `approval`( `BranchCode`, `ComplaintID`, `OrderID`, `JobCardNo`, `Status`, `EmployeeID`) VALUES ('$BranchCode','$complaintID','', '$card', '$siteStatus', '$te')";
    mysqli_query($con2,$queryAdd);

  if($queryAdd){
    //echo "<meta http-equiv='refresh' content='0'>";
    echo 'success';
  }


  }

 }
}

?>