<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$dianzan=$_POST['radio101'];
	$shijian=$_POST['addtime'];
	$user_name=$_POST['user_na'];
	
	if($dianzan==1){
		$stu_good=$db->row("select * from exception where user_name = :user_us and addtime = :time",array('user_us'=>$user_name,'time'=>$shijian));
		$s=$stu_good['good']+1;
		$sql     = "UPDATE exception SET good = :go where user_name = :user_us and addtime = :time";
	    $update  =  $db->query($sql,array('go'=>$s,'user_us'=>$user_name,'time'=>$shijian));
	    echo "<head><meta charset='utf-8'></head>";
        echo "<script>window.location.href='index.php';</script>";
	}else if($dianzan==2){
		$stu_low=$db->row("select * from exception where user_name = :user_us and addtime = :time",array('user_us'=>$user_name,'time'=>$shijian));
		$s1=$stu_low['low']+1;
		$sql1 = "UPDATE exception SET low = :lo where user_name = :user_us and addtime = :time";
	    $update  =  $db->query($sql1,array('lo'=>$s1,'user_us'=>$user_name,'time'=>$shijian));
	    echo "<head><meta charset='utf-8'></head>";
        echo "<script>window.location.href='index.php';</script>";
	}else{
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('请选择你的意见');window.location.href='index.php';</script>";
	}	
	
	?>