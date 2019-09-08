<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
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
            	描述：密码
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>修改密码</h4>
            			</div>
            			<div class="box_content">
            				<div class="form_group">
            					<label class="clo_sm mima_span">原密码<sup>*</sup>&nbsp;:</label>
            					<div class="clo_sm_2">
            						<input type="password" name="old_password" value="" id="old_password"/>
            					</div>
            				</div>
            				<div class="form_group">
            					<label class="clo_sm mima_span">新密码<sup>*</sup>&nbsp;:</label>
            					<div class="clo_sm_2">
            						<input type="password" name="new_password" value="" id="new_password1"/>
            					</div>
            				</div>
            				<div class="form_group">
            					<label class="clo_sm mima_span">再次确认密码<sup>*</sup>&nbsp;:</label>
            					<div class="clo_sm_2">
            						<input type="password" name="new_password1" value="" id="new_password2" onKeyPress="if(event.keyCode==13) {document.getElementById('mima_xiugai').click();}"/>
            					</div>
            				</div>
            				<div class="form_group">
        						<div class="clo_sm_3">
	            					<input type="button" value="确定" id="mima_xiugai"/>
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
	mima_xiugai.onclick = function() {
		if(old_password.value == '') {
			layer.msg('密码为空',{time:1000});
			return false;
		}
		if(new_password1.value==''){
			layer.msg('新密码不能为空',{time:1000});
			return false;
		}
		if(new_password1.value !== new_password2.value) {
			layer.msg('两次密码不一致',{time:1000});
			return false;
		}
		$.post('ajaxMima.php',{
			old_password:old_password.value,
			new_password1:new_password1.value,
			new_password2:new_password2.value
		},function(data) {
			if(data==old_password.value+"-1"){
				layer.msg('原密码错误',{time:1000});
				old_password.value='';
				new_password1.value='';
				new_password2.value='';
				return false;
			}
			if(data==old_password.value+"1"){
				layer.msg('修改成功',{time:1000});
				window.location.reload();
			}
		});
		return false;
	};
</script>
</html>