<?php
$connect = mysqli_connect("localhost", "root", "", "allocationsystem");
if(isset($_POST["id"]))
{
 $query = "DELETE FROM departments WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
?>