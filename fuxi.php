<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	//验证是否位数字
	$sql="select count(*) from mistake where username = :name";
	$shuliang=$db->query($sql,array('name'=>$_SESSION['user']['username']));
	if($shuliang>=30){
		$shuliang=30;
	}
	
	//遍历错题的id
	$sql1="select * from mistake where username = :name";
	$re=$db->query($sql1,array('name'=>$_SESSION['user']['username']));
	
	if($shuliang!=0){
		shuffle($re);
		$result=array_slice($re,0,$shuliang);
	}
	
	//时间
	$start_time=time();
	
	?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<a name='top'></a>
	<?php include_once("view/head.html"); ?>
	<div class="main" style="margin-bottom: 20px;">
		<div class="main_content">
			<ul class="main_li" id="div100" 
				style="display:<?php if($shuliang==0){echo 'none';}else{echo 'block';}?>;">
				<?php
					for($i=0;$i<$shuliang;$i++){
						echo "<li>";
						echo "<a class='A' href='#$i'>";
						echo $i+1;
						echo "</a>";
						echo "</li>";
					}
				?>
			</ul>
			<div class="main_top">
				<a href="#top" id="btn" title="回到卷首" name="top" style="display: none;">^</a>
			</div>
			<div class="xueba">学霸养成平台<span>错题复习</span><span><a href="wrong_text.php">退出</a></span></div>
			<div class="main_content_top">
				错题复习:选择题，填空题，判断题（每个题都会对应一个下拉列表，选择一个你认为正确的答案）每道题1分,共<?php echo $shuliang;?>题
			</div>
			<div class="main_content_index">
				<form action="success.php" method="post">
					<input type="hidden" name="biaoji" value="4"/>
					<input type="hidden" name="shu" value="<?php echo $shuliang;?>"/>
					<input type="hidden" name="start_time" value="<?php echo $start_time;?>"/>
					<?php
					if($shuliang=='0'){
						echo "抱歉。你没有错题";
					}
					for($i=0;$i<$shuliang;$i++){
						echo "<li id='$i' class='C'>";
						if($result[$i]['exam_biaoji']=='1'){
							$ti_content = $db->row("select * from exam_problem where id = :ti_id",array('ti_id'=>$result[$i]['exam_id']));
						}
						elseif($result[$i]['exam_biaoji']=='2'){
							$ti_content = $db->row("select * from exam_hot where id = :ti_id",array('ti_id'=>$result[$i]['exam_id']));
						}elseif($result[$i]['exam_biaoji']=='3'){
							$ti_content = $db->row("select * from exam_zhuanye where id = :ti_id",array('ti_id'=>$result[$i]['exam_id']));
						}
						$cuo=$result[$i]['exam_biaoji'];
						$ti_answer=$ti_content['answer'];
						$ti_id=$ti_content['id'];
						$ti_chinese=$ti_content['content'];
						
						if($ti_content['pro_type']=='1'){
							if($ti_content['answer']=='D'){
								$ti_xiang=$ti_content['xuanze_D'];
							}elseif($ti_content['answer']=='B'){
								$ti_xiang=$ti_content['xuanze_B'];
							}elseif($ti_content['answer']=='C'){
								$ti_xiang=$ti_content['xuanze_C'];
							}elseif($ti_content['answer']=='A'){
								$ti_xiang=$ti_content['xuanze_A'];
							}
						}if($ti_content['pro_type']=='2'){
							$ti_xiang=$ti_content['answer'];
						}if($ti_content['pro_type']=='3'){
							if($ti_content['answer']=='1'){
								$ti_xiang='真';
							}else{
								$ti_xiang='假';
							}
						}
						
						echo "<input type='hidden' name='tianswer[]' value='$ti_answer'>";
						echo "<input type='hidden' name='xiangxi[]' value='$ti_xiang'>";//这个是正确的具体答案xiangxi
						echo "<input type='hidden' name='id[]' value='$ti_id'>";
						echo "<input type='hidden' name='chinese[]' value='$ti_chinese'>";
						echo "<input type='hidden' name='cuo[]' value='$cuo'>";
							
						echo "<div class='div1'>";
						echo "<span class='shu_span1'>";
						echo $i+1;
						echo ".";
						echo "</span>";
						echo "<span class='shu_span2'>";
						echo$ti_content['content']."____";
						echo "</span>";
						echo "</div>";
						echo "<div class='div2'>";
						if($ti_content['pro_type']=='1'){
							echo "<span class='shu_spanA'>";
							echo $ti_content['xuanze_A'];
							echo "</span>";
							echo "<span class='shu_spanA'>";
							echo $ti_content['xuanze_B'];
							echo "</span>";
							echo "<span class='shu_spanA'>";
							echo $ti_content['xuanze_C'];
							echo "</span>";
							echo "<span class='shu_spanA'>";
							echo $ti_content['xuanze_D'];
							echo "</span>";
						}
						echo "</div>";
						echo "<div class='div3'>";
						if($ti_content['pro_type']=='1'){
							echo "<span class='sp'>"."单选:"."</span>";
							echo "<select name='xuan[]' class='nei1'>";
							echo "<option value=' '>";
							echo " ";
							echo "</option>";
							echo "<option value='A'>";
							echo "A";
							echo "</option>";
							echo "<option value='B'>";
							echo "B";
							echo "</option>";
							echo "<option value='C'>";
							echo "C";
							echo "</option>";
							echo "<option value='D'>";
							echo "D";
							echo "</option>";
							echo "</select>";
						}
						else if($ti_content['pro_type']=='2'){
							echo "<span class='sp'>"."填空:"."</span>";
							echo "<input type='text' name='xuan[]' class='nei1' style='height:25px;width:100px;' value=' '>";
						}else if($ti_content['pro_type']=='3'){
							echo "<span class='sp'>"."判断:"."</span>";
							echo "<select name='xuan[]' class='nei1'>";
							echo "<option value=' '>";
							echo " ";
							echo "</option>";
							echo "<option value='1'>";
							echo "正确";
							echo "</option>";
							echo "<option value='0'>";
							echo "错误";
							echo "</option>";
							echo "</select>";
						}
						echo "</div>";
						echo "</li>";
					}
					?>
					<input type="submit" value="交卷" class="jiaojuan"/>
				</form>
			</div>
		</div>
	</div>
	<?php include_once("view/footer.html"); ?>
