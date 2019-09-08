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
	$sql="select * from exam_problem order by exam_addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from exam_problem");
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
            	描述：试题管理
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>试题练习</h4>
            			</div>
            			<div class="box_content">
            				<div class="anniu">
            					<input type="button" id="add" />
            					<input type="button" id="delete"/>
            				</div>
            				<div class="seach_shiti">
            					<form action="seach_shiti.php" method="get">
            						<input type="text" placeholder="请输入系别" id="sou" name="keyword"  onKeyPress="if(event.keyCode==13) {document.getElementById('dianji').click();}"/>
            						<input type="hidden" name="shijuan" id="shijuan" value="1" />
            						<span class="ding">
            							<button type="submit" class="sou_button" id="dianji"></button>
            						</span>
            					</form>
            				</div>
            			</div>
            			<form action="delete_shiti.php" method="post">
            				<!--
                            	作者：2662419405@qq.com
                            	时间：2019-01-22
                            	描述：标记为哪套卷子
                            -->
            				<input type="hidden" value="1" name="biao_ji"/>
	            			<table class="table">
	            				<thead>
	            					<tr style="background: #f5f5f6;">
	            						<th style="width: 35px;">
		            						<input type="checkbox" id="allCheck"/>
		            					</th>
		            					<th>ID</th>
		            					<th>类型</th>
		            					<th>专业</th>
		            					<th>出题者</th>
		            					<th>日期</th>
		            					<th style="width: 100px;">操作</th>
	            					</tr>
	            				</thead>
	            				<tbody>
	            					<?php
	            						foreach($chaxun as $vo){
	            							$shiti_id=$vo['id'];
	            							if($vo['pro_type']==1){
	            								$shiti_type='选择题';
	            							}elseif($vo['pro_type']==2){
	            								$shiti_type='填空题';
	            							}else{
	            								$shiti_type='判断题';
	            							}
	            							$shiti_zhuanye=$vo['chinese'];
	            							$shiti_zuozhe=$vo['exam_name'];
	            							$shiti_shijian=$vo['exam_addtime'];
	            							?>
	            						<tr>
	            							<td>
	            								<input class="shanchu" type="checkbox" name="ids[]"  value="<?php echo $shiti_id?>"/>
	            							</td>
	            							<td>
	            								<?php echo $shiti_id?>
	            							</td>
	            							<td>
	            								<?php echo $shiti_type?>
	            							</td>
	            							<td>
	            								<?php echo $shiti_zhuanye?>
	            							</td>
	            							<td>
	            								<?php echo $shiti_zuozhe?>
	            							</td>
	            							<td>
	            								<?php echo date('Y-m-d',$shiti_shijian)?>
	            							</td>
	            							<td>
	            								<a href="bianji_shiti.php?biaoji=1&shiti_id=<?php echo $shiti_id?>">编辑</a>
	            								<a href="delete_danxuan.php?biaoji=1&shiti_id=<?php echo $shiti_id?>">删除</a>
	            							</td>
	            						</tr>
	            					<?}?>
	            				</tbody>
	            			</table>
	            			<input type="submit" style="display: none;" id="shan"/>
            			</form>
            			<?php include_once("bg_view/common/page.php"); ?>
            		</div>
            	</div>
            </div>
		</div>
	</div>
</body>
<script type="text/javascript">
	//全选按钮
	var oIn=document.getElementsByClassName('shanchu');
	var oDe=document.getElementById('allCheck');
	oDe.onclick=function(){
		for(var i=0;i<oIn.length;i++){
			oIn[i].checked = !oIn[i].checked;
		}
	}
	//删除按钮
	var oDelete=document.getElementById('delete');
	oDelete.onclick=function(){
		document.getElementById('shan').click();
	}
	
	add.onclick=function(){
		window.location.href='bianji_shiti.php?biaoji=1';
	}
</script>
</html>