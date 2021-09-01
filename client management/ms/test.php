<?php 



  include 'connection.php';

  $tid=7;
  $queryTech="SELECT * FROM employees"; 
  $resultTech=mysqli_query($con2,$queryTech);  //select all products
  $queryTechnicianList= "SELECT * FROM employees inner join add_technician on employees.EmployeeCode=add_technician.TechnicianID where add_technician.tanid=$tid";
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

      $queryAdd="INSERT INTO `add_technician` (`tanid`, `TechnicianID`, `TechnicianName`, `TechnicianContact`, `TechnicianCode`) VALUES ('', '$EmployeeID', '$TechnicianName', $TechnicianContact, 'TechnicianCode');";
      mysqli_query($con2,$queryAdd);
      if($queryAdd){
        echo "<meta http-equiv='refresh' content='0'>";
      }  
    }


?>



  <!DOCTYPE html>
<html lang="en">
<head>
  <title>test</title>
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
          </div>     
        <br><br>  
      </fieldset>
  </div>
</body>
</html>

<?php if(isset($_POST['removeTechnician']))
  {
    $ttid=$_POST['ttid'];
    $tid=$_POST['tid'];
    $tCode= $_POST['tCode'];

    $queryRemove="DELETE FROM `add_technician` WHERE  `TechnicianID`='$ttid' and `tanid`='$tid' and `TechnicianCode`='$tCode'";
    $resultRemove=mysqli_query($con3,$queryRemove);
    if($resultRemove){

      echo "<meta http-equiv='refresh' content='0'>";
    }
  }
?>
?>