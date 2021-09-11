<?php 

  $OID = $_GET['oid'];
  //$card = $_GET['cardno'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  include 'connection.php';

      if(isset($_POST['submit'])){
      $more = $_POST['more'];
      echo $more;
      if ($more=='YES') {
        header("location:card.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID");
      }else{
         header("location:pro.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID");
      }
    }

    ?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>more card</title>
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
          <h5 align="center">More cards:<br><br>
            <input type="radio" name="more" id="more" value="YES">
            <label for="YES">Yes</label>
            &nbsp;&nbsp;&nbsp;
            <input type="radio" id="more" name="more" value="NO">
            <label for="NO">No</label>
          </h5>
          <br><br>
          <center>
          <input type="submit"  class=" btn btn-success" value="submit" name="submit"></input>
          </center>      
        </form>
        <br>
      </fieldset>
    </div>
  </body>
</html>