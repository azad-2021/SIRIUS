<?php 

  include 'connection.php';

  $oid=36;
  $queryProduct="SELECT * FROM products"; 
  $resultProduct=mysqli_query($con,$queryProduct);  //select all products
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

      $queryAdd="INSERT INTO `invoice_item`( `order_id`, `pid`, `qty`) VALUES ('$oid','$pid','$qty')";
      mysqli_query($con,$queryAdd);
      if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
      }  
    }
  /*
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
*/

  /* file upload*/
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>MS</title>
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
    <legend style="text-align: center;">Enter Details</legend>
    <fieldset style="margin: 20px;">

      <!-- Job card section -->
      <form action="" method="post"> 
        <br>
        <div class="row">
          <div class="col-lg-2">
            <label for="Name"><h5>Job card no:</h5></label>
          </div>
          <div class="col-lg-8"> 
            <input type="text" class="form-control" id="Name" name="Name">          
          </div>
        </div>
      </form>
      <!-- END of Job card section -->

      <!-- Job card file upload section -->
      <form action = "" method = "POST" enctype = "multipart/form-data">
        <br>
        <legend>Upload Job Card File</legend>
        <input type = "file" name = "image" />
        <input value="Upload" type = "submit"/> 
      </form>
      <!-- END of Job card file upload section -->
      <br>

      <!-- Site Status Section -->
      <div>
        <h5>Site:&nbsp;&nbsp;&nbsp;
          <input type="radio" name="status"
          <?php if (isset($site) && $site=="TRUE") echo "checked";?>
          value="status">&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="status"
          <?php if (isset($site) && $site=="FALSE") echo "checked";?>
          value="status">&nbsp;&nbsp;&nbsp;NOT OK
        </h5>
      </div>
      <!-- End of Site status section -->
    </fieldset>



    <!-- Add technician Section -->

    <script type="text/javascript"> 
      function addNode() 
      {var newP = document.createElement("p"); 
      var textNode = document.createTextNode(" This is a new text node"); 
      newP.appendChild(textNode);
      document.getElementById("firstP").appendChild(newP); } 
    </script>

    <div class="form-check">
      <label for="myCheck"> <h5>Add Technician:</h5></label> 
      <input type="checkbox" id="addtech" onclick="techFunction()">
    </div>
    <div id="text1" style="display:none">
      <fieldset >
        <legend>Add Technician</legend>
        <div class="col-lg-12">
          <form>
            <select>
              <option selected>Select Technician</option>
              <?php
                $records = mysqli_query($con2, "SELECT * From technician");  // Use select query here 

                while($data = mysqli_fetch_array($records)){
                  echo "<option value='". $data['tName'] ."'>" .$data['tName'] ."</option>";  // displaying data in option menu
                }
              ?> 
            </select>
          </form>
        </div>
        <br><br>  
      </fieldset>
    </div>
   <!-- END of Technician section -->
    
    <!-- Material consumed section -->

    <script type="text/javascript"> 
      function addNode() 
      {var newP = document.createElement("p"); 
      var textNode = document.createTextNode(" This is a new text node"); 
      newP.appendChild(textNode);
      document.getElementById("firstP").appendChild(newP); } 
    </script>

    <!-- Material Consumed Section -->
    <div class="form-check">
      <label for="myCheck"><h5>Material consumed:</h5> </label> 
      <input type="checkbox" id="myCheck" onclick="myFunction()">
      <div id="text" style="display:none">
        <fieldset >
          <legend>Items</legend>
          <div class="col-lg-12">
            <form method="post" action="" class="form-inline">
                <label for="exampleFormControlSelect2">Select Item</label>
                <select  required name="pid" class="form-control" id="exampleFormControlSelect2" >
                  <?php

                     while($data=mysqli_fetch_assoc($resultProduct)){

                        echo "<option value=".$data['pid'].">".$data['name']."</option>"; 
                      }  
                  ?>
                </select>
                <label for="quantity">&nbsp;&nbsp;&nbsp;Quantity: &nbsp;&nbsp;</label>
                <input type="text" required class="form-control" name="qty" id="qt">
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <h5>
                  <select class="form-select" aria-label="Default select example" style="text-align: center;">
                    <option selected>As</option>
                    <option value="1">Billing</option>
                    <option value="2">Waranty</option>
                    <option value="3">CAMC</option>
                    <option value="3">Standby</option>
                  </select>
                </h5>
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
          <br><br>  
        </fieldset>
      </div>
    </div>
    <!-- END material consumed -->

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


      function techFunction() {
        var checkBox = document.getElementById("addtech");
        var text = document.getElementById("text1");
        if (checkBox.checked == true){
          text.style.display = "block";
        } else {
          text.style.display = "none";
        }
      }
    </script>

    <div class="container">
      <label for="myCheck"><h5> Estimate given: </h5></label> 
      <input type="checkbox" id="myCheck" onclick="myFun()">

      <label for="myCheck"><h5>More card: </h5></label> 
      <input type="checkbox" id="myCheck" onChange="this.form.submit()">
    </div>



    <div align="center">
      <input type="submit" name="generate" class="btn-primary btn" value="Submit">
    </div>

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