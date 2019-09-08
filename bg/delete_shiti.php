<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));

	$total_id=$_POST['ids'];
	$biaoji=$_POST['biao_ji'];
	
	if($biaoji==1){
		
		if(sizeof($total_id)==0){
			echo "<head><meta charset='utf-8'></head>";
	   	    echo "<script>window.location.href='shiti.php'; alert('没有选择题目');</script>";
	   	    exit;
		}
	
		$ming=0;
		foreach($total_id as $to){
			$s=$total_id[$ming];
			$sql="delete from exam_problem where id =:s";
			$shanchu=$db->query($sql,array('s'=>$s));
			$ming++;
		}
		
		echo "<head><meta charset='utf-8'></head>";
	    echo "<script>window.location.href='shiti.php';</script>";
	    exit;
	    
	}elseif($biaoji==2){
		
		if(sizeof($total_id)==0){
			echo "<head><meta charset='utf-8'></head>";
	   	    echo "<script>window.location.href='hot.php'; alert('没有选择题目');</script>";
	   	     exit;
		}
	
		$ming=0;
		foreach($total_id as $to){
			$s=$total_id[$ming];
			$sql="delete from exam_hot where id =:s";
			$shanchu=$db->query($sql,array('s'=>$s));
			$ming++;
		}
		
		echo "<head><meta charset='utf-8'></head>";
	    echo "<script>window.location.href='hot.php';</script>";
	     exit;
		
	}else{
		
		if(sizeof($total_id)==0){
			echo "<head><meta charset='utf-8'></head>";
	   	    echo "<script>window.location.href='zhuanye.php'; alert('没有选择题目');</script>";
	   	     exit;
		}
	
		$ming=0;
		foreach($total_id as $to){
			$s=$total_id[$ming];
			$sql="delete from exam_zhuanye where id =:s";
			$shanchu=$db->query($sql,array('s'=>$s));
			$ming++;
		}
		
		echo "<head><meta charset='utf-8'></head>";
	    echo "<script>window.location.href='zhuanye.php';</script>";
	     exit;
		
	}
	
	
	?>