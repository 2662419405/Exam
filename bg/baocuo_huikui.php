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
	$sql="select * from exam_baocuo order by exam_addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from exam_baocuo");
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
            	描述：报错分析
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>问题报错</h4>
            			</div>
            			<div class="box_content">
            				<table class="table__ranking_fen">
		    					<thead>
		        					<tr style="background: #f5f5f6;">
		            					<th>序号</th>
		            					<th>ID</th>
		            					<th>提交时间</th>
		            					<th>提交姓名</th>
		            					<th>提交系别</th>
		            					<th>处理状况</th>
		            					<th style="width: 100px;">操作</th>
		        					</tr>
		        				</thead>
		        				<tbody>
		        					<?php
		    							foreach($chaxun as $vo){
		    								$pai++;
		    								$yonghu_id=$vo['cuowu_id'];//id
		    								$yonghu_addtime=$vo['exam_addtime'];
		    								$yonghu_name=$vo['name'];
		    								$yonghu_xi=$vo['exam_xi'];
		    								$yonghu_zk=$vo['tongguo'];
		    							?>
		    							<tr>
		        							<td>
		        								<span><?php echo ($pai+$pageSize*($pai-1))?></span>
		        							</td>
		        							<td>
		        								<?php echo $yonghu_id?>
		        							</td>
		        							<td>
		        								<?php echo tranTime($yonghu_addtime)?>
		        							</td>
		        							<td>
		        								<?php echo $yonghu_name?>
		        							</td>
		        							<td>
		        								<?php echo $yonghu_xi?>
		        							</td>
		        							<td>
		        								<?php if($yonghu_zk==1){
		        									echo "<span style='color:red'>";
		        									echo "未处理";
		        									echo "</span>";		
		        								}elseif($yonghu_zk==2){
		        									echo "<span style='color:green'>";
		        									echo "处理完成";
		        									echo "</span>";	
		        								} ?>
		        							</td>
		        							<td>
		        								<a href="chuli_huikui.php?biaoji=3&chuli_id=<?php echo $yonghu_id?>">开始处理</a>
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