<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("bg_view/header.html");
	
	//分页操作
	$pageSize=15;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from fankui order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from fankui");
	$yeshu=ceil($toutal/$pageSize);
	
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
            	描述：用户回馈
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>用户回馈意见</h4>
            			</div>
            			<div class="box_content">
            				<table class="table__ranking_fen">
		    					<thead>
		        					<tr style="background: #f5f5f6;">
		            					<th>序号</th>
		            					<th>ID</th>
		            					<th style="text-align: center;">内容</th>
		            					<th>姓名</th>
		            					<th>时间</th>
		            					<th style="width: 100px;">操作</th>
		        					</tr>
		        				</thead>
		        				<tbody>
		        					<?php
		    							foreach($chaxun as $vo){
		    								$pai++;
		    								$yonghu_id=$vo['id'];//id
		    								$yonghu_content=$vo['content'];
		    								$yonghu_name=$vo['user_name'];
		    								$yonghu_addtime=$vo['addtime'];
		    							?>
		    							<tr>
		        							<td>
		        								<span><?php echo ($pai+$pageSize*($pai-1))?></span>
		        							</td>
		        							<td>
		        								<?php echo $yonghu_id?>
		        							</td>
		        							<td style="max-width: 500px;">
		        								<?php echo $yonghu_content?>
		        							</td>
		        							<td>
		        								<?php echo $yonghu_name?>
		        							</td>
		        							<td>
		        								<?php echo tranTime($yonghu_addtime)?>
		        							</td>
		        							<td>
		        								<a href="chuli_huikui.php?biaoji=2&chuli_id=<?php echo $yonghu_id?>">点击查看</a>
		        							</td>
		        						</tr>
		    							<?
		    							}
		    							?>
		        				</tbody>
		        			</table>
            			</div>
	        			<?php include_once("bg_view/common/page.php"); ?>
            		</div>
            	</div>
            	
            </div>
		</div>
	</div>
</body>
</html>