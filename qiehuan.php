<?php
    session_start();
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $p_id=2;

    $sql  = "select * from user where username = :username and password = :password";
    $sql_id  = "select * from user where username = :username and password = :password and level=:p_id";
    $db   = new Db();
    $user = $db->row($sql,array('username'=>$username,'password'=>md5($password)));
    $user_id=$db->row($sql_id,array('username'=>$username,'password'=>md5($password),'p_id'=>$p_id));
    if($user_id){
    	$_SESSION['user']= $user;
    	$_SESSION['level']=2;
    	echo "<head><meta charset='utf-8'></head>";
        echo "<script> window.location.href='bg/index.php';</script>";
    }else{
    	if($user){
    		$na=$user['username'];
        	$_SESSION['user']= $user;
        	$_SESSION['level']=1;
        	echo "<head><meta charset='utf-8'></head>";
       		echo "<script> window.location.href='index.php';</script>";
	    }else{
	        echo "<head><meta charset='utf-8'></head>";
        	echo "<script> window.location.href='index.php';alert('切换失败');</script>";
	    }
    }
    
