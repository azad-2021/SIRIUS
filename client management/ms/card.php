<?php 
  
  //$pendingOID = $_GET['poid'];
  $pendingOID = 0;
  $complaintID = $_GET['cpid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  
function getjobcard() {
  if(isset($_POST['jobcard'])){
    $jobcard = $_POST['jobcard'];
    //echo $jobcard;
     
  }
return $jobcard;
}



//getStatus();

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
    }else{
    print_r($errors);
    }


    if(isset($_POST['addTech'])){
    $AddTech = $_POST['addTech'];
    //echo $AddTech;
    if ($AddTech=='YES') {
      header("location:test.php?cpid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&cardno=$JOBCARD&poid=$pendingOID");
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
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
    fieldset {
      background-color: #eeeeee;
      margin: 10px;
    }

    legend {
      background-color: #26082F;
      color: white;
      padding: 5px 10px;
    }

    .r {
      margin: 5px;
    }
  </style>

</head>

<body>

  <?php include'navbar.php';?>

  <br>
  <div class="container">

      <!-- Job card section -->

      
      <form name="fileUpload" action = "" method = "POST" enctype = "multipart/form-data">
        <br>
        <div class="row">
          <div class="col-lg-2">
            <label><h5>Job card no:</h5></label>
            </div>
            <div class="col-lg-8">
            <input type="text" class="form-control" name="jobcard">
          </div>
        <legend>Upload Job Card File</legend>
        
        <input type = "file" name = "image" />

        <h5>Add Technician:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="addTech" id="addTech" value="YES">
        <label for="yes">Yes</label>
        &nbsp;&nbsp;&nbsp;
        <input type="radio" id="addTech" name="addtech" value="NO">
        <label for="no">No</label>
        </h5>
      </div>
        <input value="Submit" type = "submit"/> 
      </form>
      <!-- END of Job section -->
      <br>
  </div>
</body>
</html>

