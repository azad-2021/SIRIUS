<?php 

  $OID = $_GET['oid'];
  $card = $_GET['cardno'];
  $complaintID = $_GET['cid'];
  $EmployeeUID = $_GET['eid'];
  $BranchCode = $_GET['brcode'];
  $Status = $_GET['site'];
  $Date =  date("y/m/d");

  include 'connection.php';


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
    $count = 1;
    $queryTechnician="SELECT TechnicianID FROM add_technician"; 
    $resultTechnician=mysqli_query($con2,$queryTechnician);  //select all products
    //$dataTechnician=mysqli_fetch_assoc($resultTechnician);
    //echo $dataTechnician;
    while($data=mysqli_fetch_assoc($resultTechnician)){
     $te = $data['TechnicianID'];
      //echo $te;
    
    //$app = strval($count);
    // echo $app;
     //echo var_dump($app);
     //$ne = strval($count);
    $jobcard = $card .=$count;


     echo $jobcard;
 /* Insert Data into Approval database */
    $queryAdd="INSERT INTO `approval`( `EmployeeUID`, `BranchCode`, `ComplaintID`, `OrderID`, `JobCardNo`, `Status`, `EmployeeID`, `VisitDate`) VALUES ('$EmployeeUID', '$BranchCode','$complaintID','$OID', '$jobcard', '$Status', '$te', '$Date')";
      mysqli_query($con2,$queryAdd);
    $count = $count+1;

    }

    $queryRemove="DELETE FROM `add_technician` WHERE `EmployeeUID`='$EmployeeUID'";
    $resultRemove=mysqli_query($con2,$queryRemove);

    if(isset($_POST['more'])){
      $more = $_POST['more'];

     if ($more == 'YES') {
      //echo $more;
      //echo $material;
         header("location:card.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID");
        }else{
         header("location:pro.php?cid=$complaintID&eid=$EmployeeUID&brcode=$BranchCode&oid=$OID");
        }

      }
    }





?>





<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Technician</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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

  <?php include'navbar.php';?>

  <br>
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

          <div class="col-lg-12">
            <table class="table">
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
      </fieldset>
      <form method="post" action="">
<!--
        <h5 align="center">Material Consumed:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="material" id="material" value="YES">
        <label for="OK">Yes</label>
        &nbsp;&nbsp;&nbsp;
        <input type="radio" id="material" name="material" value="NO">
        <label for="NOT OK">No</label>
        </h5>
        <br>
-->
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
   <!-- END of Technician section -->
      <br>
  </div>
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
    //echo 'Technician deleted success';
    }
  }
?>