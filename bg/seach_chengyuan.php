<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	include("bg_view/header.html");
	$keyword= trim($_GET['keyword']);
	
	//分页操作
	$pageSize=15;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	
	$sql="select * from user where username like :keyword order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	
	$chaxun = $db->query($sql,array('keyword'=>"%$keyword%"));
	
	$toutal=$db->single("select count(*) from user where username like :keyword",array('keyword'=>"%$keyword%"));
	
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
            	描述：注册用户
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>注册用户</h4>
            			</div>
            			<div class="box_content">
            				<div class="seach_shiti">
            					<form action="seach_chengyuan.php" method="get" style="margin-left: 38%;">
            						<input type="text" placeholder="请输入姓名" id="sou" name="keyword"/>
            						<span class="ding">
            							<button type="submit" class="sou_button"></button>
            						</span>
            					</form>
            				</div>
            			</div>
            				<!--
                            	作者：2662419405@qq.com
                            	时间：2019-01-22
                            	描述：标记为哪套卷子
                            -->
	            			<table class="table__ranking_fen">
	            				<thead>
	            					<tr style="background: #f5f5f6;">
	            						<th>序号</th>
		            					<th>ID</th>
		            					<th>姓名</th>
		            					<th>注册时间</th>
		            					<th>粉丝</th>
		            					<th>班级</th>
		            					<th>QQ</th>
		            					<th style="width: 100px;">查看</th>
	            					</tr>
	            				</thead>
	            				<tbody>
	            					<?php
	            						foreach($chaxun as $vo){
	            							$paiming++;
	            							$yonghu_id=$vo['id'];
	            							$yonghu_name=$vo['username'];
	            							$yonghu_addtime=$vo['addtime'];
	            							$yonghu_fen=$vo['fans_num'];
	            							$yonghu_ban=$vo['class_id'];
	            							$yonghu_qq=$vo['qq'];
	            							?>
	            						<tr>
	            							<td>
	            								<?php echo ($paiming+$pageSize*($pageNum-1))?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_id?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_name?>
	            							</td>
	            							<td>
	            								<?php echo date('Y-m-d',$yonghu_addtime)?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_fen?>
	            							</td>
	            							<td>
	            								<?php if($yonghu_ban==null){
	            									echo "未知";
	            								}else{
	            									echo $yonghu_ban;
	            								}?>
	            							</td>
	            							<td>
	            								<?php if($yonghu_qq==null){
	            									echo "未知";
	            								}else{
	            									echo $yonghu_qq;
	            								}?>
	            							</td>
	            							<td>
	            								<a href="geren.php?yonghu_id=<?php echo $yonghu_id?>">他的资料</a>
	            							</td>
	            						</tr>
	            					<?}?>
	            				</tbody>
	            			</table>
            			<?php include_once("bg_view/common/ch_page.php"); ?>
            		</div>
            	</div>
            </div>
		</div>
	</div>
</body>
</html>