<?php 

include 'connection.php';

  $oid=$_GET['Oid'];
  $queryProduct="SELECT * FROM products"; 
  $resultProduct=mysqli_query($con,$queryProduct);
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
}
?>






<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
fieldset {
  background-color: #eeeeee;
}

legend {
  background-color: gray;
  color: white;
  padding: 5px 10px;
}

input {
  margin: 5px;
}
</style>
  </head>

  <body>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->


  


        <?php
           if(isset($_FILES['image'])){
              $errors= array();
              $file_name = $_FILES['image']['name'];
              $file_size =$_FILES['image']['size'];
              $file_tmp =$_FILES['image']['tmp_name'];
              $file_type=$_FILES['image']['type'];
              $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
              
              $extensions= array("jpeg","jpg","pdf");
              
              if(in_array($file_ext,$extensions)=== false){
                 $errors[]="extension not allowed, please choose a JPEG or pdf file.";
              }
              
              if($file_size > 2097152){
                 $errors[]='File size must be excately 2 MB';
              }
              
              if(empty($errors)==true){
                 move_uploaded_file($file_tmp,"image/".$file_name);
                 echo "Success";
              }else{
                 print_r($errors);
              }
           }

            if(isset($_POST['material']) && 
               $_POST['material'] == 'Yes') 
            {
                echo "Data submitted successfully.";
            }


            /* items block */

        ?>

    <div class="container" style="margin-top: 30px;">
    <fieldset>
      <form action="" method="post"> 
        <div class="row">
          <div class="col-lg-2">
            <label for="Name">Job card no:</label>
          </div>
          <div class="col-lg-8"> 
            <input type="text" class="form-control" id="Name" name="Name">          
          </div>
        </div>
      </form>

      <form action = "" method = "POST" enctype = "multipart/form-data">
        <p>Attach job card</p>
         <input type = "file" name = "image" />
         <input type = "submit"/>

      </form> 
<!--
      <form action="" method="post">
          Material consumed?
          <input type="checkbox" name="material" value="Yes" />
          <input type="submit" name="formSubmit" value="Submit" />
      </form>
-->    
<script type="text/javascript"> 
  function addNode() 
     {var newP = document.createElement("p"); 
    var textNode = document.createTextNode(" This is a new text node"); 
    newP.appendChild(textNode);
      document.getElementById("firstP").appendChild(newP); } 
</script>


      <label for="myCheck">Material consumed: </label> 
        <input type="checkbox" id="myCheck" onclick="myFunction()">
         <div id="text" class="dropdown" style="display:none">
        <form>
  <fieldset>
   <!-- <legend>Drop the credentials</legend> -->
    <div class="mb-3">
      <select class="form-select" aria-label="Default select example">
        <option selected>Select Items</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
      <br>
      <button type="button" class="btn btn-primary">Add items</button>
    </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Add quantity</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
      <div class="mb-3">
      <select class="form-select" aria-label="Default select example">
        <option selected>As</option>
        <option value="1">Billing</option>
        <option value="2">Waranty</option>
        <option value="3">CAMC</option>
        <option value="3">Standby</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </fieldset>
</form>
        </div>

        <script>
        function myFunction() {
          var checkBox = document.getElementById("myCheck");
          var text = document.getElementById("text");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
             text.style.display = "none";
          }
        }
        </script>
    </fieldset>




  </body>
</html>
