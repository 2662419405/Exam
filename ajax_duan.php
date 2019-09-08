<?php
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $db   = new Db();
    session_start();
    
    $tel=$_POST['otel'];
    
    $sql  = "select * from user where tel = :tel";
    $t = $db->row($sql,array('tel'=>$tel));
    $name=$t['username'];
    
    if(!$t){
    	echo -1;
        exit;
    }else{
    	//如果存在这个号码
		include 'smsapi.class.php';
    	//接口账号
		$uid = 'sunhang';
		//接口密码
		$pwd = '80a1580da2040d43e6aa990d78a203d1';
		$api = new SmsApi($uid,$pwd);
		$mobile = $tel;
		$yan=$api->randNumber();
    	//短信内容参数
		$contentParam = array(
			'code'		=> $yan,
			'name'	=> $name
		);
		
		//变量模板ID
		$template = '493183';
		
		//发送变量模板短信
		$result = $api->send($mobile,$contentParam,$template);
		
		if($result['stat']=='100')
		{
			$_SESSION['dx_code'] = $yan;
			echo 1;
			exit;
		}
		else
		{
			echo '发送失败:'.$result['stat'].'('.$result['message'].')';
			exit;
		}
		
    }
    
?>