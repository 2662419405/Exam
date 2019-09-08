<?php
    session_start();
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $authcode  = $_POST['authcode'];
    
    if($authcode!=$_SESSION['authcode']){
    	echo -2;
    	exit;
    }
    
    $p_id=2;
    

    $sql  = "select * from user where username = :username and password = :password";
    $sql_id  = "select * from user where username = :username and password = :password and level=:p_id";
    $db   = new Db();
    $user = $db->row($sql,array('username'=>$username,'password'=>md5($password)));
    $user_id=$db->row($sql_id,array('username'=>$username,'password'=>md5($password),'p_id'=>$p_id));
    if($user_id){
    	$_SESSION['user']= $user;
    	$_SESSION['level']=2;
    	echo 2;
    	exit;
    }else{
    	if($user){
        $_SESSION['user']= $user;
        $_SESSION['level']=1;
        
        $shi=time();
        $sql_time="update user set last_addtime = $shi where username = :username";
        $db->query($sql_time,array('username'=>$username));
        
        echo 1;
	    }else{
	        echo -1;
	    }
    }
    
