<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	
	//用来接收题的id和题的名称
	$arr_id=$_POST['id'];
	$arr_chinese=$_POST['chinese'];
	$arr_biaoji=$_POST['biaoji'];
	$arr_xiang=$_POST['xiangxi'];
	
	//如果是错题本，接受每个题的来源
	$cuo=$_POST['cuo'];
	
	//接受参数
	$arr=$_POST['xuan']; //用来接收用户作答的答题数组
	$arr_answer=$_POST['tianswer']; //用来接受传递过来的答案数组
	$shu=$_POST['shu'];  //数量
	$arr_result=array();  //用来接受答案的结果
	$fenshu=0;   //分数
	
	for($i=0;$i<$shu;$i++){
		if($arr[$i]==$arr_answer[$i]){
			$arr_result[$i]='1';//正确
			$fenshu++;
		}else{
			$arr_result[$i]='0';//错误
		}
	}
	
	//开始时间
	if($_POST['start_time']==null){
		$start_time=time();
	}else{
		$start_time=$_POST['start_time'];
	}
	//现在的时间
	$end_time=time();
	$time_cha=$end_time-$start_time;
	
	//如果是错题本的错题
	if($arr_biaoji==4){
	    for($i=0;$i<$shu;$i++){
	    	//错题答案更新
	    	
	    	$s1=$arr[$i];//错题的新答案
			$sql111     = "UPDATE mistake set exam_cuowu = :false where username = :user_us AND exam_biaoji = :cuo AND exam_id = :id";
		    $update  =  $db->query($sql111,array('false'=>$s1,'user_us'=>$user['username'],'cuo'=>$cuo[$i],'id'=>$arr_id[$i]));
		    //错题是否正确的更新
			if($arr_result[$i]=='1'){
				$addtime = time();
				$insert_sql = "UPDATE mistake set exam_addtime = $addtime , exam_yichu = :yichu where username = :use_na AND exam_biaoji = :cuo AND exam_id = :id";
				$insert_content=$db->query($insert_sql,array('yichu'=>1,'use_na'=>$user['username'],'cuo'=>$cuo[$i],'id'=>$arr_id[$i]));
			}elseif($arr_result[$i]=='0'){
				$sql1111="select * from mistake where username = :use_na AND exam_biaoji = :cuo AND exam_id = :id";
				$you1=$db->row($sql1111,array('use_na'=>$user['username'],'cuo'=>$cuo[$i],'id'=>$arr_id[$i]));
				$ci=$you1['exam_number']+1;
				$insert_sql = "UPDATE mistake set exam_number = :gengxin where username = :use_na AND exam_biaoji = :cuo AND exam_id = :id";
				$insert_content=$db->query($insert_sql,array('gengxin'=>$ci,'use_na'=>$user['username'],'cuo'=>$cuo[$i],'id'=>$arr_id[$i]));
			}
		}
	}
	
	if($_SESSION['code']){
		//排行榜的修改
		$stu_good=$db->row("select * from sort where username = :user_us",array('user_us'=>$user['username']));
		$s=$stu_good['true_sum']+$fenshu;
		$sql     = "UPDATE sort SET true_sum = :true where username = :user_us";
	    $update  =  $db->query($sql,array('true'=>$s,'user_us'=>$user['username']));
	    
	    //错题的更新
	    $stu_good=$db->row("select * from sort where username = :user_us",array('user_us'=>$user['username']));
		$s1=$stu_good['false_sum']+$shu-$fenshu;
		$sql     = "UPDATE sort SET false_sum = :false where username = :user_us";
	    $update  =  $db->query($sql,array('false'=>$s1,'user_us'=>$user['username']));
	    
		//错题本的更新
		for($i=0;$i<$shu;$i++){
			if($arr_result[$i]=='0'){
				//判断错题本是否有这道题
				$sql111="select * from mistake where exam_id = :exam_id and exam_biaoji = :biaoji";
				$you=$db->row($sql111,array('exam_id'=>$arr_id[$i],'biaoji'=>$arr_biaoji));
				if(!$you){
					//如果不存在就插入这个题
					$addtime = time();
					$insert_sql = "insert into mistake ( username , exam_id , exam_addtime , exam_biaoji , exam_cuowu) VALUE ( :username ,:arr_id , $addtime , :biaoji , :cuowu)";
					$insert_content=$db->query($insert_sql,array('username'=>$user['username'],'arr_id'=>$arr_id[$i],'biaoji'=>$arr_biaoji,'cuowu'=>$arr[$i]));
				}
			}
		}
		
		//今日试题数量增加
		$stu_ti=$db->row("select * from today");
		$s=$stu_ti['shijuan_sum']+$shu;
		$sql     = "UPDATE today SET shijuan_sum = :s";
	    $update  =  $db->query($sql,array('s'=>$s));
	    
	    //考试的增加
		if($arr_biaoji==3){
			$stu_ti=$db->row("select * from today");
			$s1=$stu_ti['kaoshi_sum']+1;
			$sql1     = "UPDATE today SET kaoshi_sum = :s";
		    $update  =  $db->query($sql1,array('s'=>$s1));
		}
		
	    unset($_SESSION['code']);
		
	}
	
	
	?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
