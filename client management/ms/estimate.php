<?php 
  
  $pendingOID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $Date =  date("d/m/y"); 
  
  include 'connection.php';
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
    //$stockQTY= $dataCheckStock['qty'];


    $peRateID = $dataCheckStock['RateID'];
    $peDiscription = $dataCheckStock['Discription'];
    $peRate = $dataCheckStock['Rate'];

      $queryAdd="INSERT INTO `add_estimate`( `peRateID`, `peDiscription`, `peRate`,  `peqty`, `EmployeeUID`) VALUES ('$peRateID','$peDiscription', '$peRate', '$qty', $EmployeeUID)";
      mysqli_query($con3,$queryAdd);
      if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
      }  
    }

    if(isset($_POST['card'])){
    $estimate = $_POST['card'];
    if ($estimate=='card') {
      header("location:card.php?cpid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&poid=$pendingOID");
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.3/jquery.min.js"></script>
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

                     while($data=mysqli_fetch_assoc($resultEstimate)){

                        echo "<option value=".$data['RateID'].">".$data['Discription']."</option>"; 
                      }  
                  ?>
                </select>
                <label for="quantity">&nbsp;&nbsp;&nbsp;Quantity: &nbsp;&nbsp;</label>
                <input type="text" required class="form-control" name="qty" id="qt">
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit"  class=" btn btn-success" value="Add" name="AddEstimate"></input>
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
        </fieldset>

  </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
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