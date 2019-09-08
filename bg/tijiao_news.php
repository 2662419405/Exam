<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	//标记1表示新增 2表示编辑
	$biao=$_POST['biaoji'];
	$news_title=$_POST['news_title'];
	$news_href=$_POST['news_href'];
	$news_height=$_POST['news_height'];
	
	if($news_title==""){
		echo "<head><meta charset='utf-8'></head>";
   		echo "<script>alert('标题为空');window.location.href='news.php';</script>";
   		exit;
	}
	if($news_href==""){
		echo "<head><meta charset='utf-8'></head>";
   		echo "<script>alert('超链接为空');window.location.href='news.php';</script>";
   		exit;
	}
	
	if($biao==1){
		//新增
		$addtime=time();
		
		$insert_sql1 = "insert into exam_news ( title , news_href ,addtime,height) VALUE (:title,:news_href,$addtime,:height)";
	    $insert_id  = $db->query($insert_sql1,array('title'=>$news_title,'news_href'=>$news_href,'height'=>$news_height));
	    echo "<head><meta charset='utf-8'></head>";
		echo "<script>window.location.href='news.php';</script>";
		exit;		
		
	}elseif($biao==2){
		//编辑
		$news_id=$_POST['news_id'];
		$sql  = "select * from exam_news where id = :id";
		$ti = $db->row($sql,array('id'=>$news_id));
		//如果存在执行更新操作
		if(isset($ti)){
			$update_sql="update exam_news set title = :title,news_href = :news_href,height =:height where id = :id";
			$update  =  $db->query($update_sql,array('title'=>$news_title,'news_href'=>$news_href,'id'=>$news_id,'height'=>$news_height));
			echo "<head><meta charset='utf-8'></head>";
			echo "<script>window.location.href='news.php';</script>";
			exit;
		}
	}
	
	include("bg_view/header.html");
	
	?>