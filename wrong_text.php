<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	
	//分页操作
	$pageSize=10;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from mistake where exam_yichu = 0 order by exam_addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from mistake where exam_yichu = 0");
	$yeshu=ceil($toutal/$pageSize);
	
	//移除数量
	$yichu=$db->single("select count(*) from mistake where exam_yichu = 1");
	
	//搜索全部的题
	$ti_suiji=$db->query("select * from exam_problem");
	$ti_hot=$db->query("select * from exam_hot");
	
	//用于循环
	$pai=0;
	
	?>
<script type="text/javascript" src="js/jquery.js"></script>	
<script type="text/javascript" src="layer/layer.js"></script>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="wrong_top" style="background: url(img/wrong_bg.jpg) no-repeat center center;">
				<div class="wai_qiu">
					<div class="nei_qiu">
						<p><strong><?php echo $toutal;?></strong><br /><span>错题数</span></p>
					</div>
				</div>
			</div>
			<div class="wrong_main">
				<form method="post" action="ajaxDelete.php">
					<div class="wrong_content">
						<div class="wrong_main_left">
							<input type="button" id="quanxuan" value="全选"/>
						</div>
						<div class="wrong_main_right">
							<input type="button" id="fanxuan" value="反选"/>
							<span>|</span>
							<input type="submit" name="delete" id="delete" value="删除" />
						</div>
					</div>
					<div class="wrong_index" id="wrong_index">
						<?php
							foreach($chaxun as $vo){
								$id=$vo['exam_id'];
								echo "<div id='div_wrong$pai' class='div_wrong'>";
								echo "<input  value='$id' type='checkbox' name='check[]' class='check_xuan'>";
								echo "<span class='wrong_span1'>";
								echo tranTime($vo['exam_addtime']);
								echo "</span>";
								echo "<span class='wrong_span2'>";
								
								$biaoji=$vo['exam_biaoji'];
								echo "<input type='hidden' value='$id' name='wrong_id[]'id='cuowu_$pai'>";
								echo "<input type='hidden' name='biao_ji[]' value='$biaoji'>";
								if($vo['exam_biaoji']=='1'){
									$ti_content = $db->row("select * from exam_problem where id = :ti_id",array('ti_id'=>$id));				
								}
								elseif($vo['exam_biaoji']=='2'){
									$ti_content = $db->row("select * from exam_hot where id = :ti_id",array('ti_id'=>$id));
								}else{
									$ti_content = $db->row("select * from exam_zhuanye where id = :ti_id",array('ti_id'=>$id));
								}
								echo "累计做错:".$vo['exam_number'];
								echo "</span>";
								echo "<span class='wrong_span3'>";
								echo "出题者:".$ti_content['exam_name'];
								echo "</span>";
								echo "<span class='wrong_span4444'>";
								echo "<a href='ajaxDelete.php?check1=$id&biao_ji1=$biaoji'>删除此题</a>";
								echo "</span>";
								if($vo['exam_biaoji']==3){
									echo "<div class='ttt'>";
									echo "来自试卷:".$ti_content['name'];		
									echo "</div>";
								}
								echo "<div class='wrong_111' id='div_shiti_$pai' style='display:block; margin-left:50px;'>";
								echo "<span class='text_span7'>";
								echo $ti_content['content'];
								if($ti_content['pro_type']=='2'){
									echo "填空";
								}elseif($ti_content['pro_type']=='3'){
									echo "判断";
								}
								echo "</span>";
								if($ti_content['pro_type']=='1'){
									echo "<span class='text_span1'>";
									echo $ti_content['xuanze_A'];
									echo "</span>";
									echo "<span class='text_span2'>";
									echo $ti_content['xuanze_B'];
									echo "</span>";
									echo "<span class='text_span3'>";
									echo $ti_content['xuanze_C'];
									echo "</span>";
									echo "<span class='text_span4'>";
									echo $ti_content['xuanze_D'];
									echo "</span>";
								}
								echo "</div>";
								echo "<div class='wrong_11'>";
								echo "<span class='wrong_s2' onclick='jiexi($pai)' id='span_jiexi_$pai'>";
								echo "查看答案";
								echo "</span>";
								echo "<span class='wrong_s2' onclick='daan($pai)' id='span_daan_$pai'>";
								echo "整理笔记";
								echo "</span>";
								echo "</div>";
								echo "<div class='wrong_111' id='div_daan_$pai' style='display:none; margin-left:50px;'>";
								echo "<span class='text_span5'>";
								echo "正确答案是:";
								if($ti_content['pro_type']=='3'){
									if($vo['exam_cuowu']=='1'){
										echo "对";
									}else{
										echo "错";
									}
								}else{
									echo $ti_content['answer'];
								}
								echo "</span>";
								echo "<span class='text_span6'>";
								echo "我的答案是:";
								if($vo['exam_cuowu']==' '){
									echo "空";
								}else{
									echo $vo['exam_cuowu'];
								}
								echo "</span>";
								echo "<p class='wrong_p'>";
								echo "<span style='color:orange;'>"."解析:"."</span>";
								echo $ti_content['resolve'];
								echo "</p>";
								echo "</div>";
								if($vo['exam_content']==null){
									$bi='';
								}else{
									$bi="(原先的笔记是:".$vo['exam_content'].")";
								}
								echo "<div class='wrong_111' id='div_zhengli_$pai' style='display:none;'>";
								echo "<textarea row='3' cols='50' class='text' id='textarea_$pai' placeholder='整理笔记$bi'>";
								echo "</textarea>";
								echo "<input type='text' value='提交' class='text_in' onclick='fuxi($pai)'>";
								echo "</div>";
								echo "</div>";
								$pai++;
							}
						?>
						<div class="wrong_footer">
							<span>
								<?php
									echo "已经移除";
									echo "<strong>".$yichu."</strong>";
									echo "题";
								?>
							</span>
							<input type="button" value="开始复习" class="fuxi" id="fuxi1"/>
						</div>
					</div>
				</form>
			</div>
			<?php include_once("view/page.php"); ?>
		</div>
		<?php include_once("view/right.php"); ?>
	</div>
