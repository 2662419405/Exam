<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	include("bg_view/header.html");
	
	//标记为那个回馈  1是经验  2是报错
	$biaoji=$_POST['huikui_biaoji'];
	if($biaoji==1){
		//表示为学习经验的处理
		$tui=$_POST['huikui_tui'];
		$id=$_POST['huikui_id'];
		if($tui==0){
			echo "<head><meta charset='utf-8'></head>";
        	echo "<script>alert('没有选择是否推荐');window.location.href='chuli_huikui.php?biaoji=1&chuli_id=$id';</script>";
        	exit;
		}
		$tou=$db->single("select count(*) from exception where height=2");
		if($tui==2){
			if($tou>=8){
				echo "<head><meta charset='utf-8'></head>";
	        	echo "<script>alert('推荐已满，请取消一共首页推荐之后在操作');window.location.href='chuli_huikui.php?biaoji=1&chuli_id=$id';</script>";
	        	exit;
			}else{
				$tuijian=$db->query('update exception set height = 2 where id = :pid',array('pid'=>$id));
				echo "<head><meta charset='utf-8'></head>";
		        echo "<script>window.location.href='jingyan_huikui.php';</script>";
		        exit;
			}
		}else{
			$tuijian=$db->query('update exception set height = 1 where id = :pid',array('pid'=>$id));
			echo "<head><meta charset='utf-8'></head>";
       	    echo "<script>window.location.href='jingyan_huikui.php';</script>";
       	    exit;
		}
		
	}elseif($biaoji==2){
		
		$id=$_POST['huikui_id'];
		$tuijian=$db->query('update exam_baocuo set tongguo = 2 where cuowu_id = :pid',array('pid'=>$id));
		echo "<head><meta charset='utf-8'></head>";
   	    echo "<script>window.location.href='baocuo_huikui.php';</script>";
   	    exit;
		
	}
	
	?>