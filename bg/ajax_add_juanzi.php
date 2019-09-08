<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("bg_view/header.html");
	
	//接受数量
	$shuliang=$_POST['juanzi_shu'];
	$n=$db->query("select count(*) from exam_hot");
	if(!(intval($shuliang))){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('题目请输入数字');window.location.href='add_juanzi.php';</script>";
        exit;
	}
	if($shuliang>'60'){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('题量过大，最多为50个题');window.location.href='add_juanzi.php';</script>";
        exit;
	}
	
	//接受作者
	$zuozhe=$_POST['juanzi_zuozhe'];
	//接收卷子名
	$name=$_POST['juanzi_name'];
	$sql  = "select name from exam_zhuanye where name = :username";
    $name1 = $db->row($sql,array('username'=>$name));
    if($name1){
        echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('已经有这个试卷了');window.location.href='add_juanzi.php';</script>";
        exit;
    }
	//接收专业
	$zhuanye=$_POST['juanzi_zy'];
	
	if($zuozhe==''||$name==''||$zhuanye==''){
		echo "<head><meta charset='utf-8'></head>";
        echo "<script> alert('信息不完整');window.location.href='add_juanzi.php';</script>";
        exit;
	}
	
	
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
            	描述：具体详情
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>添加试卷</h4>
            			</div>
            			<div class="box_content">
            					<div class="juanzi">
									<input type="hidden" name="juanzi_name" id="juanzi_name" value="<?php echo $name?>" />
									<input type="hidden" name="juanzi_name" id="juanzi_zhuanye" value="<?php echo $zhuanye?>" />
									<input type="hidden" name="juanzi_name" id="juanzi_zuozhe" value="<?php echo $zuozhe?>" />
	            					<h4>题目专业:<span class="ma"><?php echo $zhuanye;?></span></h4>
	            					<h4>出题作者:<span class="ma"><?php echo $zuozhe;?></span></h4>
	            					<h4>卷子名:<span class="ma"><?php echo $name;?></span></h4>
	            					<h4>操作要求:<span class="ma" style="color: red;">每录入一道题点击一次提交</span></h4>
	            					<div class="tou">
	            						<ul>
	            							<?php
	            								for($i=0;$i<$shuliang;$i++){
	            									?>
	            									
	            									<li onclick="xian(<?php echo $i?>)"><?php echo "第".($i+1)."题"?></li>
	            									
	            							<?	}?>
	            						</ul>
	            					</div>
	            					<div class="zhu" id="zhu" style="display: none;">
	            						<li>
	            							<h4 id="h_juanzi"></h4>
	            						</li>
	            						<li>
											<div class="form_group" id="leixing">
			            						<label class="juanzi_sm">
			            							类型是&nbsp;:
			            						</label>
			            						<div class="clo_sm_2">
			            							<select name="chuti_type" class="xi_tiku" id="xi_tiku">
			            								<option value="5"></option>
			            								<option value='1'>单选题</option>
				            							<option value='2'>填空题</option>
				            							<option value='3'>判断题</option>
			            							</select>
			            						</div>
			            					</div>
	            						</li>
        									<div class='qu'>
        										<li>
        											<div class="form_group">
					            						<label class="juanzi_sm">
					            							问题是&nbsp;:
					            						</label>
					            						<div class="clo_sm_2">
					            							<textarea name="chuti_resolve" id="juanzi_wenti"></textarea>
					            						</div>
					            					</div>
        										</li>
        										<li>
        											<div class="form_group">
					            						<label class="juanzi_sm">
					            							解析&nbsp;:
					            						</label>
					            						<div class="clo_sm_2">
					            							<textarea name="chuti_resolve" id="juanzi_jiexi"></textarea>
					            							<span style="color: orange;">不需要写解析两个字</span>
					            						</div>
					            					</div>
        										</li>
        									</div>
        								<li>
        									<div id="danxuan" style="display:none;">
			        							<div class="form_group">
				            						<label class="juanzi_sm">
				            							A选项&nbsp;:
				            						</label>
				            						<div class="clo_sm_2">
				            							<input id="juanzi_A" type="text" name="xuan_A" value=""/>
				            							<span style="color: orange;">(不需要在选型中添写A)</span>
				            						</div>
				            					</div>
				            					<div class="form_group">
				            						<label class="juanzi_sm">
				            							B选项&nbsp;:
				            						</label>
				            						<div class="clo_sm_2">
				            							<input id="juanzi_B" type="text" name="xuan_B" value=""/>
				            						</div>
				            					</div>
				            					<div class="form_group">
				            						<label class="juanzi_sm">
				            							C选项&nbsp;:
				            						</label>
				            						<div class="clo_sm_2">
				            							<input id="juanzi_C" type="text" name="xuan_C" value=""/>
				            						</div>
				            					</div>
				            					<div class="form_group">
				            						<label class="juanzi_sm">
				            							D选项&nbsp;:
				            						</label>
				            						<div class="clo_sm_2">
				            							<input id="juanzi_D" type="text" name="xuan_D" value=""/>
				            						</div>
				            					</div>
			        						</div>
			        						<div id="xuan" style="display: none;">
			        							<div class="form_group">
				            						<label class="juanzi_sm">
				            							答案是&nbsp;:
				            						</label>
				            						<div class="clo_sm_2">
				            							<select name="chuti_daan" id="juanzi_xuan">
				            								<option value=""></option>
				            								<option value="A">A</option>
				            								<option value="B">B</option>
				            								<option value="C">C</option>
				            								<option value="D">D</option>
				            							</select>
				            						</div>
				            					</div>
			        						</div>
			    							<div id="pan" style="display: none;">
			    								<div class="form_group">
				            						<label class="juanzi_sm">
				            							答案是&nbsp;:
				            						</label>
				            						<div class="clo_sm_2">
				            							<select name="chuti_daan" id="juanzi_pan">
				            								<option value=""></option>
				            								<option value="1">正确</option>
				            								<option value="0">错误</option>
				            							</select>
				            						</div>
				            					</div>
			    							</div>
			    							<div id="tian" style="display: none;">
			    								<div class="form_group">
				            						<label class="juanzi_sm">
				            							答案是&nbsp;:
				            						</label>
				            						<div class="clo_sm_2">
				            							<input type="text" id="juanzi_tian" name="shijuan_daan[]" value=""/>
				            						</div>
				            					</div>
			    							</div>
        								</li>
		            					<div class="form_group" style="margin-top: 20px;">
		            						<div class="clo_sm_3">
				            					<input type="button" value="提交" class="shiti_tijiao" id="tijiao"/>
			            					</div>
		            					</div>
	            					</div>
	            				</div>
            			</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</body>
