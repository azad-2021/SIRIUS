<?php 
  include 'connection.php';

  $OID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $approvalID = $_GET['apid'];
 
  $queryName="SELECT * FROM employees where EmployeeCode=$EmployeeUID";
  $resultName=mysqli_query($con2,$queryName);
  $dataName=mysqli_fetch_assoc($resultName);
  $name = $dataName['Employee Name'];

  if(isset($_POST['submit'])){
    $estimate = $_POST['estimate'];
    if ($estimate =='YES') {
      header("location:estimate.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID&apid=$approvalID");
    }else{
      include 'home.php';
    }
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Est</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
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
    <br><br>
    <div class="container">
      <fieldset>
        <br><br>
        <form method="post" action="">
          <h5 align="center">Estimate Given:<br><br><br>
          <input type="radio" name="estimate" id="estimate" value="YES">
          <label for="OK">Yes</label>
          &nbsp;&nbsp;&nbsp;
          <input type="radio" id="estimate" name="estimate" value="NO">
          <label for="NOT OK">No</label>
          </h5>
          <br><br>
          <center>
          <input type="submit"  class=" btn btn-success" value="submit" name="submit"></input>
          </center>      
        </form>
      </fieldset>
    </div>
  </body>
</html>