<?php
    session_start();
    require('library/Db.class.php');
    $content=$_POST['content'];
    $db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$addtime  = time();
	
	if($content!=''){
		$insert_sql = "insert into exception ( content , user_name ,addtime) VALUE ( :content ,:user_name,$addtime)";
    	$insert_liuyan  = $db->query($insert_sql,array('content'=>$content,'user_name'=>$user['username']));
    	echo 1;
    	exit;
	}else{
		echo -1;
		exit;
	}
