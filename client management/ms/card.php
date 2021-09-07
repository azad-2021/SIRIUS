<?php 

  include 'connection.php';

  $OID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $Date =  date("y/m/d");
  
  function getjobcard() {
    if(isset($_POST['jobcard'])){
    $jobcard = $_POST['jobcard'];     
    }
    return $jobcard;
  }

  function site(){
    if(isset($_POST['site'])){
      $site = $_POST['site'];
      if ($site == 'OK') {
        $siteStatus = 1;
      }else{
        $siteStatus = 0;
      }
        return $siteStatus;
    }
  }

  $Status = site();

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
      move_uploaded_file($file_tmp,"jobcard/".$newfilename);

    /* Insert Data into Approval database */
    $queryAdd="INSERT INTO `approval`( `EmployeeUID`, `BranchCode`, `ComplaintID`, `OrderID`, `JobCardNo`, `Status`, `EmployeeID`, `VisitDate`) VALUES ('$EmployeeUID', '$BranchCode','$complaintID','$OID', '$JOBCARD', '$Status', '$EmployeeUID', '$Date')";
      mysqli_query($con2,$queryAdd);

      echo '<script>alert("File Upload Success and job card no. is '.$JOBCARD.'")</script>';
    }else{
    print_r($errors);
    }

    if(isset($_POST['addTech'])){
      $AddTech = $_POST['addTech'];
      //echo $AddTech;
      if ($AddTech=='YES') {
        header("location:technician.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&cardno=$JOBCARD&oid=$OID&site=$Status");
      }else{
          header("location:more.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID");
      }
    }
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Job Card</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
      fieldset {
        background-color: #eeeeee;
        margin: 5px;
      }

      legend {
        background-color: #26082F;
        color: white;
        padding: 5px 5px;
      }

      .r {
        margin: 5px;
      }
    </style>

  </head>

  <body>

    <div class="container">
      <br><br>
      <!-- Job card section -->
      <form name="fileUpload" action = "" method = "POST" enctype = "multipart/form-data">
        <div class="row">
          <div class="col-lg-2">
            <label><h5>Job card no:</h5></label>
          </div>
          <div class="col-lg-8">
            <input type="text" class="form-control" name="jobcard">
          </div>
          <legend>Upload Job Card File</legend>
          <input type = "file" name = "image" />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <br>
          <center>
            <p>File must be in pdf or jpeg format with size not more than 2MB</p>
            <h5>Site Status:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" name="site" id="site" value="OK">
              <label for="OK">OK</label>
              &nbsp;&nbsp;&nbsp;
              <input type="radio" id="site" name="site" value="NOT OK">
              <label for="NOT OK">Not OK</label>
            </h5>
            <br>
            <h5>More Employees:&nbsp;&nbsp;
              <input type="radio" name="addTech" id="addTech" value="YES">
              <label for="yes">Yes</label>
              &nbsp;
              <input type="radio" id="addTech" name="addTech" value="NO">
              <label for="no">No</label>
            </h5>
            <br>
            <input value="Submit" type = "submit"/> 
          </center>
        </div>
      </form>
      <!-- END of Job section -->
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>

