<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	
	//题的id 
	$chuti_id=$_POST['chuti_id'];
	//题的专业
	$zhuanye=$_POST['chuti_tiku'];
	//题的类型
	$chuti_type=$_POST['chuti_type'];
	//题的内容
	$chuti_content=$_POST['chuti_content'];
	//题的选项
	$xuan_A=$_POST['xuan_A'];
	$xuan_B=$_POST['xuan_B'];
	$xuan_C=$_POST['xuan_C'];
	$xuan_D=$_POST['xuan_D'];
	//解析
	$chuti_resolve=$_POST['chuti_resolve'];
	//答案
	$chuti_daan=$_POST['chuti_daan'];
	//作者
	$chuti_zuozhe=$_POST['chuti_zuozhe'];
	//标记为那套卷子  1课堂 2热门  3题库
	$chuti_biaoji=$_POST['chuti_biaoji'];
	//标记为是修改还是新增  1 新增 2修改
	$chuti_biao=$_POST['chuti_biao'];
	
	//先对输入的数据进行判断
	if($chuti_biaoji==1){
		
		if($chuti_content==""){
			echo "<head><meta charset='utf-8'></head>";
       		echo "<script>alert('题目内容为空');window.location.href='shiti.php';</script>";
       		exit;
		}
		
		if($chuti_daan==""){
			echo "<head><meta charset='utf-8'></head>";
       		echo "<script>alert('答案为空');window.location.href='shiti.php';</script>";
       		exit;
		}
		
		if($chuti_type==1){
			
			if(!($chuti_daan=='A'||$chuti_daan=='a'||$chuti_daan=='B'||$chuti_daan=='b'||$chuti_daan=='C'||$chuti_daan=='c'||$chuti_daan=='D'||$chuti_daan=='d')){
				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('答案类型不对');window.location.href='shiti.php';</script>";
       			exit;
			}
			
			if($xuan_A==""||$xuan_B==""||$xuan_C==""||$xuan_D==""){
				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('ABCD有空值');window.location.href='shiti.php';</script>";
       			exit;
			}
		}
		
		if($chuti_type==3){
			
			if(!($chuti_daan=='1'||$chuti_daan=='0')){
				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('答案类型不对');window.location.href='shiti.php';</script>";
       			exit;
			}
			
		}
		
		if($chuti_zuozhe==""){
			echo "<head><meta charset='utf-8'></head>";
       		echo "<script>alert('作者不能为空');window.location.href='shiti.php';</script>";
       		exit;
		}else{
			$sql  = "select username from user where username = :username and level = 2";
   			$name = $db->row($sql,array('username'=>$chuti_zuozhe));
   			if(!$name){
   				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('这个老师不存在');window.location.href='shiti.php';</script>";
       			exit;
   			}
		}
		
	}elseif($chuti_biaoji==2){
		
		if($chuti_content==""){
			echo "<head><meta charset='utf-8'></head>";
       		echo "<script>alert('题目内容为空');window.location.href='hot.php';</script>";
       		exit;
		}
		
		if($chuti_daan==""){
			echo "<head><meta charset='utf-8'></head>";
       		echo "<script>alert('答案为空');window.location.href='hot.php';</script>";
       		exit;
		}
		
		if($chuti_type==1){
			
			if(!($chuti_daan=='A'||$chuti_daan=='a'||$chuti_daan=='B'||$chuti_daan=='b'||$chuti_daan=='C'||$chuti_daan=='c'||$chuti_daan=='D'||$chuti_daan=='d')){
				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('答案类型不对');window.location.href='hot.php';</script>";
       			exit;
			}
			
			if($xuan_A==""||$xuan_B==""||$xuan_C==""||$xuan_D==""){
				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('ABCD有空值');window.location.href='hot.php';</script>";
       			exit;
			}
		}
		
		if($chuti_type==3){
			
			if(!($chuti_daan=='1'||$chuti_daan=='0')){
				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('答案类型不对');window.location.href='hot.php';</script>";
       			exit;
			}
			
		}
		
		if($chuti_zuozhe==""){
			echo "<head><meta charset='utf-8'></head>";
       		echo "<script>alert('作者不能为空');window.location.href='hot.php';</script>";
       		exit;
		}else{
			$sql  = "select username from user where username = :username and level = 2";
   			$name = $db->row($sql,array('username'=>$chuti_zuozhe));
   			if(!$name){
   				echo "<head><meta charset='utf-8'></head>";
       			echo "<script>alert('这个老师不存在');window.location.href='hot.php';</script>";
       			exit;
   			}
		}
		
	}
	
	//进行字符串的拼接
	if((substr($xuan_A,0,1)=='A')||(substr($xuan_A,0,1)=='a')){
	}else{
		$xuan_A="A).".$xuan_A;
	}
	if((substr($xuan_B,0,1)=='B')||(substr($xuan_B,0,1)=='b')){
	}else{
		$xuan_B="B).".$xuan_B;
	}
	if((substr($xuan_C,0,1)=='C')||(substr($xuan_C,0,1)=='c')){
	}else{
		$xuan_C="C).".$xuan_C;
	}
	if((substr($xuan_D,0,1)=='D')||(substr($xuan_D,0,1)=='d')){
	}else{
		$xuan_D="D).".$xuan_D;
	}
	
	if($chuti_biao==2){
		//更新
		if($chuti_biaoji==1){
			//更新哪套卷子
			$sql  = "select * from exam_problem where id = :id";
   			$ti = $db->row($sql,array('id'=>$chuti_id));
   			//如果存在执行更新操作
   			if(isset($ti)){
   				//判断更新的题的类型
   				if($chuti_type==1){
   					$update_sql="update exam_problem set chinese = :zhunaye,content = :content,xuanze_A = :xuanze_A,xuanze_B = :xuanze_B,xuanze_C = :xuanze_C,xuanze_D = :xuanze_D,answer = :answer,resolve = :resolve,exam_name = :exam_name where id = :id";
					$update  =  $db->query($update_sql,array('zhunaye'=>$zhuanye,'content'=>$chuti_content,'xuanze_A'=>$xuan_A,'xuanze_B'=>$xuan_B,'xuanze_C'=>$xuan_C,'xuanze_D'=>$xuan_D,'answer'=>$chuti_daan,'resolve'=>$chuti_resolve,'exam_name'=>$chuti_zuozhe,'id'=>$chuti_id));
					echo "<head><meta charset='utf-8'></head>";
       				echo "<script>window.location.href='shiti.php';</script>";
       				exit;
   				}elseif($chuti_type==2){
   					$update_sql="update exam_problem set chinese = :zhunaye,content = :content,xuanze_A = :xuanze_A,xuanze_B = :xuanze_B,xuanze_C = :xuanze_C,xuanze_D = :xuanze_D,answer = :answer,resolve = :resolve,exam_name = :exam_name where id = :id";
					$update  =  $db->query($update_sql,array('zhunaye'=>$zhuanye,'content'=>$chuti_content,'xuanze_A'=>" ",'xuanze_B'=>" ",'xuanze_C'=>" ",'xuanze_D'=>" ",'answer'=>$chuti_daan,'resolve'=>$chuti_resolve,'exam_name'=>$chuti_zuozhe,'id'=>$chuti_id));
					echo "<head><meta charset='utf-8'></head>";
       				echo "<script>window.location.href='shiti.php';</script>";
       				exit;
   				}
   			}else{
   				echo "<head><meta charset='utf-8'></head>";
       			echo "<script> alert('更新失败!不存在该题');window.location.href='shiti.php';</script>";
       			exit;
   			}
		}else if($chuti_biaoji==2){
			//更新哪套卷子
			$sql  = "select * from exam_hot where id = :id";
   			$ti = $db->row($sql,array('id'=>$chuti_id));
   			//如果存在执行更新操作
   			if(isset($ti)){
   				//判断更新的题的类型
   				if($chuti_type==1){
   					$update_sql="update exam_hot set chinese = :zhunaye,content = :content,xuanze_A = :xuanze_A,xuanze_B = :xuanze_B,xuanze_C = :xuanze_C,xuanze_D = :xuanze_D,answer = :answer,resolve = :resolve,exam_name = :exam_name where id = :id";
					$update  =  $db->query($update_sql,array('zhunaye'=>$zhuanye,'content'=>$chuti_content,'xuanze_A'=>$xuan_A,'xuanze_B'=>$xuan_B,'xuanze_C'=>$xuan_C,'xuanze_D'=>$xuan_D,'answer'=>$chuti_daan,'resolve'=>$chuti_resolve,'exam_name'=>$chuti_zuozhe,'id'=>$chuti_id));
					echo "<head><meta charset='utf-8'></head>";
       				echo "<script>window.location.href='shiti.php';</script>";
       				exit;
   				}
   				elseif($chuti_type==2){
   					$update_sql="update exam_hot set chinese = :zhunaye,content = :content,xuanze_A = :xuanze_A,xuanze_B = :xuanze_B,xuanze_C = :xuanze_C,xuanze_D = :xuanze_D,answer = :answer,resolve = :resolve,exam_name = :exam_name where id = :id";
					$update  =  $db->query($update_sql,array('zhunaye'=>$zhuanye,'content'=>$chuti_content,'xuanze_A'=>" ",'xuanze_B'=>" ",'xuanze_C'=>" ",'xuanze_D'=>" ",'answer'=>$chuti_daan,'resolve'=>$chuti_resolve,'exam_name'=>$chuti_zuozhe,'id'=>$chuti_id));
					echo "<head><meta charset='utf-8'></head>";
       				echo "<script>window.location.href='hot.php';</script>";
       				exit;
   				}
   			}else{
   				echo "<head><meta charset='utf-8'></head>";
       			echo "<script> alert('更新失败!不存在该题');window.location.href='hot.php';</script>";
       			exit;
   			}
		}
	}else{
		//新增
		if($chuti_biaoji==1){
			//新增哪套卷子
			if($chuti_type==1){
				$addtime=time();
				
				$insert_sql1 = "insert into exam_problem ( pro_type , chinese ,content ,xuanze_A,xuanze_B,xuanze_C,xuanze_D,answer,resolve,exam_addtime,exam_name) VALUE ( 1,:chinese,:content,:xuanze_A,:xuanze_B,:xuanze_C,:xuanze_D,:answer,:resolve,$addtime,:exam_name)";
				
			    $insert_id  = $db->query($insert_sql1,array('chinese'=>$zhuanye,'content'=>$chuti_content,'xuanze_A'=>$xuan_A,'xuanze_B'=>$xuan_B,'xuanze_C'=>$xuan_C,'xuanze_D'=>$xuan_D,'answer'=>$chuti_daan,'resolve'=>$chuti_resolve,'exam_name'=>$chuti_zuozhe));
			    echo "<head><meta charset='utf-8'></head>";
       			echo "<script>window.location.href='shiti.php';</script>";
       			exit;
       			
			}
		}else if($chuti_biaoji==2){
			
				$addtime=time();
				
				$insert_sql1 = "insert into exam_hot ( pro_type , chinese ,content ,xuanze_A,xuanze_B,xuanze_C,xuanze_D,answer,resolve,exam_addtime,exam_name) VALUE ( 1,:chinese,:content,:xuanze_A,:xuanze_B,:xuanze_C,:xuanze_D,:answer,:resolve,$addtime,:exam_name)";
				
			    $insert_id  = $db->query($insert_sql1,array('chinese'=>$zhuanye,'content'=>$chuti_content,'xuanze_A'=>$xuan_A,'xuanze_B'=>$xuan_B,'xuanze_C'=>$xuan_C,'xuanze_D'=>$xuan_D,'answer'=>$chuti_daan,'resolve'=>$chuti_resolve,'exam_name'=>$chuti_zuozhe));
			    echo "<head><meta charset='utf-8'></head>";
       			echo "<script>window.location.href='hot.php';</script>";
       			exit;
       			
		}
	}
	
	include("bg_view/header.html");
	
	?>
