<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$keyword     = trim($_GET['keyword']);
	//分页操作
	$pageSize=5;   
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	
	$sql="select * from exam_problem where chinese like :keyword order by exam_addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql,array('keyword'=>"%$keyword%"));
	$toutal=$db->single("select count(*) from exam_problem where chinese like :keyword",array('keyword'=>"%$keyword%"));
	if($toutal==0){
		$sql="select * from exam_hot where chinese like :keyword order by exam_addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql,array('keyword'=>"%$keyword%"));
	$toutal=$db->single("select count(*) from exam_hot where chinese like :keyword",array('keyword'=>"%$keyword%"));
	}
	
	$yeshu=ceil($toutal/$pageSize);
	
	include("view/header.html");
	?>
<script type="text/javascript" src="js/function.js" ></script>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="sousuo_content">
				<h5>搜索内容:所有包含"<?php echo $keyword;?>"的内容</h5>
			</div>
			<div class="tiku_content">
					<?php if($toutal==0){
						echo '没有收到相关内容，请重新输入';
					}?>
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
							$na_id=$vo['id'];
							$xi_na=$vo['chinese'];
							echo 'Copyright@ by:'.$na;//人物
							echo "</span>";
							echo "<span class='ju1'>";
							echo "<a href='jubao.php?id=$na_id&xi_tiku=$xi_na&name=$na'>";
							echo "有问题?=-=";
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
							echo '解析:'.$vo['resolve'];
							echo "</span>";
							echo "</span>";
							echo "</div>";
							echo "</div>";
							echo '</li>';
						}
						?>
				</div>
			<?php include_once("view/seach_page.php"); ?>
		</div>
		<?php include_once("view/right.php"); ?>
	</div>
	<?php include_once("view/footer.html"); ?>
</body>
