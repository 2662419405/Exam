<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	$sql="select * from sort order by true_sum desc limit 10";
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
            	描述：正确排名
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>正确排名</h4>
            			</div>
            			<div class="box_content">
            				<table class="table__ranking_fen">
            					<thead>
	            					<tr style="background: #f5f5f6;">
		            					<th>排名</th>
		            					<th>ID</th>
		            					<th>姓名</th>
		            					<th>专业班级</th>
		            					<th>正确</th>
		            					<th>AC率</th>
		            					<th style="width: 100px;">操作</th>
	            					</tr>
	            				</thead>
            					<tbody>
            						<?php
            							foreach($chaxun as $vo){
            								$pai++;
            								$yonghu_id=$vo['id'];//id
            								$yonghu_name=$vo['username'];//name
            								$yonghu_banji=$vo['class_id'];
            								$yonghu_true=$vo['true_sum'];
            								$yonghu_false=$vo['false_sum'];
            								$yonghu_user_id=$vo['user_id'];
            							?>
            							<tr>
	            							<td>
	            								<span><?php echo "NO.".$pai?></span>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_user_id?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_name?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_banji?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_true?>
	            							</td>
	            							<td>
	            								<?php if($yonghu_true==0&&$yonghu_false==0){
	            									echo "0%";			
	            								}else{
	            									echo round($yonghu_true/($yonghu_true+$yonghu_false)*100)."%";
	            								} ?>
	            							</td>
	            							<td>
	            								<a href="geren.php?yonghu_id=<?php echo $yonghu_user_id?>">他的资料</a>
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