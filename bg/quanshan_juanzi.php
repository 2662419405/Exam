<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	
	$total_id=$_POST['ids'];
	
	if(sizeof($total_id)==0){
		echo "<head><meta charset='utf-8'></head>";
   	    echo "<script>window.location.href='zhuanye.php'; alert('没有选择卷子');</script>";
   	    exit;
	}else{
		foreach($total_id as $vo){
			$sql="delete from exam_zhuanye where name =:s";
			$shanchu=$db->query($sql,array('s'=>$vo));
		}
	}
	
	include("bg_view/header.html");
	?>