<?php 
  include 'connection.php';

  $OID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $approvalID = $_GET['apid'];
  $Date =  date("d/m/y"); 
  
  $queryEstimate="SELECT * FROM rates"; 
  $resultEstimate=mysqli_query($con3,$queryEstimate);  //select all products
  $queryEstimateList= "SELECT * FROM rates inner join add_estimate on rates.RateID=add_estimate.peRateID where add_estimate.EmployeeUID=$EmployeeUID";
  $resultEstimateList=mysqli_query($con3,$queryEstimateList);

  if(isset($_POST['AddEstimate']))
  {
    $RateID=$_POST['RateID'];
    $qty=$_POST['qty'];
    $queryCheckStock="SELECT * From rates where RateID=$RateID";
    $resultCheckStock=mysqli_query($con3,$queryCheckStock);
    $dataCheckStock=mysqli_fetch_assoc($resultCheckStock);
    $peRateID = $dataCheckStock['RateID'];
    $peDiscription = $dataCheckStock['Discription'];
    $peRate = $dataCheckStock['Rate'];

    $queryAdd="INSERT INTO `add_estimate`( `peRateID`, `peDiscription`, `peRate`,  `peqty`, `EmployeeUID`) VALUES ('$peRateID','$peDiscription', '$peRate', '$qty', $EmployeeUID)";
    mysqli_query($con3,$queryAdd);
    if($queryAdd){
      echo "<meta http-equiv='refresh' content='0'>";
    }  
  }

  if(isset($_POST['submit'])){

    $queryAddEstimate="SELECT * FROM add_estimate WHERE EmployeeUID = $EmployeeUID"; 
    $resultAddEstimate=mysqli_query($con3,$queryAddEstimate);
    while($dataEstimate=mysqli_fetch_assoc($resultAddEstimate)){ 
      $RateID = $dataEstimate['peRateID'];
      $Quantity = $dataEstimate['peqty'];
      $query = "INSERT INTO `estimates`(`ApprovalID`, `RateID`, `Qty`) VALUES ('$approvalID', '$RateID', '$Quantity')";
      mysqli_query($con3,$query);
    }
      $queryRemove="DELETE FROM `add_estimate` WHERE `EmployeeUID`='$EmployeeUID'";
      $resultRemove=mysqli_query($con3,$queryRemove);
      if($resultRemove){
        header("location:invoice.php?oid=$OID&cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&apid=$approvalID");
      //echo "<meta http-equiv='refresh' content='0'>";
    }

  } 
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <title>Estimate</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap core CSS -->
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <style type="text/css">
  <style>
    fieldset {
      background-color: #eeeeee;
      margin: 5px;
      word-wrap: break-word;
      white-space: normal;
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
  <br><br>
  <div class="container">
    <fieldset >
      <legend>Items</legend>
        <div class="col-lg-12" style="width: auto;" >
          <form method="post" action="" class="form-inline">

            <label for="exampleFormControlSelect2">Select Item</label>
            <div style=" overflow: hidden;">
              <div class="col">
            <select  required name="RateID" class="form-control " class="selectpicker" id="exampleFormControlSelect2">
              <?php
                while($data=mysqli_fetch_assoc($resultEstimate)){
                  echo '<option style=" word-wrap: break-word;" value='.$data['RateID'].">".$data['Discription']."</option>"; 
                }  
              ?>
            </select>
            </div>
          </div>
            <label for="quantity">&nbsp;&nbsp;&nbsp;Quantity: &nbsp;&nbsp;</label>
            <input type="text" required class="form-control" name="qty" id="qt">
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit"  class=" btn btn-success" value="Add" name="AddEstimate"></input>
          </form>
        </div>
        <br><br>
        <div class="col-lg-12 table-responsive" style="width: auto;">
          <table id="userTable2" class="display nowrap table-striped table-hover table-sm" id="exampleFormControlSelect2" class="form-control">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col"> Product</th>
                <th scope="col">Uint Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>

            <tbody>
              <?php while($data=mysqli_fetch_assoc($resultEstimateList)){ ?>
                <tr>
                  <td >
                    <?php echo $ipaid =$data['peRateID']; ?>
                  </td>
                  <td >
                    <?php echo $data['peDiscription']; ?>
                  </td>
                  <td >
                    <?php echo $data['peRate']; ?>
                  </td>
                  <td >
                    <?php echo $data['peqty']; ?>
                  </td>
                  <td >
                    <?php echo $data['peqty']* $data['peRate']; ?>
                  </td>
                  <td >
                    <form accept="" method="post">
                      <input type="hidden" name="peid" value=" <?php echo $ipaid ?>">
                      <input type="hidden" name="eid" value="<?php echo $EmployeeUID ?>">
                      <input type="hidden" name="penid" value="<?php echo $data['peid'] ?>">
                      <input type="submit" name="removeEstimate" value="Remove" class="btn btn-danger">
                    </form>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <br><br>
        <form method="post" action="">
          <center>
            <input type="submit"  class=" btn btn-success" value="submit" name="submit"></input>
          </center>
      </form>  
      </fieldset>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js
"></script>

    <script type="text/javascript">
      
        $(document).ready(function() {
             var table = $('#userTable2').DataTable( {
                rowReorder: {
                selector: 'td:nth-child(2)'
                },
                responsive: true
            } );
        } );
    </script>
  </body>
</html>


<?php if(isset($_POST['removeEstimate']))
  {
    $peid=$_POST['peid'];
    $penid= $_POST['penid'];

    $queryRemove="DELETE FROM `add_estimate` WHERE  `EmployeeUID`='$EmployeeUID' and `peid`='$penid'";
    $resultRemove=mysqli_query($con3,$queryRemove);
    if($resultRemove){

      echo "<meta http-equiv='refresh' content='0'>";
    }
  }
?>