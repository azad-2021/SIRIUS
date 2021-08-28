<?php 
include 'connection.php';
if (isset($_GET['oid']) &&  isset($_GET['pid']) ) {
echo $oid=$_GET['oid'];
echo $pid=$_GET['pid'];

$queryRemove="DELETE FROM `invoice_item` WHERE  `order_id`='$oid'  and `pid`='$pid'";
$resultRemove=mysqli_query($con,$queryRemove);

}
else{
	//header("location:index.php");
}
?>