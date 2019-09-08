<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	
	$news_id=$_GET['news_id'];
	
	$sql="delete from exam_news where id =:s";
	$shanchu=$db->query($sql,array('s'=>$news_id));
	
	echo "<head><meta charset='utf-8'></head>";
	echo "<script>window.location.href='news.php';</script>";
	exit;
	