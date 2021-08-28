<?php
public function db(){
$db = mysqli_connect("localhost","root","","billing");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else
{
return $db;
}
}

public function insert(){

}

public function update()
{

}
public function select()
{
 $query ="SELECT * From "+$table;
 $result= mysqli_query($db();,$query);
 return $result;
}

?>