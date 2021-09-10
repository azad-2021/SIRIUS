
<?php 
	
	include'connection.php';

  $OID = $_GET['oid'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $approvalID = $_GET['apid'];
  $Date =  date("d/m/y");

    $queryName="SELECT * FROM employees where EmployeeCode=$EmployeeUID";
    $resultName=mysqli_query($con2,$queryName);
    $dataName=mysqli_fetch_assoc($resultName);
    $name = $dataName['Employee Name']; 

$queryBank="SELECT * FROM branchs where BranchCode=$BranchCode";
$resultBank=mysqli_query($con2,$queryBank);
$dataBank=mysqli_fetch_assoc($resultBank);
$BranchName = $dataBank['BranchName'];
$District = $dataBank['Address3'];
$Zone = $dataBank['ZoneRegionCode'];
//echo $Zone;

$queryzone="SELECT * FROM zoneregions where ZoneRegionCode=$Zone";
$resultzone=mysqli_query($con2,$queryzone);
$datazone=mysqli_fetch_assoc($resultzone);
$BankCode = $datazone['BankCode'];

$queryBankName="SELECT * FROM Bank where BankCode=$BankCode";
$resultBankName=mysqli_query($con2,$queryBankName);
$dataBankName=mysqli_fetch_assoc($resultBankName);
$BankName = $dataBankName['BankName'];

//echo $District;
?>
<html>

	<head>
	<title>Invoice</title>
	  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap core CSS -->
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<style type="text/css">
		body {
			padding: 50px;		
			font-family: Verdana;
			font-size: 16px;
		}
		
		div.invoice {
		/*border:1px solid Black;*/
		padding:5px;
		height:900pt;
		width:700pt;
		}

		div.company-address {
			/*border:1px solid #ccc;*/
			float:left;
			width:800pt;
			padding:10px;
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
			text-align: center;
		}
		
		td {
			text-align: center;
			margin: 5px;
		}
		
		.text-left {
			text-align:center;
		}
		
		.text-center {
			text-align:center;
		}
		
		.text-right {
			text-align:right;
		}
		
		</style>
		  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>


	</head>

	<body  onload="window.print()">
		<div class="container" align="center">
			<h1><img src="/html/cyrus logo.png" alt="Cyrus Electronics Pvt. Ltd." style="width:50px;height:60px;">
			Cyrus Electronics Pvt. Ltd.</h1>
		</div>
		<br>
		<div class="container">
			<div class="invoice">

				<div class="company-address">
					<strong>The Branch Manager</strong>
					<p><strong>Date: </strong><?php echo $Date; ?></p>
					<p><strong>Branch: </strong> <?php echo $BranchName; ?></p>
					<p><strong>Bank: </strong> <?php echo $BankName; ?></p>
					<p><strong>District: </strong><?php echo $District; ?></p>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br>
			<div>
			<h4 align="center">Sub: Estimate for items in Security / Survelliance System</h4>
			<br>
			<p>Dear Sir,
				<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				After checking the security / survelliance system, it was found that the undermentioned items are &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;required for smooth functioningof the equipment. So, we are hereby presenting you the estimate for &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;the same. 
			</p>
		
		<br>
		
		<div class="clear-fix"></div>
			<table border='1' cellspacing='0'>
				<tr>
					<th width=20>S.No.</th>
					<th width=250>Description</th>
					<th width=80>Unit Price</th>
					<th width=100>Quantity</th>
					<th width=100>Total price</th>
				</tr>

			<?php
			
			$queryProductList= "SELECT * FROM estimates WHERE ApprovalID=$approvalID";
 			$resultProductList=mysqli_query($con3,$queryProductList);
 			$count = 1;
 			$Sub = 0;
			while($data=mysqli_fetch_assoc($resultProductList)){
				$RateID = $data['RateID'];
				$query= "SELECT * FROM rates WHERE RateID=$RateID";
				$result=mysqli_query($con3,$query);
				$dataMaterial=mysqli_fetch_assoc($result);
				$Discription = $dataMaterial['Discription'];
				$Rate = $dataMaterial['Rate'];

			 ?>

                          <tr>
                              <td >
                              <?php echo $count; ?>
                            </td>                         
                             <td >
                              <?php echo $Discription; ?>
                            </td>
                             <td >
                               ₹<?php echo $Rate; ?>
                            </td>
                             <td >
                              <?php echo $data['Qty']; ?>
                            </td>
                             <td >
                              ₹<?php echo $SubTotal =  $data['Qty']* $Rate; ?>
                            </td>
                            
                            
                          </tr>
                        <?php
                        $count++;
                        $Sub = $Sub + $SubTotal;
                         } ?>
          
			</table>
			<br>
			<label><strong>SubTotal : ₹<?php echo $Sub;?></strong></label><br>
			<strong>Note:</strong>
			<p>
				<ol>
					<li>
						Wiring (if mentioned) is an approximation and it will be charged on actual consumption basis.
					</li>
					<li>100% payment at the time of installation.</li>
					<li>GST shall be charged as per prevailing rates. (if applicable)</li>
				</ol>
				Hope you find the estimates satisfactory as per your requirement. We request you to kindly approve the estimates as soon as possible so that security / surviallance system can be made functional at the branch at earliest.
				<br><br>
				With Warm Regards<p align="right">Name of Field Staff: <?php echo $name; ?></p>
				For Cyrus ELectronics Pvt. Ltd.
			</p>
		</div>
		<center>
			<p style="font-size: 10px;"><strong>Cyrus house, B 44/69 Sector Q, Aliganj, Lucknow-24 Ph. (0522)274916, 2374190</strong></p>
		</center>
		</div>
		</div>
   <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	</body>

</html>
 