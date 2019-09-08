<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	//分页操作
	$pageSize=20;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$keyword     = trim($_GET['keyword']);
	
	$sql="select * from user where username like :keyword order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql,array('keyword'=>"%$keyword%"));
	$toutal=$db->single("select count(*) from user where username like :keyword",array('keyword'=>"%$keyword%"));
	
	$yeshu=ceil($toutal/$pageSize);
	//数据查询
	$jinri = $db->row("select * from today where id=1");
	include("view/header.html");
	?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="re_teacher_left_top">
				<img src="img/jin.jpg" />
				考试:
				<em><?php echo $jinri['kaoshi_sum']?></em>
				<span>|</span>
				注册:
				<em><?php echo $jinri['zhuche_sum']?></em>
				<span>|</span>
				做题:
				<em><?php echo $jinri['shijuan_sum']?></em>
				<span>|</span>
				互助:
				<em><?php echo $jinri['laoshi_sum']?></em>
				<div class="teacher_top_right1">
					全部成员参与的活动数量
				</div>
			</div>
			<div class="re_teacher_sousuo">
				<p>用户列表</p>
				<div class="youbian">
					<form action="search_cy.php" method="get">
						<input type="text" id="sou_yonghu" name="keyword" placeholder="输入用户姓名" class="sou_yonghu" onKeyPress="if(event.keyCode==13) {document.getElementById('tijiao_cy').click();}">
						<input type="button" id="sou_yonghu1" class="sou_yonghu1" style="background: url(img/sou.png);" onclick="document.getElementById('tijiao_cy').click();"/>
						<input type="submit" id="tijiao_cy" hidden="hidden"/>
					</form>
				</div>
			</div>
			<div class="re_top">
				<span>注册时间</span>
				<span>姓名</span>
				<span>QQ</span>
				<span>Tel</span>
				<span>性别</span>
			</div>
			<div id="re_teacher">
				<ul class="re_teacher_yonghu">
					<?php
						foreach($chaxun as $vo){
							$zi_id=$vo['id'];
							echo "<a href='homepage.php?friend_id=$zi_id'>"."<li>"."<span>";
							echo tranTime($vo['addtime']);
							echo '</span>';
							echo '<span>';
							$xianzai=time();
							echo $vo['username'];
							if(($xianzai-$vo['addtime'])<108000){
								echo '(初来乍到)';
							}else if(($xianzai-$vo['addtime'])<252000){
								echo '(锋芒毕露)';
							}else if(($xianzai-$vo['addtime'])<1080000){
								echo '(出类拔萃)';
							}
							else {
							echo 	'(人在江湖)';
							}
							echo '</span>';
							echo '<span>';
							if($vo['qq']==null){
								echo '保密';
							}else{
								echo $vo['qq'];
							}
							echo '</span>';
							echo '<span>';
							if($vo['tel']==null){
								echo '保密';
							}else{
								echo $vo['tel'];
							}
							echo '</span>';
							echo '<span>';
							if($vo['sex']==0){
								echo '保密';
							}else if($vo['sex']==1){
								echo '男';
							}else{
								echo '女';
							}
							echo '</span>'.'</li>'.'</a>';
						}
					?>
				</ul>
			</div>
			<?php include_once("view/cy_page.php");?>
		</div>
		<?php include_once("view/right.php"); ?>
		<?php include_once("view/footer.html"); ?>
	</div>
</body>
