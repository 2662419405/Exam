<?php
    require('library/Db.class.php');
    require('library/function.php');
    is_login();
    $old_password  = $_POST['old_password'];
    $new_password1  = $_POST['new_password1'];
    $new_password2  = $_POST['new_password2'];
    
    $db   = new Db();
    $user_id = $_SESSION['user']['id'];

    $sql  = "select password from user where id = :id";
    $pas = $db->row($sql,array('id'=>$user_id));
    $p=$pas['password'];
    
    if($p==md5($old_password)){
        $sql     = "UPDATE user SET password = :new_password1 where username = :username";
    	$update  =  $db->query($sql,array('new_password1'=>md5($new_password1),'username'=>$_SESSION['user']['username']));
    	echo 1;
    }else{
    	echo -1;
    	exit;
    }
    
