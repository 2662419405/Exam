<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	$sql="select * from user order by posts_num desc limit 10";
	$chaxun = $db->query($sql);
	$pai=0;
	
	include("bg_view/header.html");
	
	?>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../layer/layer.js"></script>
<script src="js/left.js" type="text/javascript"></script>
<body>
	<div id="main">
		<?php include_once("bg_view/common/left.php"); ?>
		<div id="page_wrapper">
			<?php include_once("bg_view/common/head.php"); ?>
			<!--
            	作者：2662419405@qq.com
            	时间：2019-01-20
            	描述：发帖排名
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>发帖排名</h4>
            			</div>
            			<div class="box_content">
            				<table class="table__ranking_fen">
            					<thead>
	            					<tr style="background: #f5f5f6;">
		            					<th>排名</th>
		            					<th>ID</th>
		            					<th>姓名</th>
		            					<th>发帖数量</th>
		            					<th>粉丝数量</th>
		            					<th>关注数量</th>
		            					<th style="width: 100px;">操作</th>
	            					</tr>
	            				</thead>
            					<tbody>
            						<?php
            							foreach($chaxun as $vo){
            								$pai++;
            								$yonghu_id=$vo['id'];//id
            								$yonghu_name=$vo['username'];//name
            								$yonghu_post=$vo['posts_num'];//粉丝
            								$yonghu_fen=$vo['fans_num'];
            								$yonghu_follow=$vo['follows_num'];
            							?>
            							<tr>
	            							<td>
	            								<span><?php echo "NO.".$pai?></span>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_id?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_name?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_post?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_fen?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_follow?>
	            							</td>
	            							<td>
	            								<a href="geren.php?yonghu_id=<?php echo $yonghu_id?>">他的资料</a>
	            							</td>
	            						</tr>
            							
            							<?
            							}
            							?>
            					</tbody>
            				</table>
            			</div>
            		</div>
            	</div>
            </div>
       </div>
    </div>
</body>
</html>