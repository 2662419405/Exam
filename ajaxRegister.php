<?php
    require('library/Db.class.php');
    $username  = $_POST['username'];
    $password  = $_POST['password'];
    $db   = new Db();
    $sql  = "select username from user where username = :username";
    $name = $db->row($sql,array('username'=>$username));
    if($name){
        echo -1;
        exit;
    }
    $addtime  = time();
    
    $insert_sql = "insert into user ( username , password ,addtime) VALUE ( :username ,:password,$addtime)";
    $insert_sql1 = "insert into sort ( username , true_sum ,false_sum ,user_id) VALUE ( :username ,0,0,:user_id)";
    $insert_id  = $db->query($insert_sql,array('username'=>$username,'password'=>md5($password)));
    $sql1  = "select id from user where username = :username";
    $name1 = $db->query($sql1,array('username'=>$username));
    
    $insert_id1  = $db->query($insert_sql1,array('username'=>$username,'user_id'=>$name1[0]['id']));
    
    if($insert_id){
    	
    	$stu_ti=$db->row("select * from today");
		$s=$stu_ti['zhuche_sum']+1;
		$sql     = "UPDATE today SET zhuche_sum = :s";
	    $update  =  $db->query($sql,array('s'=>$s));
	    
        echo 1;
    }else{
        echo 0;
    }

