<?php 
  
  //$oid=$_GET['oid'];
  $oid=1;

  include 'connection.php';
  $queryProduct="SELECT * FROM rates"; 
  $resultProduct=mysqli_query($con3,$queryProduct);  //select all products
  $queryProductList= "SELECT * FROM rates inner join add_product on rates.RateID=add_product.paRateID where add_product.order_id=$oid";
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

      $queryAdd="INSERT INTO `add_product`( `paRateID`, `paDiscription`, `paRate`, `order_id`, `paqty`) VALUES ('$paRateID','$paDiscription', '$paRate', '$oid', '$qty')";
      mysqli_query($con3,$queryAdd);
      if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
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