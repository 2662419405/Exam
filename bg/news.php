<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("bg_view/header.html");
	
	//分页操作
	$pageSize=10;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from exam_news order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from exam_news");
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
            	描述：新闻页面
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>新闻一览</h4>
            			</div>
            			<div class="box_content">
            				<div class="anniu">
            					<input type="button" id="add" />
            					<input type="button" id="delete"/>
            				</div>
            			</div>
            			<form action="delete_news.php" method="post">
            				<input type="hidden" value="1" name="biao_ji"/>
	            			<table class="table__ranking_fen">
	            				<thead>
	            					<tr style="background: #f5f5f6;">
	            						<th style="width: 35px;">
		            						<input type="checkbox" id="allCheck"/>
		            					</th>
		            					<th>序号</th>
		            					<th>ID</th>
		            					<th>标题</th>
		            					<th>时间</th>
		            					<th style="width: 100px;">操作</th>
	            					</tr>
	            				</thead>
	            				<tbody>
	            					<?php
	            						foreach($chaxun as $vo){
	            							$pai++;
	            							$news_id=$vo['id'];
	            							$news_title=$vo['title'];
	            							$news_href=$vo['news_href'];
	            							$news_addtime=$vo['addtime'];
	            							?>
	            						<tr>
	            							<td style="width: 35px;">
	            								<input class="shanchu" type="checkbox" name="ids[]"  value="<?php echo $news_id?>"/>
	            							</td>
	            							<td>
	            								<?php echo ($pai+$pageSize*($pageNum-1))?>
	            							</td>
	            							<td>
	            								<?php echo $news_id?>
	            							</td>
	            							<td>
	            								<?php echo $news_title?>
	            							</td>
	            							<td>
	            								<?php echo date('Y-m-d',$news_addtime)?>
	            							</td>
	            							<td>
	            								<a href="add_news.php?news_id=<?php echo $news_id?>">编辑</a>
	            								<a href="ajaxNews.php?news_id=<?php echo $news_id?>">删除</a>
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
		window.location.href='add_news.php';
	}
</script>
</html>