<?php 

  include 'connection.php';

  $OID = $_GET['oid'];
  $card = $_GET['cardno'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $Status = $_GET['site'];
  $Date =  date("y/m/d");

  $queryTech="SELECT * FROM employees"; 
  $resultTech=mysqli_query($con2,$queryTech);  //select all products
  $queryTechnicianList= "SELECT * FROM employees inner join add_technician on employees.EmployeeCode=add_technician.TechnicianID where add_technician.EmployeeUID=$EmployeeUID";
  $resultTechnicianList=mysqli_query($con2,$queryTechnicianList);


  if(isset($_POST['Addtech']))
  {
    $EmployeeID=$_POST['EmployeeCode'];
    $querytechnician="SELECT * From employees where EmployeeCode=$EmployeeID";
    $resultTechnician=mysqli_query($con2,$querytechnician);
  }


    if(isset($_POST['Addtech']))
  {
    $EmployeeID=$_POST['EmployeeCode'];

    $queryCheckTechnician="SELECT * From employees where EmployeeCode=$EmployeeID";
    $resultCheckTechnician=mysqli_query($con2,$queryCheckTechnician);
    $dataCheckTechnician=mysqli_fetch_assoc($resultCheckTechnician);
    $TechnicianName = $dataCheckTechnician['Employee Name'];
    $TechnicianContact = $dataCheckTechnician['Phone'];
    $TechnicianCode = $dataCheckTechnician['Employee Code'];

      $queryAddtech="INSERT INTO `add_technician` (`tanid`, `EmployeeUID`, `TechnicianID`, `TechnicianName`, `TechnicianContact`, `TechnicianCode`) VALUES ('', '$EmployeeUID', '$EmployeeID', '$TechnicianName', $TechnicianContact, 'TechnicianCode');";
      mysqli_query($con2,$queryAddtech);

      if($queryAddtech){
        echo "<meta http-equiv='refresh' content='0'>";
      }
    }

  if(isset($_POST['submit']))
  {
    $a = 1;
    $more = $_POST['more'];
    $queryTechnician="SELECT TechnicianID FROM add_technician"; 
    $resultTechnician=mysqli_query($con2,$queryTechnician);  //select all products

    while($data=mysqli_fetch_assoc($resultTechnician)){
     $te = $data['TechnicianID'];;
      $jobcard = $card .$a;

       /* Insert Data into Approval database */
      $queryAdd="INSERT INTO `approval`( `EmployeeUID`, `BranchCode`, `ComplaintID`, `OrderID`, `JobCardNo`, `Status`, `EmployeeID`, `VisitDate`) VALUES ('$EmployeeUID', '$BranchCode','$complaintID','$OID', '$jobcard', '$Status', '$te', '$Date')";
      mysqli_query($con2,$queryAdd);
      $a++;
    }

    $queryRemove="DELETE FROM `add_technician` WHERE `EmployeeUID`='$EmployeeUID'";
    $resultRemove=mysqli_query($con2,$queryRemove); 

    if ($more == 'YES') {
      header("location:card.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID");
    }else{
      header("location:pro.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID");
    }
  }
?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Technician</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="datatable/jquery.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
        <style type="text/css">
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
    <br><br>
    <div class="container">
      <!-- Add technician Section -->
      <fieldset >
        <legend>Add Technician</legend>    
        <div class="col-lg-12">
            <form method="post" action="" class="form-inline">
              <label for="exampleFormControlSelect2">Select Technician
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
              <select  required name="EmployeeCode" class="form-control" id="exampleFormControlSelect2" >
                <?php
                  while($data=mysqli_fetch_assoc($resultTech)){
                    echo "<option value=".$data['EmployeeCode'].">".$data['Employee Name']."</option>";
                  }  
                ?>
              </select>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="submit"  class=" btn btn-success" value="Add" name="Addtech"></input>
            </form>
          </div>  
          <div class="col-lg-12 table-responsive">
            <table id="userTable2" class="display nowrap table-striped table-hover table-sm" id="exampleFormControlSelect2" class="form-control">
              <thead>
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Name</th>
                  <th scope="col">Contact Number</th>
                  <th scope="col">E-mail</th>
                </tr>
              </thead>
              <tbody>
                <?php while($data=mysqli_fetch_assoc($resultTechnicianList)){ ?>
                  <tr>
                    <td >
                      <?php echo $ttid =$data['TechnicianID']; ?>
                    </td>
                    <td >
                      <?php echo $data['TechnicianName']; ?>
                    </td>
                    <td >
                      <?php echo $data['TechnicianCode']; ?>
                    </td>
                    <td >
                      <?php echo $data['TechnicianContact']; ?>
                    </td>
                      <td >
                    <td >
                      <form accept="" method="post">
                        <input type="hidden" name="ttid" value=" <?php echo $ttid ?>">
                        <input type="hidden" name="tid" value="<?php echo $tid ?>">
                        <input type="hidden" name="tCode" value="<?php echo $data['TechnicianCode'] ?>">
                        <input type="submit" name="removeTechnician" value="Remove" class="btn btn-danger">
                      </form>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>     
            <br><br>  
            <form method="post" action="">
              <h5 align="center">More Cards:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="more" id="more" value="YES">
                <label for="YES">YES</label>
                &nbsp;&nbsp;&nbsp;
                <input type="radio" id="more" name="more" value="NO">
                <label for="NO">NO</label>
              </h5>
              <br>
              <center>
                <input type="submit"  class=" btn btn-success" value="submit" name="submit"></input>
              </center>      
            </form>
            <br>
          </div>
      </fieldset>
    </div> 
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js
"></script>

    <script type="text/javascript">
      
        $(document).ready(function() {
             var table = $('#userTable2').DataTable( {
                rowReorder: {
                selector: 'td:nth-child(2)'
                },
                responsive: true
            } );
        } );
    </script> 
  </body>
</html>


<?php if(isset($_POST['removeTechnician']))
  {
    $ttid=$_POST['ttid'];
    $tid=$_POST['tid'];
    //$tCode= $_POST['tCode'];

    $queryRemove="DELETE FROM `add_technician` WHERE  `TechnicianID`='$ttid' and `EmployeeUID`='$EmployeeUID'";
    $resultRemove=mysqli_query($con2,$queryRemove);
    if($resultRemove){

      echo "<meta http-equiv='refresh' content='0'>";
    }
  }
?>