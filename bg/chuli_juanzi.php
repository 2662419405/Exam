<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	
	$ti_type=$_POST['shijuan_type'];//题类型
	$juanzi_wenti=$_POST['juanzi_wenti'];//问题
	$juanzi_jiexi=$_POST['juanzi_jiexi'];//解析
	$juanzi_biao=$_POST['juanzi_biao'];
	$chinese=$_POST['chinese'];
	$name=$_POST['name'];
	$zuozhe=$_POST['zuozhe'];
	$wenti_id=$_POST['wenti_id'];
		
	if($juanzi_biao==1){
		//新增
		$addtime=time();
		if($ti_type==1){
			$juanzi_A=$_POST['juanzi_A'];
			$juanzi_B=$_POST['juanzi_B'];
			$juanzi_C=$_POST['juanzi_C'];
			$juanzi_D=$_POST['juanzi_D'];
			$juanzi_xuan=$_POST['juanzi_xuan'];

			$sql="insert into exam_zhuanye (pro_type,chinese,name,content,xuanze_A,xuanze_B,xuanze_C,xuanze_D,answer,resolve,exam_addtime,exam_name) value (:ti_tpye,:chinese,:name,:content,:xuanze_A,:xuanze_B,:xuanze_C,:xuanze_D,:daan,:jiexi,$addtime,:exam_name)";
			$insert_sql=$db->query($sql,array('ti_tpye'=>$ti_type,'chinese'=>$chinese,'name'=>$name,'content'=>$juanzi_wenti,'xuanze_A'=>$juanzi_A,'xuanze_B'=>$juanzi_B,'xuanze_C'=>$juanzi_C,'xuanze_D'=>$juanzi_D,'daan'=>$juanzi_xuan,'jiexi'=>$juanzi_jiexi,'exam_name'=>$zuozhe));
			
			if($insert_sql){
				echo 1;
				exit;
			}else{
				echo -1;
				exit;
			}
			
		}elseif($ti_type==2){
			//填空
			$juanzi_tian=$_POST['juanzi_tian'];
			$sql="insert into exam_zhuanye (pro_type,chinese,name,content,answer,resolve,exam_addtime,exam_name) value (:ti_tpye,:chinese,:name,:content,:daan,:jiexi,$addtime,:exam_name)";
			$insert_sql=$db->query($sql,array('ti_tpye'=>$ti_type,'chinese'=>$chinese,'name'=>$name,'content'=>$juanzi_wenti,'daan'=>$juanzi_tian,'jiexi'=>$juanzi_jiexi,'exam_name'=>$zuozhe));
			
			if($insert_sql){
				echo 1;
				exit;
			}else{
				echo -1;
				exit;
			}
			
		}elseif($ti_type==3){
			//判断
			$juanzi_pan=$_POST['juanzi_pan'];
			$sql="insert into exam_zhuanye (pro_type,chinese,name,content,answer,resolve,exam_addtime,exam_name) value (:ti_tpye,:chinese,:name,:content,:daan,:jiexi,$addtime,:exam_name)";
			$insert_sql=$db->query($sql,array('ti_tpye'=>$ti_type,'chinese'=>$chinese,'name'=>$name,'content'=>$juanzi_wenti,'daan'=>$juanzi_pan,'jiexi'=>$juanzi_jiexi,'exam_name'=>$zuozhe));
			
			if($insert_sql){
				echo 1;
				exit;
			}else{
				echo -1;
				exit;
			}
			
		}
	}elseif($juanzi_biao==2){
		
		//编辑
		$addtime=time();
		if($ti_type==1){
			$juanzi_A=$_POST['juanzi_A'];
			$juanzi_B=$_POST['juanzi_B'];
			$juanzi_C=$_POST['juanzi_C'];
			$juanzi_D=$_POST['juanzi_D'];
			$juanzi_xuan=$_POST['juanzi_xuan'];

			$sql="update exam_zhuanye set pro_type =:ti_tpye,chinese =:chinese,name =:name,content =:content,xuanze_A =:xuanze_A,xuanze_B =:xuanze_B,xuanze_C =:xuanze_C,xuanze_D =:xuanze_D,answer =:daan,resolve =:jiexi,exam_addtime =$addtime,exam_name =:exam_name where id=:id";
			
			$update_sql=$db->query($sql,array('ti_tpye'=>$ti_type,'chinese'=>$chinese,'name'=>$name,'content'=>$juanzi_wenti,'xuanze_A'=>$juanzi_A,'xuanze_B'=>$juanzi_B,'xuanze_C'=>$juanzi_C,'xuanze_D'=>$juanzi_D,'daan'=>$juanzi_xuan,'jiexi'=>$juanzi_jiexi,'exam_name'=>$zuozhe,'id'=>$wenti_id));
			
			if($update_sql){
				echo 1;
				exit;
			}else{
				echo -1;
				exit;
			}
			
		}elseif($ti_type==2){
			//填空
			$juanzi_tian=$_POST['juanzi_tian'];
			$sql="update exam_zhuanye set pro_type =:ti_tpye,chinese =:chinese,name =:name,content =:content,answer =:daan,resolve =:jiexi,exam_addtime =$addtime,exam_name =:exam_name where id=:id";
			
			$update_sql=$db->query($sql,array('ti_tpye'=>$ti_type,'chinese'=>$chinese,'name'=>$name,'content'=>$juanzi_wenti,'daan'=>$juanzi_xuan,'jiexi'=>$juanzi_jiexi,'exam_name'=>$zuozhe,'id'=>$wenti_id));
			
			if($update_sql){
				echo 1;
				exit;
			}else{
				echo -1;
				exit;
			}
			
		}elseif($ti_type==3){
			//判断
			$juanzi_pan=$_POST['juanzi_pan'];
			$sql="update exam_zhuanye set pro_type =:ti_tpye,chinese =:chinese,name =:name,content =:content,answer =:daan,resolve =:jiexi,exam_addtime =$addtime,exam_name =:exam_name where id=:id";
			
			$update_sql=$db->query($sql,array('ti_tpye'=>$ti_type,'chinese'=>$chinese,'name'=>$name,'content'=>$juanzi_wenti,'daan'=>$juanzi_xuan,'jiexi'=>$juanzi_jiexi,'exam_name'=>$zuozhe,'id'=>$wenti_id));
			
			if($update_sql){
				echo 1;
				exit;
			}else{
				echo -1;
				exit;
			}
			
		}
		
	}elseif($juanzi_biao==3){
		
		$sql="delete from exam_zhuanye where id =:id";
		$shan_sql=$db->query($sql,array('id'=>$wenti_id));
		
		if($shan_sql){
			echo 1;
			exit;
		}else{
			echo -1;
			exit;
		}
	}
	
	include("bg_view/header.html");
	?>