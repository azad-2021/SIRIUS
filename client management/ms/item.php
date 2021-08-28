<?php 

include 'connection.php';

  $oid=36;
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
        <br>
        <input type = "submit"/> 
      </form>
    </fieldset>
    
    <!-- Material consumed section -->

    <script type="text/javascript"> 
      function addNode() 
      {var newP = document.createElement("p"); 
      var textNode = document.createTextNode(" This is a new text node"); 
      newP.appendChild(textNode);
      document.getElementById("firstP").appendChild(newP); } 
    </script>

    <label for="myCheck">Material consumed: </label> 
    <input type="checkbox" id="myCheck" onclick="myFunction()">
    <div id="text" style="display:none">
      <fieldset >
        <legend>Items</legend>
          <form method="post" action="">
            <div class="row r">
              <div class="col-lg-12">
               <label for="exampleFormControlSelect2">Select Item</label>
                <select  required name="pid" class="form-control" id="exampleFormControlSelect2">
                  <?php

                     while($data=mysqli_fetch_assoc($resultProduct)){

                        echo "<option value=".$data['pid'].">".$data['name']."</option>"; 
                      }  
                  ?>
                </select>
              </div>
              <div class="col-lg-6">
               <label for="quantity">Quantity:</label>
               <input type="text" required class="form-control" name="qty" id="qt">
              </div>
              <div class="col-lg-3">
               <input type="submit"  class=" btn btn-success" value="Add" name="Add"></input>
              </div>
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
          <div class="col-lg-12">
            <h4>
              <select class="form-select" aria-label="Default select example">
                <option selected>As</option>
                <option value="1">Billing</option>
                <option value="2">Waranty</option>
                <option value="3">CAMC</option>
                <option value="3">Standby</option>
              </select>
            </h4>
          </div>
          <br><br>  
      </fieldset>
    </div>

    <!-- END material consumed -->


    <script type="text/javascript"> 
      function addNode() 
      {var newP = document.createElement("p"); 
      var textNode = document.createTextNode(" This is a new text node"); 
      newP.appendChild(textNode);
      document.getElementById("firstP").appendChild(newP); } 
    </script>

    <label for="myCheck">Add Technician: </label> 
    <input type="checkbox" id="addtech" onclick="techFunction()">
    <div id="text1" style="display:none">
      <fieldset >
        <legend>Items</legend>
          <form method="post" action="">
            <div class="row r">
              <div class="col-lg-12">
               <label for="exampleFormControlSelect2">Select Item</label>
                <select  required name="pid" class="form-control" id="exampleFormControlSelect2">
                  <?php

                     while($data=mysqli_fetch_assoc($resultProduct)){

                        echo "<option value=".$data['pid'].">".$data['name']."</option>"; 
                      }  
                  ?>
                </select>
              </div>
              <div class="col-lg-6">
               <label for="quantity">Quantity:</label>
               <input type="text" required class="form-control" name="qty" id="qt">
              </div>
              <div class="col-lg-3">
               <input type="submit"  class=" btn btn-success" value="Add" name="Add"></input>
              </div>
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
          <div class="col-lg-12">
            <h4>
              <select class="form-select" aria-label="Default select example">
                <option selected>As</option>
                <option value="1">Billing</option>
                <option value="2">Waranty</option>
                <option value="3">CAMC</option>
                <option value="3">Standby</option>
              </select>
            </h4>
          </div>
          <br><br>  
      </fieldset>
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
      <label for="myCheck">More card: </label> 
      <input type="checkbox" id="myCheck" onclick="myFun()">
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