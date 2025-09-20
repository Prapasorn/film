<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ประภัสสร สองคร</title>
</head>

<body>
<h1>ประภัสสร สองคร(ฟิล์มมี่)</h1>

<form method="post" action="">
แม่สูตรคูณ<input type="number" name="a" autofocus>
<input type="submit" name="Submit" value="OK">
</form>
<hr>

<?php
if(isset ($_POST['Submit'])){
	$m =  $_POST['a'];
	
	for ($i=1; $i <=12; $i++){
		$x = $m * $i;
		echo number_format($m,0). " x ".$i. " = ".number_format($x,0)."<br>";
		//echo  "$m x " .$i." = $x <br>";
	}
}
?>
</body>
</html>