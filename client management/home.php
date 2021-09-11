
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo $name; ?></title>
        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="style.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <style type="text/css">
        .border {
        border:5px solid Black;
        padding:5px;
        }
        table, th, td {
  border:1px solid black;
}
        </style>
    </head>
    <body>
        

        <div class="container" style="resize: both;">
            <table class="table-hover table-sm border" id="example" class="display nowrap">
                <h4 class="font-weight-bold text-center text-xl-center">Total pending work report for <?php  print "$name"; ?> </h4>
                <thead> 
                    <tr> 
                        <th>Bank</th> 
                        <th>Zone</th> 
                        <th>Branch</th> 
                        <th>District</th> 
                        <th>AMC</th>
                        <th>Order</th>
                        <th>Complaint</th>
                    </tr>                     
                </thead>                 
                <tbody> 
                    <?php
                    $con = new mysqli("localhost","root","","backend");
                    $sql ="SELECT * FROM `pendingwork` where EmployeeCode=".$UID ." AND (`pending Order` is not null OR `Pending Complaints` is not null OR `pending AMC` is not null) ORDER by Address3";
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }  
                    $results = $con->query($sql); 
                    while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){
    				print "<tr>";
        			print "<td>".$row["BankName"]."</td>";
           			print "<td>".$row["ZoneRegionName"]."</td>";
           			print "<td>".$row["BranchName"]."</td>";
           			print "<td>".$row["Address3"]."</td>";
           			print "<td>".$row["pending AMC"]."</td>";
                    print "<td>".$row["pending Order"]."</td>";
                    print "<td>".$row["Pending Complaints"]."</td>";  
                    print "</tr>";

 
    				}
        			?>
                </tbody>                 
            </table>
            <br>
            <table class="table-striped table-hover table-sm" id="userTable2" class="display nowrap">
                <h4 class="font-weight-bold text-center text-xl-center">Total pending AMC </h4>
                <thead> 
                    <tr> 
                        <th>Bank</th> 
                        <th>Zone</th> 
                        <th>Branch</th> 
                        <th>District</th> 
                        <th>AMCID</th>
                        <th>Discription</th>
                    <th>Posted On</th>
                        <th>Assigned On</th>
                    </tr>                     
                </thead>                 
                <tbody> 
                    <?php
                	date_default_timezone_set('Asia/Kolkata');
                	$timestamp =date('y-m-d H:i:s');
                	$newtimestamp = date('Y-m-d H:i:s',(strtotime('-30 day',strtotime($timestamp))));
                    $con = new mysqli("localhost","root","","backend");
                    $sql ="SELECT * FROM `vpendingamc` where `EmployeeCode`=".$UID." and Attended=0 and `AssignDate` is not null Order by Address3";
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }  
                    $results = $con->query($sql); 
                    while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){
                    print "<tr>";
        			print "<td >".$row["BankName"]."</td>";
           			print "<td>".$row["ZoneRegionName"]."</td>";
           			print "<td>".$row["BranchName"]."</td>";
           			print "<td>".$row["Address3"]."</td>";
           			//print "<td>".$row["OrderID"]."</td>";
                    print "<td><a href=\"ms/card.php?oid=" . $row['OrderID'] . "&cid=&eid=".$UID ."&brcode=".$row["BranchCode"]."\">".$row["OrderID"]."</a></td>";
           			print "<td>".$row["Discription"]."</td>";
           			print "<td>".$row["DateOfInformation"]."</td>";
                    print "<td>".$row["AssignDate"]."</td>";
                    print "</tr>";
                    
    				}
        			?>
                </tbody>                 
            </table>
            <br>
            <table class="table-striped table-hover table-sm" id="userTable3" class="display nowrap">
                <h4 class="font-weight-bold text-center text-xl-center">Total pending Orders </h4>
                <thead> 
                    <tr> 
                        <th>Bank</th> 
                        <th>Zone</th> 
                        <th>Branch</th> 
                        <th>District</th> 
                        <th>OrderID</th>
                        <th>Discription</th>
                        <th>Posted On</th>
                        <th>Assigned On</th>
                    </tr>                     
                </thead>                 
                <tbody> 
                    <?php
                    $con = new mysqli("localhost","root","","backend");
                    $sql ="SELECT * FROM `vpendingorders` where `EmployeeCode`=".$UID." and Attended=0 and `AssignDate` is not null Order by Address3";
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }  
                    $results = $con->query($sql); 
                    while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){
    				print "<tr>";
        			print "<td>".$row["BankName"]."</td>";
           			print "<td>".$row["ZoneRegionName"]."</td>";
           			print "<td>".$row["BranchName"]."</td>";
           			print "<td>".$row["Address3"]."</td>";
           			//print "<td>".$row["OrderID"]."</td>";
                    print "<td><a href=\"ms/card.php?oid=" . $row['OrderID'] . "&cid=&eid=".$UID ."&brcode=".$row["BranchCode"]."\">".$row["OrderID"]."</a></td>";
           			print "<td>".$row["Discription"]."</td>";
           			print "<td>".$row["DateOfInformation"]."</td>";
                    print "<td>".$row["AssignDate"]."</td>";
                    print "</tr>";
        
    				}
        			?>
                </tbody>                 
            </table>
            <br>
            <table class="table-striped table-hover table-sm" id="userTable4" class="display nowrap">
                <h4 class="font-weight-bold text-center text-xl-center">Total pending Complaints </h4>
                <thead> 
                    <tr> 
                        <th>Bank</th> 
                        <th>Zone</th> 
                        <th>Branch</th> 
                        <th>District</th> 
                        <th>ComplaintID</th>
                        <th>Discription</th>
                        <th>Posted On</th>
                        <th>Assigned On</th>
                    </tr>                     
                </thead>                 
                <tbody> 
                    <?php
                    $con = new mysqli("localhost","root","","backend");
                    $sql ="SELECT * FROM `vpendingcomplaints` where `EmployeeCode`=".$UID." and Attended=0 and `AssignDate` is not null Order by Address3";
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }  
                    $results = $con->query($sql); 
                    while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){
    				print "<tr>";
        			print "<td>".$row["BankName"]."</td>";
           			print "<td>".$row["ZoneRegionName"]."</td>";
           			print "<td>".$row["BranchName"]."</td>";
           			print "<td>".$row["Address3"]."</td>";
           			//print "<td>".$row["ComplaintID"]."</td>";
                    print "<td><a href=\"ms/card.php?cid=" . $row['ComplaintID'] . "&oid=&eid=".$UID ."&brcode=".$row["BranchCode"]."\">".$row["ComplaintID"]."</a></td>";
           			print "<td>".$row["Discription"]."</td>";
           			print "<td>".$row["DateOfInformation"]."</td>";
                    print "<td>".$row["AssignDate"]."</td>";
        			print "</tr>";
    				}
        			?>
                </tbody>                 
            </table>
        </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js
"></script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true
            } );
        } );

        $(document).ready(function() {
             var table = $('#userTable2').DataTable( {
                rowReorder: {
                selector: 'td:nth-child(2)'
                },
                responsive: true
            } );
        } );
          
        $(document).ready(function() {
        var table = $('#userTable3').DataTable( {
            rowReorder: {
                selector: 'td:nth-child(2)'
                },
                responsive: true
            } );
        } );
         
        $(document).ready(function() {
        var table = $('#userTable4').DataTable( {
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: true
            } );
        } );
    </script>
</body>
</html>