<script src="js/jquery.js" type="text/javascript"></script>
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="left_top">
				<img src="img/right.png" class="right1"/>
				<span>
					恭喜你，完成测试
				</span>
				<span>
					一共答对
					<em><?php
						echo $fenshu;
					?></em>
					题
				</span>
			</div>
			<div class="left_main">
				<span class="li_div" id="li1">
					查看详情
				</span>
				<span class="li_div" id="li2">
					继续做题
				</span>
			</div>
		</div>
		<?php include_once("view/right.php"); ?>
		<div id="left_content" style="display: none;">
			<h4>以下就是内容详情</h4>
			<div class="shijian">
				<?php
					echo "<li>";
					echo "<span class='li_span1'>";
					echo "总共用时:".shijian($time_cha);
					echo "</span>";
					echo "<span class='li_span2'>";
					echo "总共答对:".$fenshu."题";
					echo "</span>";
					echo "</li>";
				?>
				<div>
					<span class="li_span3">序号</span>
					<span class="li_span4">题目</span>
					<span class="li_span5">是否正确</span>
					<span class="li_span6">正确答案</span>
				</div>
				<?php
					for($j=0;$j<$shu;$j++){
						$i=$j+1;
						echo "<li class='li_li'>";
						echo "<span class='li_span3'>";
						echo $i.".";
						echo "</span>";
						echo "<span class='li_span4'>";
						echo $arr_chinese[$j];
						echo "</span>";
						echo "<span class='li_span5'>";
							if($arr_result[$j]=='1'){
								echo "<img src='img/success_right.jpg' class='img_1'>";
							}else{
								echo "<img src='img/success_error.jpg' class='img_1'>";
							}
						echo "</span>";
						echo "<span class='li_span6'>";
							if($arr_result[$j]=='1'){
								
							}else{
								echo $arr_xiang[$j];
							}
						echo "</span>";
						echo "</li>";
					}
				?>
			</div>
			<div class="div_main">
				<p>
					<?php
						if($arr_biaoji==4){
							echo "本次移除".$fenshu."个题";
						}else{
							echo "一共有".($shu-$fenshu)."个题插入到错题本中";
						}
					?>
				<a href="wrong_text.php">点击查看我的错题本</a></p>
			</div>
		</div>
		<?php include_once("view/footer.html"); ?>
	</div>
</body>
<script>
	
	window.onload=function(){
		//第二个按钮的监听时间
		li2.onclick=function(){
			window.location.href='test.php';
		}
		//第一个按钮的监听时间
		li1.onclick=function(){
			if(left_content.style.display=='none'){
				li1.innerHTML='隐藏详情';
				left_content.style.display='block';
				flag=false;
			}
			else{
				li1.innerHTML='查看详情';
				left_content.style.display='none';
			}
		}
		
		var oLi_li=document.getElementsByClassName('li_li');
		
		for(var i=0;i<oLi_li.length;i++){
			if(i%2==0){
				var oSpan=oLi_li[i].getElementsByTagName('span');
				oSpan[1].style.background='rgba(34, 36, 38, 0.08)';
				oSpan[3].style.background='rgba(34, 36, 38, 0.08)';
			}else{
				var oSpan=oLi_li[i].getElementsByTagName('span');
				oSpan[2].style.background='rgba(34, 36, 38, 0.08)';
				oSpan[0].style.background='rgba(34, 36, 38, 0.08)';
			}
		}
		
	}
	
</script>