</body>
<script>
	
	window.onload=function(){
		
		var oA=div100.getElementsByTagName('a');
		var oIn=document.getElementsByClassName('nei1');
		
		for(var i=0;i<oIn.length;i++){
			oIn[i].onclick=function(){
				oA[this.parentElement.parentElement.id].style.background='#13EBCA';
			}
		}
		
	}
	
	window.onscroll=function(){
		
		//考试页面的左侧列表滑动
		var oDiv=document.getElementById('div100');
		var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
		var t=scrollTop+(document.documentElement.clientHeight-oDiv.offsetHeight)/2;
		
		var topbtn = document.getElementById("btn");
    	var pagelookheight = document.documentElement.clientHeight;
		
		startMove(t);
		
        if(scrollTop >= pagelookheight){	
            topbtn.style.display = "block";
        }else{
            topbtn.style.display = "none";
        }
	}	
	
	var timer=null;
	
	function startMove(target){
		
		target=Math.ceil(target);
		
		var oDiv=document.getElementById('div100');
		
		clearInterval(timer);
		timer=setInterval(function(){
			
			var iSpeed=(target-oDiv.offsetTop)/5;
			iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed);
			
			if(oDiv.offsetTop==target){
				
				clearInterval(timer);
				
			}
			else{
				
				oDiv.style.top=oDiv.offsetTop+iSpeed+'px';
				
			}
			
		},30)
		
	}
	
</script>
