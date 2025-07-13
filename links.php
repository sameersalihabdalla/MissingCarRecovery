<?php include("texts.php");
include("db_connection.php");

$sql = "SELECT * FROM cars order by id desc";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {

      echo '(#'.$row['id'].') '.$row['manufactor'].' - '. $row['model'] .' <br>  ';
if ($row['vin']<>"")
{

   echo'شاسي : '.$row['vin'] ;
   
}

if ($row['plate_number']<>"")
{

   echo'  لوحة  : '.$row['plate_number'] ;
   
}

echo'<br>https://www.jobsagent.org/car_information.php?car_id='.$row['id'];

echo'<br><br><br>';
   }}
?>