<?php

$UID=8;
            $conn = new mysqli("localhost","root","","backend");
             
            if ($conn->connect_errno) {
                echo "Error: " . $conn->connect_error;
            }
            $sql ="SELECT * FROM `pendingwork` where EmployeeCode=".$UID ." AND (`pending Order` is not null OR `Pending Complaints` is not null OR `pending AMC` is not null) ORDER by Address3";
            $result = $conn->query($sql);
            $arr_users = [];
            if ($result->num_rows > 0) {
                $arr_users = $result->fetch_all(MYSQLI_ASSOC);
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datatable</title>
      <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="jquery/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css"/>
</head>
<body>
    <br>
    <div class="container">
    <table id="userTable">
        <thead>
            <th>Bank Name</th>
            <th>Zone</th>
            <th>Branch Name</th>
            <th>District</th> 
        </thead>
        <tbody>
            <?php if(!empty($arr_users)) { ?>
                <?php foreach($arr_users as $user) { ?>
                    <tr>
                        <td><?php echo $user['BankName']; ?></td>
                        <td><?php echo $user['ZoneRegionName']; ?></td>
                        <td><?php echo $user['BranchName']; ?></td>
                        <td><?php echo $user['Address3']; ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
    </script>
</body>
</html>