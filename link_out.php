<html lang="en">

<head>


<?php include("texts.php");?>
<?php include("meta.php");?>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body >
   <div class="row m-0"><br><br><br>
<?php include("menu.php");?>

<div class="container mt-5  text-left " dir="ltr" >
<?php





include("db_connection.php");
$limit = 30; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$my_string="";
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$query = "SELECT * FROM cars WHERE id LIKE '%$search%' order by id desc LIMIT $start, $limit";
$result = $conn->query($query);

$total_query = "SELECT COUNT(*) FROM cars WHERE id LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total = $total_result->fetch_row()[0];

$pages = ceil($total / $limit);
?>

<?php if ($result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
<?php

echo'<p class="">';
    
if ($row['manufactor']<>"-")
{

   $my_string =$my_string.'الماركة : '.$row['manufactor'].'<br>' ;
   
}

if ($row['model']<>"0000" and $row['model']<>"-")
{

   $my_string =$my_string.'الموديل : '.$row['model'].'<br>' ;
   
}


if ($row['vin']<>"")
{

   $my_string =$my_string.'شاسي : '.$row['vin'].'<br>' ;
   
}

if ($row['plate_number']<>"-")
{

   $my_string =$my_string.'  لوحة  : '.$row['plate_number'].'<br>' ;
   
}


if ($row['p_date']<>"-")
{

   $my_string =$my_string.'  التاريخ  : '.$row['p_date'].'<br>' ;
   
}

if ($row['color']<>"-")
{

   $my_string =$my_string.'  اللون  : '.$row['color'].'<br>' ;
   
}





$my_string =$my_string.'<br>'.$my_url.'/car_information.php?car_id='.$row['id'].'</p><br><br>';


?>
<?php endwhile; 
echo $my_string;

?>

<?php else: ?>
<p>No results found</p>
<?php endif; ?>

<nav aria-label="Page navigation example" class="w-100 text-center">
<ul class="pagination pagination pagination-sm">
<div class="row mt-5">
<div class="col text-center">
<div class="block-27">
<ul class=""  >
<?php for ($i = 1; $i <= $pages; $i++): ?>

<?php if($page==$i)
{

echo'<li class="page-item active"><a href="?search=',$search.'&page='.$i.'">'.$i.'</a></li>';
}
else
{
echo'<li class="page-item "><a  href="?search='.urlencode($search).'&page='.$i.'">'.$i.'</a></li>';


}
?>
<?php endfor; ?>
</ul>
</div>
</div>
</div>
</ul>
</nav>
</div>
</div>
</body>
</html>
