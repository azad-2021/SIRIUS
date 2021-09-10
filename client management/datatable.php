 <?php  
 $connect = mysqli_connect("192.168.1.1:9916","Ashok","cyrus@123","cyrusbackend");  
 $query ="SELECT * FROM `pendingwork` where EmployeeCode=".$UID ." AND (`pending Order` is not null OR `Pending Complaints` is not null OR `pending AMC` is not null) ORDER by Address3";
 $result = mysqli_query($connect, $query);  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Datatables Jquery Plugin with Php MySql and Bootstrap</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      </head>  
      <body>  
           <br /><br />  
           <div class="container">  
                <h3 align="center">Datatables Jquery Plugin with Php MySql and Bootstrap</h3>  
                <br />  
                <div class="table-responsive">  
                     <table id="employee_data" class="table table-striped table-bordered">  
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
                          while ($row=mysqli_fetch_array($results,MYSQLI_ASSOC)){ 
                          {  
                               echo '  
                               <tr>  
                                    <td>'.$row["BankName"].'</td>  
                                    <td>'.$row["ZoneRegionName"].'</td>  
                                    <td>'.$row["BranchName"].'</td>  
                                    <td>'.$row["Address3"].'</td>  
                                    <td>'.$row["pending AMC"].'</td>
                                    <td>'.$row["pending Order"].'</td> 
                                    <td>'.$row["Pending Complaints"].'</td>   
                               </tr>  
                               ';  
                          }}  
                          ?>  
                     </table>  
                </div>  
           </div>  
     
 <script>  
 $(document).ready(function(){  
      $('#employee_data').DataTable();  
 });  
 </script>  
  </body>  
 </html>  