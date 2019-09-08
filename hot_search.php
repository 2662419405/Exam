<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$xi_tiku=empty($_GET['xi_tiku'])?0:$_GET['xi_tiku'];
	//分页操作
	$pageSize=5;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from exam_hot where chinese = :xi_tiku order by exam_addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	if($xi_tiku=='全部'){
		$chaxun=$db->query("select * from exam_hot order by exam_addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize);
		$toutal=$db->single("select count(*) from exam_hot");
	}
	else{
		$chaxun = $db->query($sql,array('xi_tiku'=>"$xi_tiku"));
		$toutal=$db->single("select count(*) from exam_hot where chinese = :xi_tiku",array('xi_tiku'=>"$xi_tiku"));
	}
	$yeshu=ceil($toutal/$pageSize);
	
	include("view/header.html");
	?>
<script type="text/javascript" src="js/function.js" ></script>	
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="re_teacher_sousuo">
				<p>题库列表</p>
				<!--<div class="youbian">
					<input type="text" id="sou_tiku" placeholder="输入题目编号" class="sou_yonghu">
					<input type="button" id="sou_tiku1" class="sou_yonghu1" style="background: url(img/sou.png);"/>
				</div>-->
			</div>
			<div class="tiku_xuanze">
				<div class="tiku_xuanze_left">
					<form action="hot_search.php" method="get">
						<p>选择你想要的专业</p>
						<select name="xi_tiku" class="xi_tiku">
						<optgroup label="全部">
								<option value="全部">全部</option>
							</optgroup>
							<optgroup label="专升本">
								<option value="高数">高数</option>
								<option value="英语">英语</option>
								<option value="有机化学">有机化学</option>
								<option value="无机化学">无机化学</option>
								<option value="管理学">管理学</option>
								<option value="精读英语">精读英语</option>
								<option value="泛读英语">泛读英语</option>
								<option value="公共英语">公共英语</option>
								<option value="艺术概论">艺术概论</option>
							</optgroup>
							<optgroup label="英语">
								<option value="英语三级半">英语三级半</option>
								<option value="英语四级">英语四级</option>
							</optgroup>
							<optgroup label="计算机">
								<option value="办公国二">办公国二</option>
								<option value="c语言国二">c语言国二</option>
								<option value="省二c语言">省二c语言</option>
								<option value="省二vb">省二vb</option>
							</optgroup>
							<optgroup label="证书">
								<option value="导游证">导游证</option>
								<option value="初级会计">初级会计</option>
								<option value="教师资格证">教师资格证</option>
							</optgroup>
					</select>
					<input type="submit" class="genggai" id="genggai" value="更改">
					</form>		
				</div>
				<div class="tiku_content">
						<?php
						foreach($chaxun as $vo){
							$paiming++;
							echo '<li>';
							echo "<div class='tiku_content'>";
							echo "<div class='tiku_content_left'>";
							echo ($paiming+$pageSize*($pageNum-1));//排行榜
							if($vo['pro_type']==1){
								echo '选择题';
							}else if($vo['pro_type']==2){
								echo '填空题';
							}else{
								echo '判断题';
							}
							echo "<span class='tiku_addtime'>";
							echo '题库发布于:'.tranTime($vo['exam_addtime']);//时间
							echo "</span>";
							echo "<span class='tiku_name'>";
							$na=$vo['exam_name'];
							$xi_na=$vo['chinese'];
							$na_id=$vo['id'];
							echo 'Copyright@ by:'.$na;//时间
							echo "</span>";
							echo "<span class='ju1'>";
							echo "<a href='jubao.php?id=$na_id&xi_tiku=$xi_na&name=$na&biaoji=2'>";
							echo "题目有错?=-=";
							echo "</a>";
							echo "</span>";
							echo "<span class='tiku_span'>";
							echo ($paiming+$pageSize*($pageNum-1)).'/'.$toutal;
							echo "</span>";
							echo "</div>";
							echo "<div class='tiku_main'>";
							echo '【'.($paiming+$pageSize*($pageNum-1)).'】';
							echo $vo['content'];//考题
							echo "<span class='tiku_content1'>";
							if($vo['pro_type']==1){
								echo $vo['xuanze_A'];
							}
							echo "</span>";
							echo "<span class='tiku_content2'>";
							if($vo['pro_type']==1){
								echo $vo['xuanze_B'];
							}
							echo "</span>";
							echo "<span class='tiku_content3'>";
							if($vo['pro_type']==1){
								echo $vo['xuanze_C'];
							}
							echo "</span>";
							echo "<span class='tiku_content4'>";
							
							if($vo['pro_type']==1){
								echo $vo['xuanze_D'];
							}
							echo "</span>";
							echo "<input type='button' value='查看答案' value='' id='input_$paiming' onclick='kaishi($paiming)' class='daan'>";
							echo "<span class='tiku_s' id='ti_$paiming'>";
							echo "<span class='tiku_content5'>";
							echo '答案:';
							if($vo['pro_type']==3){
								if($vo['answer']=='1'){
									echo '正确';
								}
								else{
									echo '错误';
								}
							}else{
								echo $vo['answer'];
							}
							echo "</span>";
							echo "<span class='tiku_content6'>";
							echo $vo['resolve'];
							echo "</span>";
							echo "</span>";
							echo "</div>";
							echo "</div>";
							echo '</li>';
						}
						?>
				</div>
			</div>
			<?php include_once("view/ti_page.php"); ?>
		</div>
		<?php include_once("view/right.php"); ?>
		<?php include_once("view/footer.html"); ?>
	</div>
</body>
