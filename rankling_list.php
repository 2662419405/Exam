<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$pageSize=20;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from sort order by true_sum desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from sort");
	$yeshu=ceil($toutal/$pageSize);
	$paiming=1;
	include("view/header.html");
	?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="ranking_list">
				<div class="paihangbang">
					排行榜
				</div>
				<div class="rankling_list_top">
					<span class="rankling_paiming">排名</span>
					<span class="rankling_yonghu">用户</span>
					<span class="rankling_ID">ID</span>
					<span class="rankling_jiejue">解决</span>
					<span class="rankling_cuowu">错误</span>
					<span class="rankling_AC">AC率</span>
				</div>
				<div class="rankling_list_bottom">
					<ul class="rankling_ul">
						<?php foreach($chaxun as $vo){
							$zi_id=$vo['user_id'];
							echo "<a href='homepage.php?friend_id=$zi_id'>".'<li>'.'<span>'.($paiming+$pageSize*($pageNum-1));
							if(($paiming+$pageSize*($pageNum-1))==1){
								echo "<img src='img/bang3.jpg' class='rankling_img1'>";
							}else if(($paiming+$pageSize*($pageNum-1))==2){
								echo "<img src='img/bang1.jpg' class='rankling_img1'>";}
									else if(($paiming+$pageSize*($pageNum-1))==3){
								echo "<img src='img/bang2.jpg' class='rankling_img1'>";}
							echo '</span>';
							echo '<span>';
							echo $vo['username'];
							if(($paiming+$pageSize*($pageNum-1))==1){
								echo '(孤独求败)';
							}else if(($paiming+$pageSize*($pageNum-1))==2){
								echo '(千年老二)';
							}else if(($paiming+$pageSize*($pageNum-1))==3){
								echo '(榜上有名)';
							}
							else if((($paiming+$pageSize*($pageNum-1))>3)&&(($paiming+$pageSize*($pageNum-1))<=10)){
							echo 	'(精英)';
							}
							echo '</span>';
							echo '<span>'.$vo['id'].'</span>';
							echo '<span>'.$vo['true_sum'].'</span>';
							echo '<span>'.$vo['false_sum'].'</span>';
							if(($vo['true_sum']==0)&&($vo['false_sum']==0)){
								echo '<span>'.'0'.'%'.'</span>';	
							}
							else{
								echo '<span>'.round($vo['true_sum']/($vo['true_sum']+$vo['false_sum'])*100).'%'.'</span>';
							};
							echo '<span>'.$vo['addtime'].'</span>'.'</li>'."</a>";
							$paiming++;
						}?>
					</ul>
				</div>
			</div>
			<?php include_once("view/page.php"); ?>
		</div>
		<?php include_once("view/right.php"); ?>
		<?php include_once("view/footer.html"); ?>
	</div>
</body>
