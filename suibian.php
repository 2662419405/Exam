<?php
	require('library/Db.class.php');
	$db = new Db();
	
	$xuanxiang=$_GET['type'];
	$num=$_GET['num'];
	$xibie=$_GET['chinese'];
	$sql="select * from exam_problem where pro_type =:type and chinese =:xibie limit 200";
	$re=$db->query($sql,array('type'=>$xuanxiang,'xibie'=>$xibie));
	
	//代表错误情况
	if($re==null){
		echo 0;
		exit;
	}
	if($num!=0){
		shuffle($re);
		$result=array_slice($re,0,$num);
	}
	
	echo json_encode($result); 
?>