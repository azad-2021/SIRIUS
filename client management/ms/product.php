<?php 
  
  //$oid=$_GET['oid'];
  $OID = $_GET['oid'];
  //$card = $_GET['cardno'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];


  include 'connection.php';
  $queryProduct="SELECT * FROM rates"; 
  $resultProduct=mysqli_query($con3,$queryProduct);  //select all products
  $queryProductList= "SELECT * FROM rates inner join add_product on rates.RateID=add_product.paRateID where add_product.paEmployeeID=$EmployeeUID";
  $resultProductList=mysqli_query($con3,$queryProductList);

    $queryApprovalID="SELECT ApprovalID FROM approval where EmployeeUID=$EmployeeUID";
    $resultApprovalID=mysqli_query($con2,$queryApprovalID);
    $dataApprovalID=mysqli_fetch_assoc($resultApprovalID);
    $approvalID = $dataApprovalID['ApprovalID'];

    $queryBilling="SELECT * FROM add_product where paEmployeeID=$EmployeeUID";
    $resultBilling=mysqli_query($con3,$queryBilling);

  if(isset($_POST['Add']))
  {
    $RateID=$_POST['RateID'];
    $qty=$_POST['qty'];
    $queryCheckStock="SELECT * From rates where RateID=$RateID";
    $resultCheckStock=mysqli_query($con3,$queryCheckStock);
    $dataCheckStock=mysqli_fetch_assoc($resultCheckStock);
    //$stockQTY= $dataCheckStock['qty'];


    $paRateID = $dataCheckStock['RateID'];
    $paDiscription = $dataCheckStock['Discription'];
    $paRate = $dataCheckStock['Rate'];

      $queryAdd="INSERT INTO `add_product`( `paRateID`, `paEmployeeID`, `paDiscription`, `paRate`, `order_id`, `paqty`) VALUES ('$paRateID', '$EmployeeUID', '$paDiscription', '$paRate', '$OID', '$qty')";
      mysqli_query($con3,$queryAdd);
      if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
      //echo 'success';
      }  
    }

    if(isset($_POST['submit'])){

      function Asdata(){
        if(isset($_POST['as'])){
        $as = $_POST['as'];
        if ($as == 'billing') {
          $Used = 'Billing';
          //echo $UsedAs;
        }elseif($as=='waranty'){
          $Used = 'Waranty';
          //echo $UsedAs;
        }elseif($as=='asmc'){
          $Used = 'ASMC';
          //echo $UsedAs;
        }else{
          $Used = 'Standby';
          //echo $UsedAs;
        }

      }else{
          echo '<script>alert("Please select As option")</script>';
        }
        return $Used;
      }


      $UsedAs = Asdata();
      while($dataBilling=mysqli_fetch_assoc($resultBilling)){
      //$usedAs = 'Billing';
      $RateID = $dataBilling['paRateID'];
      $quantity = $dataBilling['paqty'];
      
      
      /* Insert Data into Billing database */
      $queryAdd="INSERT INTO `pbills`( `ApprovalID`, `RateID`, `UsedAs`, `qty`) VALUES ('$approvalID', '$RateID','$UsedAs', '$quantity')";
      mysqli_query($con3,$queryAdd);
    }
      $queryRemove="DELETE FROM `add_product` WHERE `paEmployeeID`='$EmployeeUID'";
      $resultRemove=mysqli_query($con3,$queryRemove);


    if(isset($_POST['estimate'])){
      $AddEstimate = $_POST['estimate'];
      echo $approvalID;
      if ($AddEstimate=='YES') {
        header("location:estimate.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID&apid=$approvalID");
      }else{
          header("location:----.php?cpid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&cardno=$JOBCARD&poid=$pendingOID");
      }
    }

}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Product</title>
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

        <fieldset >
          <legend>Items</legend>
          <div class="col-lg-12">
            <form method="post" action="" class="form-inline">
                <label for="exampleFormControlSelect2">Select Item</label>
                <select  required name="RateID" class="form-control" id="exampleFormControlSelect2" >
                  <?php

                     while($data=mysqli_fetch_assoc($resultProduct)){

                        echo "<option value=".$data['RateID'].">".$data['Discription']."</option>"; 
                      }  
                  ?>
                </select>
                <label for="quantity">&nbsp;&nbsp;&nbsp;Quantity: &nbsp;&nbsp;</label>
                <input type="text" required class="form-control" name="qty" id="qt">
                <br>&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit"  class=" btn btn-success" value="Add" name="Add"></input>
            </form>
          </div>      

          <div class="col-lg-12">
            <table class="table">
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
                <?php while($data=mysqli_fetch_assoc($resultProductList)){ ?>
                    <tr>
                      <td >
                        <?php echo $rateid =$data['paRateID']; ?>
                      </td>
                      <td >
                         <?php echo $data['paDiscription']; ?>
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
        </fieldset>
      </div>
    </div>
      <form method="post" action="">

        <h5 align="center">Material Consumed as:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="as" id="as" value="billing">
        <label for="billing">Billing</label>
        &nbsp;&nbsp;&nbsp;
        <input type="radio" id="as" name="as" value="waranty">
        <label for="NO">Waranty</label>
        &nbsp;&nbsp;&nbsp;
        <input type="radio" id="as" name="as" value="asmc">
        <label for="asmc">ASMC</label>
        &nbsp;&nbsp;&nbsp;
        <input type="radio" id="as" name="as" value="standby">
        <label for="NO">Standby</label>
        </h5>
        <br>


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
   <!-- END of Technician section -->
      <br>
  </div>
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
    //echo 'Technician deleted success';
    }
  }
?>