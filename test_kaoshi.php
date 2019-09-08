<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	
	$name=$_POST['text_name'];
	if($_POST['text_name']==null){
		$name=$_GET['text_name'];
	}
	
	$sql="select * from exam_zhuanye where name = :name";
	$result=$db->query($sql,array('name'=>$name));
	$shuliang=sizeof($result);
	
	//时间
	$start_time=time();
	//确保插入语句只会呗执行一次
	$_SESSION['code'] = 3;
	
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
			<div class="xueba">学霸养成平台<span>课堂随机</span><span><a href="test.php">退出</a></span></div>
			<div class="jishi" id="jishi">
				
			</div>
			<div class="main_content_top">
				课程随机:选择题，填空题，判断题（每个题都会对应一个下拉列表，选择一个你认为正确的答案）每道题1分,共<?php echo $shuliang;?>题
			</div>
			<div class="main_content_index">
				<form action="success.php" method="post">
					<input type="hidden" name="biaoji" value="3"/>
					<input type="hidden" name="shu" value="<?php echo $shuliang;?>"/>
					<input type="hidden" name="start_time" value="<?php echo $start_time;?>"/>
					<?php
					if($shuliang=='0'){
						echo "抱歉。你选择的区间内没有题目";
					}
					for($i=0;$i<$shuliang;$i++){
						echo "<li id='$i' class='C'>";
						$ti_answer=$result[$i]['answer'];
						
						if($result[$i]['pro_type']=='1'){
							if($result[$i]['answer']=='D'){
								$ti_xiang=$result[$i]['xuanze_D'];
							}elseif($result[$i]['answer']=='B'){
								$ti_xiang=$result[$i]['xuanze_B'];
							}elseif($result[$i]['answer']=='C'){
								$ti_xiang=$result[$i]['xuanze_C'];
							}elseif($result[$i]['answer']=='A'){
								$ti_xiang=$result[$i]['xuanze_A'];
							}
						}if($result[$i]['pro_type']=='2'){
							$ti_xiang=$result[$i]['answer'];
						}if($result[$i]['pro_type']=='3'){
							if($result[$i]['answer']=='1'){
								$ti_xiang='真';
							}else{
								$ti_xiang='假';
							}
						}
						
						$ti_id=$result[$i]['id'];
						$ti_chinese=$result[$i]['content']; //修改为传递给错题本成功的页面信息
						echo "<input type='hidden' name='tianswer[]' value='$ti_answer'>";
						echo "<input type='hidden' name='xiangxi[]' value='$ti_xiang'>";//这个是正确的具体答案xiangxi
						echo "<input type='hidden' name='id[]' value='$ti_id'>";
						echo "<input type='hidden' name='chinese[]' value='$ti_chinese'>";
						echo "<div class='div1'>";
						echo "<span class='shu_span1'>";
						echo $i+1;
						echo ".";
						echo "</span>";
						echo "<span class='shu_span2'>";
						echo $result[$i]['content']."____";
						echo "</span>";
						echo "</div>";
						echo "<div class='div2'>";
						if($result[$i]['pro_type']=='1'){
							echo "<span class='shu_spanA'>";
							echo $result[$i]['xuanze_A'];
							echo "</span>";
							echo "<span class='shu_spanA'>";
							echo $result[$i]['xuanze_B'];
							echo "</span>";
							echo "<span class='shu_spanA'>";
							echo $result[$i]['xuanze_C'];
							echo "</span>";
							echo "<span class='shu_spanA'>";
							echo $result[$i]['xuanze_D'];
							echo "</span>";
						}
						echo "</div>";
						echo "<div class='div3'>";
						if($result[$i]['pro_type']=='1'){
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
						else if($result[$i]['pro_type']=='2'){
							echo "<span class='sp'>"."填空:"."</span>";
							echo "<input type='text' name='xuan[]' class='nei1' style='height:25px;width:100px;' value=' '>";
						}else if($result[$i]['pro_type']=='3'){
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
					<input type="submit" value="交卷" class="jiaojuan" id="jiao"/>
				</form>
			</div>
		</div>
	</div>
</body>
<script>
	
	function toTwo(n) {
		return n < 10 ? '0' + n : '' + n;
	}
	
	window.onload=function(){
		
		var oA=div100.getElementsByTagName('a');
		var oIn=document.getElementsByClassName('nei1');
		
		for(var i=0;i<oIn.length;i++){
			oIn[i].onclick=function(){
				oA[this.parentElement.parentElement.id].style.background='#13EBCA';
			}
		}
		//定义的考试时间
		var time=4500;
		
		var str='';
		setInterval(function(){
			
			var h=Math.floor(time/3600);
			var s=time%60;
			var m=Math.floor((time-3600*h-s)/60);
			str="记时:"+toTwo(h)+":"+toTwo(m)+":"+toTwo(s);
			
			jishi.innerHTML=str;
			time--;
			if(time==600){
				alert("距离考试结束还剩10分钟");
			}
			if(time==0){
				document.getElementById('jiao').click();
			}
			
		},1000)
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