</body>
<script>
	window.onload=function(){
		var oCheck=document.getElementsByClassName('check_xuan');
		quanxuan.onclick=function(){
			for(var i=0;i<oCheck.length;i++){
				oCheck[i].checked='checked';
			}
		}
		fanxuan.onclick=function(){
			for(var i=0;i<oCheck.length;i++){
				oCheck[i].checked = !oCheck[i].checked;
			}
		}
		
		fuxi1.onclick=function(){
			window.location.href='fuxi.php';
		}
		
	}
	
	function fuxi(name){
		var oArea=document.getElementById('textarea_'+name);
		var oId=document.getElementById('cuowu_'+name);
		console.log(oArea.value);
		console.log(oId.value);
		$.post('ajaxBiJi.php', {
			biji: oArea.value,
			ti_id:oId.value
		}, function(data) {
			console.log(data);
			if(data == -1) {
				layer.msg('提交失败',{time:1000});
				return false;
			}
			if(data == 1){
				layer.msg('发布成功',{time:1000},function(){
		            var index = parent.layer.getFrameIndex(window.name);
		            parent.location.reload();
		            parent.layer.close(index); 
		        });
			}
		});
		return false;
	}
	
	function jiexi(name){
		var oDiv=document.getElementById('div_daan_'+name);
		var oSpan=document.getElementById('span_jiexi_'+name);
		if(oDiv.style.display=='none'){
			oDiv.style.display='block';
			oSpan.innerHTML='收起';
		}else{
			oDiv.style.display='none';
			oSpan.innerHTML='查看答案';
		}
	}
	
	function daan(name){
		var oDiv=document.getElementById('div_zhengli_'+name);
		var oSpan=document.getElementById('span_daan_'+name);
		if(oDiv.style.display=='none'){
			oDiv.style.display='block';
			oSpan.innerHTML='收起';
		}else{
			oDiv.style.display='none';
			oSpan.innerHTML='整理笔记';
		}
	}
	
</script>