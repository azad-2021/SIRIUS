<?php 
  
  //$oid=$_GET['oid'];
  $oid=1;

  include 'connection.php';
  $queryEstimate="SELECT * FROM rates"; 
  $resultEstimate=mysqli_query($con3,$queryEstimate);  //select all products
  $queryEstimateList= "SELECT * FROM rates inner join add_estimate on rates.RateID=add_estimate.peRateID where add_estimate.order_id=$oid";
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

      $queryAdd="INSERT INTO `add_estimate`( `peRateID`, `peDiscription`, `peRate`, `order_id`, `peqty`) VALUES ('$peRateID','$peDiscription', '$peRate', '$oid', '$qty')";
      mysqli_query($con3,$queryAdd);
      if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
      }  
    }
?>

<?php if(isset($_POST['removeEstimate']))
  {
    $oid=$_POST['oid'];
    $peid=$_POST['peid'];
    $penid= $_POST['penid'];

    $queryRemove="DELETE FROM `add_estimate` WHERE  `order_id`='$oid' and `peid`='$penid' and `peRateID`='$peid'";
    $resultRemove=mysqli_query($con3,$queryRemove);
    if($resultRemove){

      echo "<meta http-equiv='refresh' content='0'>";
    }
  }
?>