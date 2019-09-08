<?php
require('library/Db.class.php');
require("library/function.php");
is_login();
$db = new Db();

$receiver=$_GET['receiver'];
$last_time=$_GET['last'];
$max_id=$_GET['max_id'];

$sql_cha="select * from message where receiver = :receiver and addtime > :last_time and id >:max_id";
$hao=$db->query($sql_cha,array('receiver'=>$receiver,'last_time'=>$last_time,'max_id'=>$max_id));

echo json_encode($hao);
