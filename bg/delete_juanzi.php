<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	
	$shijuan_name=$_GET['shijuan_name'];
	
	$sql="delete from exam_zhuanye where name =:s";
	$shanchu=$db->query($sql,array('s'=>$shijuan_name));
	
	echo "<head><meta charset='utf-8'></head>";
	echo "<script>window.location.href='zhuanye.php';</script>";
	exit;
	
	?>