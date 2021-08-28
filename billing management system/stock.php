<?php
	include 'session.php';

	include 'connection.php';
	$number="";
 	$queryProduct="SELECT * FROM products";
 	$resultProduct=mysqli_query($con,$queryProduct);


if (isset($_POST['edit'])) {
	$pid=$_POST['pid'];
	 	$queryProductData="SELECT * FROM products where pid=$pid" ;
	$resultProductData=mysqli_query($con,$queryProductData);
	$dataProductData=mysqli_fetch_assoc($resultProductData);
	
	}
if (isset($_POST['update'])) {
	$pid=$_POST['pid'];
	$name=$_POST['name'];
	$qty=$_POST['qty'];
	$price=$_POST['price'];
	$queryUpdate="UPDATE `products` SET `name`='$name',`price`='$price',`qty`='$qty' WHERE `pid`=$pid" ;
	$resultUpdate=mysqli_query($con,$queryUpdate);
	if ($resultUpdate) {
		 echo "<meta http-equiv='refresh' content='0'>";
	}
	
	}
	if (isset($_POST['add'])) {
		$name=$_POST['name'];
	$qty=$_POST['qty'];
	$price=$_POST['price'];
	$queryAdd="INSERT INTO `products`( `name`, `price`, `qty`) VALUES ('$name','$price','$qty')" ;
	$resultAdd=mysqli_query($con,$queryAdd);
	if ($resultAdd) {
		 echo "<meta http-equiv='refresh' content='0'>";
	}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Billing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href=" https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 
</head>
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

<body>
  <?php include'navbar.php';?>


<div class="container">
	<form action="" method="POST">
	<div class="row">

		<fieldset>
	<legend>Product Details</legend>
		<div class="col-lg-2">
			<label>Product Name:</label>
		</div>
		<div class="col-lg-10">
		<input type="hidden"  value="<?php if (isset($dataProductData)){echo $dataProductData['pid'];} {
			
		} ?>"class="form-control" name="pid">

			<input type="input" value="<?php if (isset($dataProductData)){echo $dataProductData['name'];} {
			
		} ?>" required class="form-control" name="name">

		</div>
		
		<div class="col-lg-2">
			<label>Qty:</label>
		</div>
		<div class="col-lg-2">
			<input type="input"  value="<?php if (isset($dataProductData)){echo $dataProductData['qty'];} {
			
		} ?>" required class="form-control" name="qty">
		</div>
		<div class="col-lg-2">
			<label>Unit Price:</label>
		</div>
		<div class="col-lg-2">
			<input type="input"  value="<?php if (isset($dataProductData)){echo $dataProductData['price'];} {
			
		} ?>" required class="form-control" name="price">
		</div>
		<div class="col-lg-4">
			<input type="submit" class="btn btn-success" 
			<?php if (isset($dataProductData)){
				echo "value='Update' name='update'";
			} 
			else
			{
			echo "value='Add' name='add'";	
			}
			?> >
		</div>
		</fieldset>
	</div>	
	</form>
</div>
<div class="container">
	<div class="row">  
		<fieldset>
			<legend>Stock Details</legend>
				<div class="col-lg-12">
					<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Product </th>
                <th>QTY</th>
                <th>Unit Price</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
        	<?php while($data=mysqli_fetch_assoc($resultProduct)){?>
            <tr>
                <td><?php echo $data['name']?></td>
                <td><?php echo $data['qty']?></td>
                <td>₹<?php echo $data['price']?></td>
                <td>
                <form action="" method="post">
                <input type="hidden" value="<?php echo $data['pid']?>" name="pid">	
                <input type="submit" class="btn btn-warning" name="edit" value="Edit">
                </form>
            	</td>
            </tr>
      		<?php }?>
        </tbody>
        
    </table>				</div>
			</fieldset>
	</div>
</div>



</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable();
} );
</script> 
