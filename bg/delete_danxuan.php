<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	
	$biaoji=$_GET['biaoji'];
	$shiti_id=$_GET['shiti_id'];
	
	if($biaoji==1){
		$sql="delete from exam_problem where id =:s";
		$shanchu=$db->query($sql,array('s'=>$shiti_id));
		echo "<head><meta charset='utf-8'></head>";
		echo "<script>window.location.href='shiti.php';</script>";
		exit;
	}elseif($biaoji==2){
		$sql="delete from exam_hot where id =:s";
		$shanchu=$db->query($sql,array('s'=>$shiti_id));
		echo "<head><meta charset='utf-8'></head>";
		echo "<script>window.location.href='hot.php';</script>";
		exit;
	}
	
	
	?>