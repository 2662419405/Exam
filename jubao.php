<?php
	require('library/Db.class.php');
    require("library/function.php");
    $stu_id=$_GET['id'];
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$sql="select * from exam_baocuo order by exam_addtime desc limit 5";
	$jubao=$db->query($sql);
	$xi=$_GET['xi_tiku'];
	$na=$_GET['name'];
	$biaoji=$_GET['biaoji'];
	
	include("view/header.html");
	?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="liuyan content">
				<div class="content_title">
					发现问题  , 及时校对~~~
				</div>
				<div class="content_text">
					<div class="filed xinban">
							<input type="hidden" name="biaoji" id="biaoji" value="<?php echo $biaoji?>" />
							<label>题目ID(编号)</label>
							<input type="text" value="<?php echo $stu_id;?>" id="baocuo_id"  readonly="readonly"/>
					</div>
					<div class="filed xinban">
							<label>题目所属系</label>
							<input type="text" value="<?php echo $xi;?>" id="baocuo_xi"  readonly="readonly"/>
					</div>
					<div class="filed xinban">
							<label>发题者姓名</label>
							<input type="text" value="<?php echo $na;?>" id="baocuo_xm"
								readonly="readonly" />
					</div>
					<textarea name="setting_content" id="setting_content" rows="4" cols="67" placeholder="可以写出你对此题的看法，我们会第一时间对你的问题进行处理的"></textarea>
				</div>
				<div class="relese">
					<span>现在是:<?php $now_time=time(); echo date('Y/m/d',$now_time); ?></span>
					<div class="liuyan_zuihou">
						<span>还可以输入<em class="count" id="count1"></em> 字</span>
						<button class="liuyan_tijiao" id="jubao_tijiao">提交</button>
					</div>
				</div>
				<div class="liuyan_wenben">
					<p>全部问题</p>
					<div class="jubao_wenben">
						<?php
							foreach($jubao as $vo){
								echo '<li>';
								echo "<span class='jubao_span1'>";
								echo '提交者姓名:'.$user['username'];
								echo '</span>';
								echo "<span class='jubao_span2'>";
								echo '提交时间:'.tranTime($vo['exam_addtime']);
								echo '</span>';
								echo "<span class='jubao_span3'>";
								echo '编号:'.$vo['cuowu_id'];
								echo '</span>';
								echo "<span class='jubao_span4'>";
								echo '处理情况:';
								if($vo['tongguo']==1){
									echo "<em class='em_1'>";
									echo '正在审核';
									echo "</em>";
								}
								else{
									echo "<em class='em_2'>";
									echo '已经修改';
									echo "</em>";
								}
								echo '</span>';
								echo '</li>';
							}
							?>
					</div>
				</div>
			</div>
		</div>
		<?php include_once("view/right.php"); ?>
	</div>
	<?php include_once("view/footer.html"); ?>
</body>
<script type="text/javascript" src="js/jquery.js">
</script>
<script type="text/javascript">
	window.onload=function(){
		var baocuo_id=document.getElementById('baocuo_id');
		var baocuo_xi=document.getElementById('baocuo_xi');
		var baocuo_xm=document.getElementById('baocuo_xm');
		var setting_content=document.getElementById('setting_content');
		var jubao_tijiao=document.getElementById('jubao_tijiao');
		var ti="<?php echo $_SESSION['user']['username']?>"
		var c=140;
		var count1=document.getElementById('count1');
		count1.innerHTML=140;
		setInterval(function(event){
			count1.innerHTML=c-setting_content.value.length;
			if(c-setting_content.value.length<0){
				setting_content.style.color='red';
			}
			else{
				setting_content.style.color='#999';
			}
		},100);
		jubao_tijiao.onclick=function(){
			if(baocuo_id.value==''){
				layer.msg('题目编号为空',{time:1000});
				return false;
			}
			if(baocuo_xi.value==''){
				layer.msg('题目所在系为空',{time:1000});
				return false;
			}
			if(baocuo_xm.value==''){
				layer.msg('题目姓名为空',{time:1000});
				return false;
			}
			if(setting_content.value.length==0){
				layer.msg('内容不能为空',{time:1000});
				return false;
			}
			if(setting_content.value.length>=140){
				layer.msg('内容过多',{time:1000});
				return false;
			}
			$.post('ajaxJuBao.php', {
				baocuo_id: baocuo_id.value,
				baocuo_xi: baocuo_xi.value,
				baocuo_xm: baocuo_xm.value,
				biaoji:biaoji.value,
				name:ti,
				setting_content: setting_content.value
			}, function(data) {
				if(data == -1) {
					layer.msg('提交失败请稍后再试',{time:1000});
					return false;
				}
				if(data == 1) {
					layer.msg('发布成功，火速处理中',{time:1000},function(){
			            var index = parent.layer.getFrameIndex(window.name);
			            parent.location.reload();
			            parent.layer.close(index); 
			        });
				}
			});
			return false;
		}
	}
</script>