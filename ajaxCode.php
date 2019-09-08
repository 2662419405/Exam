<?php
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $db   = new Db();
    session_start();
    
    $dx=$_POST['yan'];
    $tel=$_POST['otel'];
    
    $sql  = "select * from user where tel = :tel";
    $t = $db->row($sql,array('tel'=>$tel));
    $name=$t['username'];
    
    if($dx==$_SESSION['dx_code']){
    	$s = "update user set password = :password where username = :name";
    	$jin=$db->query($s,array('password'=>md5('123'),'name'=>$name));
    	echo 1;
    	exit;
    }else{
    	echo -1;
    	exit;
    }
    
?>