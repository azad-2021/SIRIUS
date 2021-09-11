<?php 

  include 'connection.php';

  $OID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $approvalID = $_GET['apid'];

  $queryProduct="SELECT * FROM rates"; 
  $resultProduct=mysqli_query($con3,$queryProduct);  //select all products
  $queryProductList= "SELECT * FROM rates inner join add_product on rates.RateID=add_product.paRateID where add_product.paEmployeeID=$EmployeeUID";
  $resultProductList=mysqli_query($con3,$queryProductList);

    $queryBilling="SELECT * FROM add_product where paEmployeeID=$EmployeeUID";
    $resultBilling=mysqli_query($con3,$queryBilling);

  if(isset($_POST['Add']))
  {
    $RateID=$_POST['RateID'];
    $qty=$_POST['qty'];
    $usedas = $_POST['as'];

    $queryCheckStock="SELECT * From rates where RateID=$RateID";
    $resultCheckStock=mysqli_query($con3,$queryCheckStock);
    $dataCheckStock=mysqli_fetch_assoc($resultCheckStock);
    //$stockQTY= $dataCheckStock['qty'];


    $paRateID = $dataCheckStock['RateID'];
    $paDiscription = $dataCheckStock['Discription'];
    $paRate = $dataCheckStock['Rate'];

    $queryAdd="INSERT INTO `add_product`( `paRateID`, `paEmployeeID`, `paDiscription`, `paRate`, `order_id`, `paqty`, `UsedAs`) VALUES ('$paRateID', '$EmployeeUID', '$paDiscription', '$paRate', '$OID', '$qty', '$usedas')";
    mysqli_query($con3,$queryAdd);
    if($queryAdd){
      echo "<meta http-equiv='refresh' content='0'>";
    }  
  }

  if(isset($_POST['submit'])){ 
    $AddEstimate = $_POST['estimate'];

    while($dataBilling=mysqli_fetch_assoc($resultBilling)){
      $RateID = $dataBilling['paRateID'];
      $quantity = $dataBilling['paqty'];
      $UsedAs = $dataBilling['UsedAs'];
      
      /* Insert Data into Billing database */
      $queryAdd="INSERT INTO `pbills`( `ApprovalID`, `RateID`, `UsedAs`, `qty`) VALUES ('$approvalID', '$RateID','$UsedAs', '$quantity')";
      mysqli_query($con3,$queryAdd);
    }

    $queryRemove="DELETE FROM `add_product` WHERE `paEmployeeID`='$EmployeeUID'";
    $resultRemove=mysqli_query($con3,$queryRemove);

    if ($AddEstimate=='YES') {
      header("location:estimate.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID&apid=$approvalID");
    }else{
      header("location:/html/redirect.php?eid=$EmployeeUID");
    }
  }
?>




<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Add Product</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
      <fieldset >
        <legend>Items</legend>
        <div class="col-lg-12" style=" overflow: hidden;">
          <form method="post" action="" class="form-inline">
            <label for="exampleFormControlSelect2">Select Item</label>
            <select  required name="RateID" class="form-control" id="exampleFormControlSelect2" >
              <?php
                while($data=mysqli_fetch_assoc($resultProduct)){

                  echo '<option value='.$data['RateID'].'>'.$data['Discription'].'</option>'; 
                }  
              ?>
            </select>
            <br>
            <label for="quantity">&nbsp;Quantity: &nbsp;&nbsp;</label>
            <input type="text" required class="form-control" name="qty" id="qt">
            &nbsp;&nbsp;&nbsp;
            <label for="as"><h5>as: </h5>&nbsp;&nbsp;&nbsp;&nbsp;</label>
            <select name="as" id="as" id="exampleFormControlSelect2" class="form-control">
              <option value="">Choose option</option>
              <option value="Billing">Billing</option>
              <option value="Waranty">Waranty</option>
              <option value="ASMC">ASMC</option>
              <option value="Standby">Standby</option>
            </select>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit"  class=" btn btn-success" value="Add" name="Add"></input>
          </form>
        </div>      
        <div class="col-lg-12">
          <table id="userTable2" class="display nowrap table-striped table-hover table-sm" id="exampleFormControlSelect2" class="form-control">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col"> Product</th>
                <th scope="col">As</th>
                <th scope="col">Uint Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Price</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php while($data=mysqli_fetch_assoc($resultProductList)){ ?>
                <tr>
                  <td >
                    <?php echo $rateid =$data['paRateID']; ?>
                  </td>
                  <td >
                    <?php echo $data['paDiscription']; ?>
                  </td>
                  <td >
                    <?php echo $data['UsedAs']; ?>
                  </td>
                  <td >
                    <?php echo $data['paRate']; ?>
                  </td>
                  <td >
                    <?php echo $data['paqty']; ?>
                  </td>
                  <td >
                    <?php echo $data['paqty']* $data['paRate']; ?>
                  </td>
                  <td >
                    <form accept="" method="post">
                      <input type="hidden" name="rateid" value=" <?php echo $rateid ?>">
                      <input type="hidden" name="eid" value="<?php echo $EmployeeUID ?>">
                      <input type="hidden" name="nid" value="<?php echo $data['paid'] ?>">
                      <input type="submit" name="removeProduct" value="Remove" class="btn btn-danger">
                    </form>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>       
          <br><br>
        </div>        
        <form method="post" action="">
          <center>
            <h5>Estimate Given:&nbsp;&nbsp;
              <input type="radio" name="estimate" id="estimate" value="YES">
              <label for="yes">Yes</label>
              &nbsp;
              <input type="radio" id="estimate" name="estimate" value="NO">
              <label for="no">No</label>
            </h5>
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


<?php if(isset($_POST['removeProduct']))
  {
    $rate=$_POST['rateid'];
    $eid=$_POST['eid'];
    //$tCode= $_POST['tCode'];

    $queryRemove="DELETE FROM `add_product` WHERE  `paRateID`='$rate' and `paEmployeeID`='$eid'";
    $resultRemove=mysqli_query($con3,$queryRemove);
    if($resultRemove){

      echo "<meta http-equiv='refresh' content='0'>";
    }
  }
?>