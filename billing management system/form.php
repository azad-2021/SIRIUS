<?php 
include 'session.php';

include 'connection.php';
$cid = $_GET['Cid'];
  if(!isset( $_GET['Cid']))
  {
    header('location:customer.php');
  }

  $oid=$_GET['Oid'];
  $queryProduct="SELECT * FROM products"; 
  $resultProduct=mysqli_query($con,$queryProduct);

  $queryCustomerDetails="SELECT * FROM customer where cid=$cid";
  $resultCustomerDetails=mysqli_query($con,$queryCustomerDetails);
  $dataCustomer=mysqli_fetch_assoc($resultCustomerDetails);
  $queryProductList= "SELECT * FROM products inner join invoice_item on products.pid=invoice_item.pid where invoice_item.order_id=$oid";
  $resultProductList=mysqli_query($con,$queryProductList);


if(isset($_POST['Add']))
{
  $pid=$_POST['pid'];
  $qty=$_POST['qty'];
  $queryCheckStock="SELECT * From products where pid=$pid";
  $resultCheckStock=mysqli_query($con,$queryCheckStock);
  $dataCheckStock=mysqli_fetch_assoc($resultCheckStock);
   $stockQTY= $dataCheckStock['qty'];

      if($qty<=$stockQTY){
        $queryAdd="INSERT INTO `invoice_item`( `order_id`, `pid`, `qty`) VALUES ('$oid','$pid','$qty')";
      mysqli_query($con,$queryAdd);
       if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
      }  
    
    
}
  else{
  echo '<script>alert("Product Quantity More Then Stock Quantity (available: '.$stockQTY.')")</script>';
  }
  
  
}

