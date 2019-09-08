<?php
	$pai = $db->row("select * from sort where username = :user_id",array('user_id'=>$user['username']));
?>

<div class="right">
	<div class="top" style="background: url(img/my_info_bg.png);">
		<a href="homepage.php">
			<img class="info" src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" value="<?php echo $user['avatar'] ?>">
		</a>
		<h4><?php echo $user['username']?></h4>
		<div class="right_hhh">
			<ul title="正确数量">
				<li><span><?php if($pai){
					echo $pai['true_sum'];
				}else{echo 0;}?></span></li>
				<li>正确</li>
			</ul>
			<ol></ol>
			<ul title="错误数量">
				<li><span><?php if($pai){
					echo $pai['false_sum'];
				}else{echo 0;}?></span></li>
				<li>错误</li>
			</ul>
			<ol></ol>
			<ul title="正确率">
				<li><span><?php if($pai['false_sum']==0&&$pai['true_sum']==0){
					echo 0;
				}else{echo round($pai['true_sum']/($pai['true_sum']+$pai['false_sum'])*100).'%';}?></span></li>
				<li>AC率</li>
			</ul>
		</div>
	</div>
	<div class="dibu">
		<h4>个人资料</h4>
		<p>用户名<span><?php echo $user['username']?></span></p>
		<p>性别<span><?php if($user['sex']==0){echo '保密';}
						if($user['sex']==1){echo '男';} if($user['sex']==2){echo '女';}?></span></p>
		<p>qq<span><?php echo $user['qq']?></span></p>
		<p>专业班级<span><?php echo $user['class_id']?></span></p>
		<p>手机<span><?php echo $user['tel']?></span></p>
	</div>
</div>