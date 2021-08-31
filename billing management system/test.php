<?php 

  include 'connection.php';

  //$oid=36;
  $queryTech="SELECT * FROM technician"; 
  $resultTech=mysqli_query($con2,$queryTech);  //select all products
  $queryTechnicianList= "SELECT * FROM technician inner join add_technician on technician.tid=add_technician.taid";
  $resultTechnicianList=mysqli_query($con2,$queryTechnicianList);


  if(isset($_POST['Add']))
  {
    $tid=$_POST['tid'];
    $querytechnician="SELECT * From technician where tid=$tid";
    $resultTechnician=mysqli_query($con2,$querytechnician);
  }


    if(isset($_POST['Add']))
  {
    $tid=$_POST['tid'];
    $taNamed=$_POST['taName'];
    $taContact=$_POST['taContact'];
    $taEmail=$_POST['taEmail'];
    $queryCheckTechnician="SELECT * From technician where tid=$tid";
    $resultCheckTechnician=mysqli_query($con2,$queryCheckTechnician);
    $dataCheckTechnician=mysqli_fetch_assoc($resultCheckTechnician);

      $queryAdd="INSERT INTO `add_technician`(`taid`,`taName`, `taContact`, 'taEmail') VALUES ('$tid','$taName','$taContact','$taEmail')";
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


          <div class="col-lg-12">
            <form method="post" action="" class="form-inline">
                <label for="exampleFormControlSelect2">Select Technician</label>
                <select  required name="tid" class="form-control" id="exampleFormControlSelect2" >
                  <?php

                     while($data=mysqli_fetch_assoc($resultTech)){

                        echo "<option value=".$data['tid'].">".$data['tName']."</option>"; 
                      }  
                  ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit"  class=" btn btn-success" value="Add" name="Add"></input>
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
                        <?php echo $itid =$data['tid']; ?>
                      </td>
                      <td >
                         <?php echo $data['tName']; ?>
                      </td>
                      <td >
                        <?php echo $data['tContact']; ?>
                      </td>
                      <td >
                        <?php echo $data['tEmail']; ?>
                      </td>
                      <td >
                      <td >
                          <form accept="" method="post">
                            <input type="hidden" name="tid" value=" <?php echo $itid ?>">
                            <input type="submit" name="removeTechnician" value="Remove" class="btn btn-danger">
                          </form>
                      </td>
                    </tr>

                <?php } ?>
              </tbody>
            </table>
          </div>     


  </div>
</body>
</html>


<?php if(isset($_POST['removeTechnician']))
  {
    $tid=$_POST['tid'];

    $TqueryRemove="DELETE FROM `add_technician` WHERE  `taid`='$tid'";
    $TRemove=mysqli_query($con2,$TqueryRemove);
    if($TRemove){
      echo "<meta http-equiv='refresh' content='0'>";
    }
  }
?>