if(isset($_POST['calculation']))
{
  $date=date('Y-m-d');
  $gstType= $_POST['gstType'];
   $gstPer= $_POST['perGST'];
  $queryCalculation= "SELECT SUM(products.price*invoice_item.Qty) AS subTotal FROM products inner join invoice_item on products.pid=invoice_item.pid where invoice_item.order_id=$oid";
  $resultCalculation=mysqli_query($con,$queryCalculation);
  $dataCalculation=mysqli_fetch_assoc($resultCalculation);
  $subTotal =$dataCalculation['subTotal'];
  $gst=(($gstPer*$subTotal)/100);
  $Total = $subTotal +$gst;
  $queryUpdateOrder = "UPDATE `order_invoice` SET `orderDate`='$date' ,`gstType`='$gstType',`itemTotal`='$subTotal',`GST`='$gst',`InvoiceTotal`='$Total' WHERE oid=$oid";
  mysqli_query($con,$queryUpdateOrder);
 

}
if(isset($_POST['generate']))
{
  $date=date('Y-m-d');
  $gstType= $_POST['gstType'];
  $gstPer= $_POST['perGST'];
  $queryCalculation= "SELECT SUM(products.price*invoice_item.Qty) AS subTotal, products.qty as qty , invoice_item.Qty as QTY FROM products inner join invoice_item on products.pid=invoice_item.pid where invoice_item.order_id=$oid";
  $resultCalculation=mysqli_query($con,$queryCalculation);
  $dataCalculation=mysqli_fetch_assoc($resultCalculation);
  $subTotal =$dataCalculation['subTotal'];
  $gst=(($gstPer*$subTotal)/100);
  $Total = $subTotal +$gst;

echo $availableQty=$dataCalculation['qty']-$dataCalculation['QTY'];
 // $updateProductStock="UPDATE `products` SET `orderDate`='$date' ,`gstType`='$gstType',`itemTotal`='$subTotal',`GST`='$gst',`InvoiceTotal`='$Total' WHERE pid=$pid";

/*
   $queryUpdateOrder = "UPDATE `order_invoice` SET `orderDate`='$date' ,`gstType`='$gstType',`itemTotal`='$subTotal',`GST`='$gst',`InvoiceTotal`='$Total' WHERE oid=$oid";
 $resultOrder=mysqli_query($con,$queryUpdateOrder);

  if($resultOrder){
 header("location:invoice.php?Cid=$cid&Oid=$oid");
 }
 */
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Billing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style>
fieldset {
  background-color: #eeeeee;
  margin: 5px;
}

legend {
  background-color: gray;
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
      
      <fieldset>
        <legend>Customer Detail</legend>
          <div class="row r">
            <div class="col-lg-6">
              <label for="name">Customer Name:</label>
              <label> <?php echo $dataCustomer['cName']?></label>
            </div>
            <div class="col-lg-6">
              <label for="name">Mobile Number:</label>
              <label> <?php echo $dataCustomer['mobile']?></label>
            </div>
            <div class="col-lg-12">
              <label for="name">Address:</label>
              <label> <?php echo $dataCustomer['cAdd']?></label>
            </div>
          </div>  
      </fieldset>

       <fieldset >
        <legend>Products</legend>
        <form method="post" action="">
          <div class="row r">
            <div class="col-lg-12">
                <label for="exampleFormControlSelect2">Select Item</label>
                  <select  required name="pid" class="form-control" id="exampleFormControlSelect2">
                    <?php

                     while($data=mysqli_fetch_assoc($resultProduct)){

                   echo "<option value=".$data['pid'].">".$data['name']."</option>"; 
                   }  ?>
                  </select>
            </div>
            <div class="col-lg-6">
               <label for="quantity">Quantity:</label>
              <input type="text" required class="form-control" name="qty" id="qt">
             
            </div>
                <div class="col-lg-3">
                  <input type="submit"  class=" btn btn-primary" value="Add" name="Add"></input>
                </div>
          </form>
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
                              <?php echo $ipid =$data['pid']; ?>
                            </td>
                             <td >
                              <?php echo $data['name']; ?>
                            </td>
                             <td >
                              <?php echo $data['price']; ?>
                            </td>
                             <td >
                              <?php echo $data['Qty']; ?>
                            </td>
                             <td >
                              <?php echo $data['Qty']* $data['price']; ?>
                            </td>
                             <td >
                              <form accept="" method="post">
                                <input type="hidden" name="pid" value=" <?php echo $ipid ?>">
                                <input type="hidden" name="oid" value="<?php echo $oid ?>">
                                <input type="hidden" name="nid" value="<?php echo $data['nid'] ?>">
                                <input type="submit" name="removeProduct" value="Remove" class="btn btn-danger">
                              </form>
                              
                            </td>
                            
                          </tr>
                        <?php } ?>
                          
                          
                        </tbody>
                      </table>

              </div>

          </div>  
      </fieldset>

      <fieldset>
        <legend>Tax Information</legend>
        <form action="" method="post">
          <div class="container">

        <dir class="row">
          <div class="col-lg-6">
           <label> Gst Type</label>
           <select name="gstType" class="form-control"> 
            <option value="1">
             GST 
            </option >
            <option value="2">
            iGST 
            </option>

           </select>
          </div>
           <div class="col-lg-4">
           <label> Gst %</label>
           <select name="perGST" class="form-control"> 
            <option value="4">
              4%
            </option>
            <option value="18">
              18% 
            </option>
            <option value="24">
              24%
            </option>
         
           </select>
          </div>
          <div class="col-lg-2">
            <input type="submit" value="Calculate" name="calculation" class=" btn btn-primary">
          </div>
        </dir>
      </div>
     
      <div class="container" >
         <div class="row">
          <div class="col-lg-3">
            <label>Sub Total: <?php if(isset($gst)){ echo $subTotal;}?></label>
          </div>
          <div class="col-lg-3">
            <label> GST: <?php if(isset($gst)){echo $gst;}?></label>
          </div>
          <div class="col-lg-3">
            <label>Total:<?php if(isset($gst)){echo $Total;}?></label>
          </div>
           <div class="col-lg-3">
            
            <input type="submit" name="generate" class="btn-primary btn" value="Generate">
            </form>
          </div>
          </div>
      </div>

      </fieldset>
    </div>





</body>
</html>


<?php if(isset($_POST['removeProduct']))
{
  $oid=$_POST['oid'];
  $pid=$_POST['pid'];
  $nid= $_POST['nid'];

$queryRemove="DELETE FROM `invoice_item` WHERE  `order_id`='$oid' and `nid`='$nid' and `pid`='$pid'";
$resultRemove=mysqli_query($con,$queryRemove);
  if($resultRemove){
    echo "<meta http-equiv='refresh' content='0'>";
  }
}



?>