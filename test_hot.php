<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	//验证是否位数字
	$shuliang=$_POST['chuti_shuliang'];
	$n=$db->query("select count(*) from exam_hot");
	if(!(intval($shuliang))){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('题目请输入数字');window.location.href='test.php';</script>";
	}
	if($shuliang>=$n[0]['count(*)']){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('数量超过题库数量');window.location.href='test.php';</script>";
	}
	if($shuliang>'30'){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('题量过大，最多为30个题');window.location.href='test.php';</script>";
	}
	//接受参数
	$xibie=$_POST['chuti_xibie'];
	//验证是否存在这个老师
	$name=$_POST['chuti_name'];
	$sql_name  = "select username from user where level=2 AND username =:user";
    $name1 = $db->row($sql_name,array('user'=>$name));
    if((!$name1)&&$name!='全部'){
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('这个老师不存在');window.location.href='test.php';</script>";
    }
	$shijian=$_POST['chuti_shijian'];
	$jiezhi=$_POST['chuti_jiezhi'];
	if($jiezhi<=$shijian){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('截止时间大于或等于出题时间');window.location.href='test.php';</script>";
	}
	$xuanxiang=$_POST['chuti_xuanxiang'];
	
	if(($name=='全部')&&($xibie=='全部')&&($xuanxiang==0)){
		$sql="select * from exam_hot where exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}
	else if(($name=='全部')&&($xibie=='全部')){
		$sql="select * from exam_hot where pro_type =:xuanxiang and exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('xuanxiang'=>$xuanxiang,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}
	else if(($xibie=='全部')&&($xuanxiang==0)){
		$sql="select * from exam_hot where exam_name =:name and exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('name'=>$name,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}
	else if(($name=='全部')&&($xuanxiang==0)){
		$sql="select * from exam_hot where chinese =:xibie and exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('xibie'=>$xibie,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}elseif($name=='全部'){
		$sql="select * from exam_hot where chinese =:xibie and pro_type =:type and exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('xibie'=>$xibie,'type'=>$xuanxiang,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}elseif($xuanxiang==0){
		$sql="select * from exam_hot where chinese =:xibie and exam_name =:name and exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('xibie'=>$xibie,'name'=>$name,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}elseif($xibie=='全部'){
		$sql="select * from exam_hot where pro_type =:type and exam_name =:name and exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('type'=>$xuanxiang,'name'=>$name,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}else{
		$sql="select * from exam_hot where chinese =:xibie and pro_type =:type and exam_name =:name and exam_addtime between :shijian and :jiezhi";
		$re=$db->query($sql,array('xibie'=>$xibie,'type'=>$xuanxiang,'name'=>$name,'shijian'=>$shijian,'jiezhi'=>$jiezhi));
	}
	
	if($re==null){
		$shuliang=0;
	}
	
	if($shuliang!=0){
		shuffle($re);
		$result=array_slice($re,0,$shuliang);
	}
	
	//时间
	$start_time=time();
	//确保插入语句只会呗执行一次
	$_SESSION['code'] = 2;
	
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
			<div class="main_content_top">
				课程随机:选择题，填空题，判断题（每个题都会对应一个下拉列表，选择一个你认为正确的答案）每道题1分,共<?php echo $shuliang;?>题
			</div>
			<div class="main_content_index">
				<form action="success.php" method="post">
					<input type="hidden" name="biaoji" value="2"/>;
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
						$ti_chinese=$result[$i]['content'];
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

