
<?php include'connection.php';
$oid=$_GET['Oid'];
$cid=$_GET['Cid'];
$queryCustomerDetails="SELECT * FROM customer where cid=$cid";
$resultCustomerDetails=mysqli_query($con,$queryCustomerDetails);
$dataCustomer=mysqli_fetch_assoc($resultCustomerDetails);
$QueryOrder="SELECT * FROM order_invoice Where oid=$oid";
$resultOrder=mysqli_query($con,$QueryOrder);
$dataOrder=mysqli_fetch_assoc($resultOrder);
?>
<html>

	<head>
	<title>Simple invoice in PHP</title>
		<style type="text/css">
		body {		
			font-family: Verdana;
		}
		
		div.invoice {
		border:1px solid #ccc;
		padding:10px;
		height:740pt;
		width:570pt;
		}

		div.company-address {
			border:1px solid #ccc;
			float:left;
			width:200pt;
		}
		
		div.invoice-details {
			border:1px solid #ccc;
			float:right;
			width:200pt;
		}
		
		div.customer-address {
			border:1px solid #ccc;
			float:right;
			margin-bottom:50px;
			margin-top:100px;
			width:200pt;
		}
		
		div.clear-fix {
			clear:both;
			float:none;
		}
		
		table {
			width:100%;
		}
		
		th {
			text-align: left;
		}
		
		td {
		}
		
		.text-left {
			text-align:left;
		}
		
		.text-center {
			text-align:center;
		}
		
		.text-right {
			text-align:right;
		}
		
		</style>
	</head>

	<body>
	<div class="invoice">
		<div class="company-address">
			ACME ltd
			<br />
			489 Road Street
			<br />
			London, AF3Z 7BP
			<br />
		</div>
	
		<div class="invoice-details">
			Invoice NO: <?php echo $oid;?>
			<br />
			Date: <?php echo $dataOrder['orderDate'];?>
		</div>
		
		<div class="customer-address">
			To:
			<br />
			&emsp;&emsp;<?php echo $dataCustomer['cName'];?>
			<br />
			<?php echo $dataCustomer['cAdd'];?>
			<br />
			<?php echo $dataCustomer['mobile'];?>
			<br />
		</div>
		
		<div class="clear-fix"></div>
			<table border='1' cellspacing='0'>
				<tr>
					<th width=250>Description</th>
					<th width=80>Amount</th>
					<th width=100>Unit price</th>
					<th width=100>Total price</th>
				</tr>

			<?php
			$queryProductList= "SELECT * FROM products inner join invoice_item on products.pid=invoice_item.pid where invoice_item.order_id=$oid";
  $resultProductList=mysqli_query($con,$queryProductList);
while($data=mysqli_fetch_assoc($resultProductList)){ ?>
                          <tr>
                           
                             <td >
                              <?php echo $data['name']; ?>
                            </td>
                             <td >
                               ₹<?php echo $data['price']; ?>
                            </td>
                             <td >
                              <?php echo $data['Qty']; ?>
                            </td>
                             <td >
                              ₹<?php echo $data['Qty']* $data['price']; ?>
                            </td>
                            
                            
                          </tr>
                        <?php } ?>
          
			</table>
			<div class="customer-address">
			<label>SubTotal : ₹<?php echo $dataOrder['itemTotal'];?></label><br>
			<?php if($dataOrder['gstType']==1){
			echo "<label>SGST: ₹".($dataOrder['GST']/2)."</label><br><label>CGST: ₹".($dataOrder['GST']/2)."</label><br>";
			}
			elseif($dataOrder['gstType']==2){
			echo "<label>iGST :₹".$dataOrder['GST']."</label><br>";
			}
			?>

			
			<label>Total: ₹<?php echo $dataOrder['InvoiceTotal'];?></label>
			</div>
		
		</div>
	</body>

</html>
 