<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	
	$total=$_POST['check'];
	$biaoji=$_POST['biao_ji'];
	if($total==null){
		$total=$_GET['check1'];
		$biaoji=$_GET['biao_ji1'];
		$sql="delete from mistake where exam_id =:s and exam_biaoji = :biaoji";
		$shanchu=$db->query($sql,array('s'=>$total,'biaoji'=>$biaoji));
		echo "<head><meta charset='utf-8'></head>";
    	echo "<script>window.location.href='wrong_text.php';</script>";
	}
	
	if(sizeof($total)==0){
		echo "<head><meta charset='utf-8'></head>";
   	    echo "<script>window.location.href='wrong_text.php'; alert('没有选择题目');</script>";
	}

	$ming=0;
	foreach($total as $to){
		$s=$total[$ming];
		$b=$biaoji[$ming];
		$sql="delete from mistake where exam_id =:s and exam_biaoji = :biaoji";
		$shanchu=$db->query($sql,array('s'=>$s,'biaoji'=>$b));
		$ming++;
	}
	echo "<head><meta charset='utf-8'></head>";
    echo "<script>window.location.href='wrong_text.php';</script>";
	
	?>