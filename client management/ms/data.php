<?php 
  
  //$oid=$_GET['oid'];
  $pendingOID = $_GET['poid'];
  $card = $_GET['cardno'];
  $complaintID = $_GET['cpid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $Date =  date("d/m/y");
  //echo $Date;
  include 'connection.php';
  $queryProduct="SELECT * FROM rates"; 
  $resultProduct=mysqli_query($con3,$queryProduct);  //select all products
  $queryProductList= "SELECT * FROM rates inner join add_product on rates.RateID=add_product.paRateID where add_product.paEmployeeID=$EmployeeUID";
  $resultProductList=mysqli_query($con3,$queryProductList);


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

      $queryAdd="INSERT INTO `add_product`( `paRateID`, `paEmployeeID`, `paDiscription`, `paRate`, `order_id`, `paqty`) VALUES ('$paRateID', '$EmployeeUID', '$paDiscription', '$paRate', '$pendingOID', '$qty')";
      mysqli_query($con3,$queryAdd);
      if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
      //echo 'success';
      }  
    }



  $queryTech="SELECT * FROM employees"; 
  $resultTech=mysqli_query($con2,$queryTech);  //select all products
  $queryTechnicianList= "SELECT * FROM employees inner join add_technician on employees.EmployeeCode=add_technician.TechnicianID where add_technician.EmployeeUID=$EmployeeUID";
  $resultTechnicianList=mysqli_query($con2,$queryTechnicianList);


  if(isset($_POST['Addtech']))
  {
    $EmployeeID=$_POST['EmployeeCode'];
    $querytechnician="SELECT * From employees where EmployeeCode=$EmployeeID";
    $resultTechnician=mysqli_query($con2,$querytechnician);
  }


    if(isset($_POST['Addtech']))
  {
    $EmployeeID=$_POST['EmployeeCode'];

    $queryCheckTechnician="SELECT * From employees where EmployeeCode=$EmployeeID";
    $resultCheckTechnician=mysqli_query($con2,$queryCheckTechnician);
    $dataCheckTechnician=mysqli_fetch_assoc($resultCheckTechnician);
    $TechnicianName = $dataCheckTechnician['Employee Name'];
    $TechnicianContact = $dataCheckTechnician['Phone'];
    $TechnicianCode = $dataCheckTechnician['Employee Code'];

      $queryAddtech="INSERT INTO `add_technician` (`tanid`, `EmployeeUID`, `TechnicianID`, `TechnicianName`, `TechnicianContact`, `TechnicianCode`) VALUES ('', '$EmployeeUID', '$EmployeeID', '$TechnicianName', $TechnicianContact, 'TechnicianCode');";
      mysqli_query($con2,$queryAddtech);

      if($queryAddtech){
        echo "<meta http-equiv='refresh' content='0'>";
      }

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


    if(isset($_POST['submit'])){
      if(isset($_POST['as'])){
        $as = $_POST['as'];
        if ($as == 'billing') {
          $UsedAs = 'Billing';
          //echo $UsedAs;
        }elseif($as=='waranty'){
          $UsedAs = 'Waranty';
          //echo $UsedAs;
        }elseif($as=='asmc'){
          $UsedAs = 'ASMC';
          //echo $UsedAs;
        }else{
          $UsedAs = 'Standby';
          //echo $UsedAs;
        }

      }else{
          echo '<script>alert("Please select As option")</script>';
        }


        /* technician section*/

    $queryTechnician="SELECT TechnicianID FROM add_technician"; 
    $resultTechnician=mysqli_query($con2,$queryTechnician);  //select all products
    //$dataTechnician=mysqli_fetch_assoc($resultTechnician);
    //echo $dataTechnician;
    while($data=mysqli_fetch_assoc($resultTechnician)){
     $te = $data['TechnicianID'];
     $Date =  date("d/m/y");

      //echo $te;

         /* Insert Data into Approval database */
    $queryAdd="INSERT INTO `approval`( `EmployeeUID`, `BranchCode`, `ComplaintID`, `OrderID`, `JobCardNo`, `Status`, `EmployeeID`, `VisitDate`) VALUES ('$EmployeeUID', '$BranchCode','$complaintID','$pendingOID', '$card', '$Status', '$te', '$Date')";
      mysqli_query($con2,$queryAdd);
    }

    $queryRemove="DELETE FROM `add_technician` WHERE `EmployeeUID`='$EmployeeUID'";
    $resultRemove=mysqli_query($con2,$queryRemove);
    
     $queryAddUID="INSERT INTO `approval`( `EmployeeUID`, `BranchCode`, `ComplaintID`, `OrderID`, `JobCardNo`, `Status`, `EmployeeID`, `VisitDate`) VALUES ('$EmployeeUID', '$BranchCode','$complaintID','$pendingOID', '$card', '$Status', '$EmployeeUID', '$Date')";
     mysqli_query($con2,$queryAddUID);



    /* Approval Id fetch */

    $queryApprovalID="SELECT ApprovalID FROM approval where EmployeeUID=$EmployeeUID and EmployeeID=$EmployeeUID";
    $resultApprovalID=mysqli_query($con2,$queryApprovalID);
    $dataApprovalID=mysqli_fetch_assoc($resultApprovalID);
    $approvalID = $dataApprovalID['ApprovalID'];
    //echo 'ApprovalID is: ';
    //echo $approvalID;

    /* Billing section */
    $queryBilling="SELECT * FROM add_product where paEmployeeID=$EmployeeUID";
    $resultBilling=mysqli_query($con3,$queryBilling);
      
      //echo 'Billing data: ';
      //echo $RateID;
      //echo $quantity;


      while($dataBilling=mysqli_fetch_assoc($resultBilling)){
      $usedAs = 'Billing';
      $RateID = $dataBilling['paRateID'];
      $quantity = $dataBilling['paqty'];
      

      /* Insert Data into Billing database */
      $queryAdd="INSERT INTO `pbills`( `ApprovalID`, `RateID`, `UsedAs`, `qty`) VALUES ('$approvalID', '$RateID','$usedAs', '$quantity')";
      mysqli_query($con3,$queryAdd);
    }

      if($queryAdd){
      //echo "<meta http-equiv='refresh' content='0'>";
      $queryRemove="DELETE FROM `add_product` WHERE `paEmployeeID`='$EmployeeUID'";
      $resultRemove=mysqli_query($con3,$queryRemove);
        header("location:card.php?cpid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&poid=$pendingOID&cardno=$card");
        }else{
         header("location:data.php?cpid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode");
        }
    }

?>

    <?php if(isset($_POST['removeProduct']))
  {
    $oid=$_POST['oid'];
    $pid=$_POST['pid'];
    $nid= $_POST['nid'];

    $queryRemove="DELETE FROM `add_product` WHERE  `order_id`='$oid' and `paid`='$nid' and `paRateID`='$pid'";
    $resultRemove=mysqli_query($con3,$queryRemove);
    if($resultRemove){

      echo "<meta http-equiv='refresh' content='0'>";
    }
  }
?>





<!DOCTYPE html>
<html lang="en">
<head>
  <title>Insert Data</title>
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
                        <?php echo $ipid =$data['paRateID']; ?>
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
                            <input type="hidden" name="pid" value=" <?php echo $ipid ?>">
                            <input type="hidden" name="oid" value="<?php echo $oid ?>">
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
        <!-- END of Material section -->   

       <!-- Add technician Section -->
      <fieldset >
        <legend>Add Technician</legend>
        
          <div class="col-lg-12">
            <form method="post" action="" class="form-inline">
                <label for="exampleFormControlSelect2">Select Technician
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <select  required name="EmployeeCode" class="form-control" id="exampleFormControlSelect2" >
                  <?php

                     while($data=mysqli_fetch_assoc($resultTech)){

                        echo "<option value=".$data['EmployeeCode'].">".$data['Employee Name']."</option>";
                      }  
                  ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit"  class=" btn btn-success" value="Add" name="Addtech"></input>
            </form>
          </div>  

          <div class="col-lg-12">
            <table class="table">
             <thead>
               <tr>
                 <th scope="col">Id</th>
                 <th scope="col">Name</th>
                 <th scope="col">Contact Number</th>
               </tr>
             </thead>

              <tbody>
                <?php while($data=mysqli_fetch_assoc($resultTechnicianList)){ ?>
                    <tr>
                      <td >
                        <?php echo $ttid =$data['TechnicianID']; ?>
                      </td>
                      <td >
                         <?php echo $data['TechnicianName']; ?>
                      </td>
                      <td >
                        <?php echo $data['TechnicianContact']; ?>
                      </td>
                      <td >
                      <td >
                          <form accept="" method="post">
                            <input type="hidden" name="ttid" value=" <?php echo $ttid ?>">
                            <input type="hidden" name="tid" value="<?php echo $tid ?>">
                            <input type="hidden" name="tCode" value="<?php echo $data['TechnicianCode'] ?>">
                            <input type="submit" name="removeTechnician" value="Remove" class="btn btn-danger">
                          </form>
                      </td>
                    </tr>

                <?php } ?>
              </tbody>
            </table>
              
        <br><br>  
      </fieldset>
      <form method="post" action="">


        <h5 align="center">Material Consumed:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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


        <h5 align="center">Site Status:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="site" id="site" value="OK">
        <label for="OK">OK</label>
        &nbsp;&nbsp;&nbsp;
        <input type="radio" id="site" name="site" value="NOT OK">
        <label for="NOT OK">Not OK</label>
        </h5>
        <br>


        <center>
        <input type="submit"  class=" btn btn-success" value="submit" name="submit"></input>
        </center>      
      </form>
   <!-- END of Technician section -->
      <br>
  </div>
</body>
</html>


<?php if(isset($_POST['removeTechnician']))
  {
    $ttid=$_POST['ttid'];
    $tid=$_POST['tid'];
    //$tCode= $_POST['tCode'];

    $queryRemove="DELETE FROM `add_technician` WHERE  `TechnicianID`='$ttid' and `EmployeeUID`='$EmployeeUID'";
    $resultRemove=mysqli_query($con2,$queryRemove);
    if($resultRemove){

      echo "<meta http-equiv='refresh' content='0'>";
    //echo 'Technician deleted success';
    }
  }
?>