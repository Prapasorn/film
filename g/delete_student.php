<meta charset="utf-8">
<?php
if (isset($_GET['id'])){
	include("connectdb.php");
	$sql = "DELETE FROM faculty WHERE f_id='{$_GET['id']}' ";
	mysqli_query($conn,$sql) or die ("ลบข้อมูลไม่ได้") ;
	
	echo "<script>";
	echo "window.location='select_student.php' ";
	echo "</script>";
	
}
?>


