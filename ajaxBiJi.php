<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	$biji=$_POST['biji'];
	$ti_id=$_POST['ti_id'];
	
	$sql="update mistake set exam_content = :biji where exam_id = :ti_id";
	$update  =  $db->query($sql,array('biji'=>$biji,'ti_id'=>$ti_id));
	
	if($update){
		echo 1;
	}else{
		echo 0;
	}
	
?>