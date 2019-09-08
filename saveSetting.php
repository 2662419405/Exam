<?php
    require("library/function.php");   //自定义函数
    require('library/Db.class.php');//连接数据库
    is_login(); //检测是否登陆
    $db      = new Db();
    $user_id = $_SESSION['user']['id'];
    $sex     = $_POST['sex'];
    $qq      = $_POST['qq'];
    $class_id      = $_POST['class_id'];
    $tel   = $_POST['tel'];
    
    $sql  = "select tel from user where tel = :tel";
    $t = $db->row($sql,array('tel'=>$tel));
    if($t){
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('电话号码存在');window.location.href='setting.php';</script>";
        exit;
    }
    
    $sql     = "UPDATE user SET sex = :sex,qq = :qq,tel = :tel,class_id = :class_id  WHERE id = :user_id";
    $update  =  $db->query($sql,array("user_id"=>$user_id,"sex"=>$sex,"qq"=>$qq,"tel"=>$tel,"class_id"=>$class_id));
    
    $sql1     = "UPDATE sort SET class_id = :class_id where user_id = :user_id";
    $update1  =  $db->query($sql1,array("class_id"=>$class_id,"user_id"=>$user_id));
    if($update !== false){
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('保存成功');window.location.href='setting.php';</script>";
        exit;
    }else{
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('保存失败');window.location.href='setting.php';</script>";
        exit;
    }
    