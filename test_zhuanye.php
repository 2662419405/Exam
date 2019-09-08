<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	//接受参数
	$xibie=$_POST['chuti_xibie'];
	//出题的时间
	$shijian=$_POST['chuti_shijian'];
	$jiezhi=$_POST['chuti_jiezhi'];
	if($jiezhi<=$shijian){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('截止时间大于或等于出题时间');window.location.href='test.php';</script>";
	}
	//出题的老师
	$name=$_POST['chuti_name'];
	$sql_name  = "select username from user where level=2 AND username =:user";
    $name1 = $db->row($sql_name,array('user'=>$name));
    if((!$name1)&&$name!='全部'){
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('这个老师不存在');window.location.href='test.php';</script>";
    }
    
	if(($xibie=='全部')&&($name=='全部')){
		$sql="select * from exam_zhuanye where exam_addtime between :shijian and :jiezhi group by name order by num desc";
		$re=$db->query($sql,array('shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}elseif($xibie=='全部'){
		$sql="select * from exam_zhuanye where exam_name = :name and exam_addtime between :shijian and :jiezhi group by name order by num desc";
		$re=$db->query($sql,array('name'=>$name,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}elseif($name=='全部'){
		$sql="select * from exam_zhuanye where chinese = :xibie and exam_addtime between :shijian and :jiezhi group by name order by num desc";
		$re=$db->query($sql,array('xibie'=>$xibie,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}else{
		$sql="select * from exam_zhuanye where exam_name = :name and chinese = :xibie and exam_addtime between :shijian and :jiezhi group by name order by num desc";
		$re=$db->query($sql,array('name'=>$name,'xibie'=>$xibie,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}
	sizeof($re);
    
	
	//截取选择出来的试题
	
	?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="zhuanye_top">
				<h4>历年真题</h4>
			</div>
			<div class="zhuanye_index">
				<?php
					foreach($re as $vo){
						echo "<div class='zhuanye_content'>";
						echo "<form method='post' action='test_kaoshi.php'>";
						$t_name=$vo['name'];
						echo "<input type='hidden' name='text_name' value='$t_name'>";
						echo "<div class='zhuanye1'>";
						echo $t_name;
						echo "</div>";
						echo "<div class='zhuanye2'>";
						echo "<span>";
						echo $vo['num']."人做过";
						echo "</span>";
						echo "<span>";
						echo date('Y-m-d',$vo['exam_addtime']);
						echo "</span>";
						echo "<input type='submit' value='测试'>";
						echo "</form>";
						echo "</div>";
						echo "</div>";
					}
					?>
			</div>
		</div>
		<?php include_once("view/right.php"); ?>
	</div>
	<?php include_once("view/footer.html"); ?>
</body>
