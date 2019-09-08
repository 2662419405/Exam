<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	include("bg_view/header.html");
	
	$news_id=$_GET['news_id'];
	
	if($news_id==null){
		$chaxun=null;
	}else{
		
		$sql="select * from exam_news where id =:s";
		$chaxun=$db->query($sql,array('s'=>$news_id));
		
	}
	
	$toutal=$db->single("select count(*) from exam_news where height = 0");
	
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
            	描述：编辑页面
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4><?php if($chaxun==null){
            					echo "新增";
            				}else{
            					echo "编辑";
            				}?>新闻</h4>
            			</div>
            			<div class="box_content">
            				<form action="tijiao_news.php" method="post" class="shiti_top">
            					<div class="form_group">
            						<label class="clo_sm">
            							新闻标题&nbsp;:
            						</label>
            						<div class="clo_sm_2">
            							<input type="text" name="news_title" value="<?php echo $chaxun[0]['title']?>"/>
            						</div>
            					</div>
            					<div class="form_group">
            						<label class="clo_sm">
            							新闻超链接&nbsp;:
            						</label>
            						<div class="clo_sm_2">
            							<input type="text" name="news_href" value="<?php echo $chaxun[0]['news_href']?>"/>
            						</div>
            					</div>
            					<div class="form_group">
            						<label class="clo_sm">
            							首页推荐&nbsp;:
            						</label>
            						<div class="clo_sm_2">
            							<select name="news_height">
            								<option value="1">不推荐</option>
            								<option value="0">推荐</option>
            							</select>
            							<span style="color: orange;"><?php if($chaxun[0]['height']==0){
            								echo "此新闻已经被推荐"."(当前共有$toutal)";
            							}else{
            								echo "此新闻没有被推荐"."(当前共有$toutal)";
            							}?></span>
            						</div>
            					</div>
            					<div class="form_group">
            						<div class="clo_sm_3">
            							<!--
                                        	作者：2662419405@qq.com
                                        	时间：2019-01-22
                                        	描述：如果标记为1表示新增，标记为2表示修改
                                        -->
            							<input type="hidden" name="biaoji" id="biaoji" value="<?php if($chaxun==null){
            								echo 1;
            							}else{
            								echo 2;
            							}?>" />
            							<input type="hidden" name="news_id" id="news_id" value="<?php echo $news_id?>" />
		            					<input type="submit" value="提交" class="shiti_tijiao" id="tijiao"/>
	            					</div>
            					</div>
            				</form>
            			</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</body>
</html>            				