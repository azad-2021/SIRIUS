<?php 
  include 'connection.php';
  $OID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];

  $queryApprovalID="SELECT ApprovalID FROM approval where EmployeeUID=$EmployeeUID";
  $resultApprovalID=mysqli_query($con2,$queryApprovalID);
  $dataApprovalID=mysqli_fetch_assoc($resultApprovalID);
  $approvalID = $dataApprovalID['ApprovalID'];

  if(isset($_POST['submit'])){
    $material = $_POST['material'];
    if ($material=='YES') {
     header("location:product.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID&apid=$approvalID");
    }else{
      header("location:/html/est.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID&apid=$approvalID");
    }
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>add product</title>
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
    <br><br>
    <div class="container">
      <fieldset>
        <form method="post" action="">
          <h5 align="center">Material Consumed:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="material" id="material" value="YES">
            <label for="OK">Yes</label>
            &nbsp;&nbsp;&nbsp;
            <input type="radio" id="material" name="material" value="NO">
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