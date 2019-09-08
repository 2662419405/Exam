<?php
    session_start();
    require('library/Db.class.php');
    $baocuo_id=$_POST['baocuo_id'];
    $baocuo_xi=$_POST['baocuo_xi'];
    $baocuo_xm=$_POST['baocuo_xm'];
    $biaoji=$_POST['biaoji'];
    $name=$_POST['name'];
    $setting_content=$_POST['setting_content'];
    $db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$addtime  = time();
	
	if($setting_content!=''){
		$insert_sql = "insert into exam_baocuo ( cuowu_id , exam_name ,exam_xi,exam_addtime,tongguo,exam_content,biaoji,name) VALUE ( :baocuo_id ,:baocuo_xm,:baocuo_xi,$addtime,1,:setting_content,:biaoji,:name)";
    	$insert_liuyan  = $db->query($insert_sql,array('baocuo_id'=>$baocuo_id,'baocuo_xm'=>$baocuo_xm,'baocuo_xi'=>$baocuo_xi,'setting_content'=>$setting_content,'biaoji'=>$biaoji,'name'=>$name));
    	echo 1;
    	exit;
	}else{
		echo -1;
		exit;
	}
