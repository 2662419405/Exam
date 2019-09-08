<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
$db = new Db();

$message=$_GET['message'];
$sender=$_GET['sender'];
$receiver=$_GET['receiver'];
$shijian=time();

$insert_sql = "insert into message ( msg , sender ,receiver ,color,addtime) VALUE (:message, :sender , :receiver ,:color , $shijian)";
    $insert_id  = $db->query($insert_sql,array('message'=>$message,'sender'=>$sender,'receiver'=>$receiver,'color'=>$color));
