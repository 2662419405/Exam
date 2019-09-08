<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$total_id=$_POST['ids'];
		
	if(sizeof($total_id)==0){
		echo "<head><meta charset='utf-8'></head>";
   	    echo "<script>window.location.href='news.php'; alert('没有选择题目');</script>";
   	    exit;
	}

	$ming=0;
	foreach($total_id as $to){
		$s=$total_id[$ming];
		$sql="delete from exam_news where id =:s";
		$shanchu=$db->query($sql,array('s'=>$s));
		$ming++;
	}
	
	echo "<head><meta charset='utf-8'></head>";
    echo "<script>window.location.href='news.php';</script>";
    exit;
	
	
	?>