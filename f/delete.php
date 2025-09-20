<meta charset="utf-8">

<?php
if(isset($_GET['fid'])){
	include("connectdb.php");
	$sql = "DELETE FROM facalty WHERE f_id='{$_GET['fid']}' ";
	mysqli_query($sql)or die ("ลบข้อมูลไม่ได้");
	
	echo "<script>";
	echo "window.location='insert_faculty.php';";
	echo "</script>";
	
}
?>