<script>

function xian(e){
	var oDiv=document.getElementById('zhu');
	oDiv.style.display='block';
	h_juanzi.innerHTML="第"+(e+1)+"到题";
}

$('#xi_tiku').change(function(){
	var options=$("#xi_tiku option:selected");
	if(options.val()==1){
		tian.style.display='none';
		pan.style.display='none';
		danxuan.style.display='block';
		xuan.style.display='block';
	}else if(options.val()==2){
		danxuan.style.display='none';
		xuan.style.display='none';
		pan.style.display='none';
		tian.style.display='block';
	}else if(options.val()==3){
		danxuan.style.display='none';
		xuan.style.display='none';
		tian.style.display='none';
		pan.style.display='block';
	}
});
//提交按钮 
tijiao.onclick = function() {
	if(xi_tiku.value=='5'){
		layer.msg('选择题类型',{time:2000});
		return false;
	}
	if(juanzi_wenti.value == '') {
		layer.msg('请输入题目',{time:2000});
		return false;
	}
	if(juanzi_jiexi.value == '') {
		layer.msg('请输入解析',{time:2000});
		return false;
	}
	if(xi_tiku.value=='1'){
		if(juanzi_A.value==''){
			layer.msg('请输入A选项',{time:2000});
			return false;
		}
		if(juanzi_B.value==''){
			layer.msg('请输入B选项',{time:2000});
			return false;
		}
		if(juanzi_C.value==''){
			layer.msg('请输入C选项',{time:2000});
			return false;
		}
		if(juanzi_D.value==''){
			layer.msg('请输入D选项',{time:2000});
			return false;
		}
		if(juanzi_xuan.value==''){
			layer.msg('请输入答案',{time:2000});
			return false;
		}
	}if(xi_tiku.value=='2'){
		if(juanzi_tian.value==''){
			layer.msg('请输入答案',{time:2000});
			return false;
		}
	}
	if(xi_tiku.value=='3'){
		if(juanzi_pan.value==''){
			layer.msg('请输入答案',{time:2000});
			return false;
		}
	}	
	$.post('chuli_juanzi.php', {
		shijuan_type: xi_tiku.value,
		juanzi_wenti: juanzi_wenti.value,
		juanzi_jiexi: juanzi_jiexi.value,
		juanzi_A: juanzi_A.value,
		juanzi_B: juanzi_B.value,
		juanzi_C: juanzi_C.value,
		juanzi_D: juanzi_D.value,
		juanzi_xuan: juanzi_xuan.value,
		juanzi_tian: juanzi_tian.value,
		juanzi_pan: juanzi_pan.value,
		chinese: juanzi_zhuanye.value,
		name: juanzi_name.value,
		zuozhe: juanzi_zuozhe.value,
		juanzi_biao: 1
	}, function(data) {
		if(data == -1) {
			layer.msg('提交失败',{time:2000});
			return false;
		}
		if(data == 1) {
			layer.msg('提交成功');
			xi_tiku.value='';
			juanzi_wenti.value='';
		    juanzi_jiexi.value='';
		    juanzi_A.value='';
		    juanzi_B.value='';
		    juanzi_C.value='';
		    juanzi_D.value='';
		    juanzi_xuan.value='';
		    juanzi_tian.value='';
		    juanzi_pan.value='';
		}
	});
	return false;
}

</script>
</html>            			