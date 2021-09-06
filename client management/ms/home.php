<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Blank Template for Bootstrap</title>
        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        

        <div class="container" style="resize: both;">
            <table class="table-bordered table-striped table-hover table-sm">
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
                    //echo '<a href="http://www.website.com/page.html">Click here</a>';
                    $con = new mysqli("192.168.1.1:9916","Ashok","cyrus@123","cyrusbackend");
                    $sql ="SELECT * FROM `pendingwork` where EmployeeCode=".$UID ." AND (`pending Order` is not null OR `Pending Complaints` is not null OR `pending AMC` is not null) ORDER by Address3";
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }  
                    $results = $con->query($sql); 
                    while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){
                    //print $row["BankCode"].
    				print "<tr>";
        			print "<td>".$row["BankName"]."</td>";
           			print "<td>".$row["ZoneRegionName"]."</td>";
           			print "<td>".$row["BranchName"]."</td>";
           			print "<td>".$row["Address3"]."</td>";
           			print "<td>".$row["pending AMC"]."</td>";

                    print "<td><a href=\"ms/card.php?poid=" . $row['pending Order'] . "&eid=".$UID ."&brcode=".$row["BankCode"]. "\">".$row["pending Order"]."</a></td>";
           			
                    print "<td><a href=\"ms/card.php?cpid=" . $row['Pending Complaints'] . "&eid=".$UID ."&brcode=".$row["BankCode"]."\">".$row["Pending Complaints"]."</a></td>";

                    //print "<td>".$row["pending Order"]."</td>";
                    //print "<td>".$row["Pending Complaints"]."</td>";  

                    print "</tr>";

 
    				}
        			?>
                </tbody>                 
            </table>
            <table class="table table-bordered table-striped table-hover table-sm">
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
                    $con = new mysqli("192.168.1.1:9916","Ashok","cyrus@123","cyrusbackend");
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
           			print "<td>".$row["OrderID"]."</td>";
           			print "<td>".$row["Discription"]."</td>";
           			print "<td>".$row["DateOfInformation"]."</td>";
                    print "<td>".$row["AssignDate"]."</td>";
                    print "</tr>";
                    
    				}
        			?>
                </tbody>                 
            </table>
            <table class="table table-bordered table-striped table-hover table-sm">
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
                    $con = new mysqli("192.168.1.1:9916","Ashok","cyrus@123","cyrusbackend");
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

                    print "<td><a href=\"ms/item.php?oid=" . $row['OrderID'] . "&eid=".$UID ."&brcode=".$row["BankCode"]."\">".$row["OrderID"]."</a></td>";

           			print "<td>".$row["Discription"]."</td>";
           			print "<td>".$row["DateOfInformation"]."</td>";
                    print "<td>".$row["AssignDate"]."</td>";

                   // print "<td><a href=\"ms/item.php?cpid=" . $row['Pending Complaints'] . "&eid=".$UID ."&brcode=".$row["BankCode"]."\">".$row["Pending Complaints"]."</a></td>";
                    print "</tr>";
        
    				}
        			?>
                </tbody>                 
            </table>
            <table class="table table-bordered table-striped table-hover table-sm">
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
                    $con = new mysqli("192.168.1.1:9916","Ashok","cyrus@123","cyrusbackend");
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
                    print "<td><a href=\"ms/item.php?cpid=" . $row['ComplaintID'] . "&eid=".$UID ."&brcode=".$row["BankCode"]."\">".$row["ComplaintID"]."</a></td>";
           			print "<td>".$row["Discription"]."</td>";
           			print "<td>".$row["DateOfInformation"]."</td>";
                    print "<td>".$row["AssignDate"]."</td>";
        			print "</tr>";

                    //print "<td><a href=\"ms/item.php?cpid=" . $row['Pending Complaints'] . "&eid=".$UID ."&brcode=".$row["BankCode"]."\">".$row["Pending Complaints"]."</a></td>";
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
    </body>
</html>
