
<?php
 	include 'connection.php';
 	$id = $_GET['Cid'];
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


<div class="container">
	<fieldset>
	<form action="" method="post"> 

		<div class="row">
				
				 <legend>Find Customer</legend>
					<div class="col-lg-2">
						 <label for="mobilen">Customer Mobile No:</label>
					</div>
					<div class="col-lg-8"> 
						 <input type="text" class="form-control" value="<?php echo (isset($rows))?$db['mobile']:$number; ?>" id="mobilen" name="mobile">					 
					</div>
	 
	 				
	 			</div>
	 				<div class="row">
		 				<div class="col-lg-2">
							 <label for="Name">Customer Name:</label>
						</div>
						<div class="col-lg-8"> 
							 <input type="text" class="form-control" id="Name" name="Name">					 
						</div>
		 
		 				
					</div>
					<div class="row">
		 				<div class="col-lg-2">
							 <label for="Address">Customer Address:</label>
						</div>
						<div class="col-lg-8"> 
							 <input type="text" class="form-control"  id="Address" name="Address">					 
						</div>
		 
		 				<div class="col-lg-2">
		 					
		  					<input type="submit" class="btn btn-success" name="submit">

		  				</div>
					</div>



		
		</div>	
			</div>
			</fieldset>
	</form>
</div>
</body>
</html>
