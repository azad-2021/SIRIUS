<?php

  include 'ms/connection.php';

  $OID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $UID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $approvalID = $_GET['apid'];
  

  if(isset($_POST['submit'])){
    $estimate = $_POST['estimate'];
    if ($estimate =='YES') {
      header("location:ms/estimate.php?cid=$complaintID&eid=$UID&brcode=$BranchCode&oid=$OID&apid=$approvalID");
    }else{
        header("location:redirect.php?eid=$UID");
    }
  }
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Estimate</title>
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
          <h5 align="center">Estimate Given:<br><br>
            <input type="radio" name="estimate" id="estimate" value="YES">
            <label for="OK">Yes</label>
            &nbsp;&nbsp;&nbsp;
            <input type="radio" id="estimate" name="estimate" value="NO">
            <label for="NOT OK">No</label>
          </h5>
          <br> <br>
          <center>
          <input type="submit"  class=" btn btn-success" value="submit" name="submit"></input>
          </center>      
        </form>
      </fieldset>
    </div>
  </body>
</html>