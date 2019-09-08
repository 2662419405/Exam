<html>

	<head>
		<meta charset="utf-8" />
		<title>学霸养成平台</title>
		<style type="text/css">
			@font-face {
				font-family: timu;
				src: url(font/hylmzt.ttf);
			}
			
			.input_1{
				position: relative;
			}
			
			.input_1 i{
				position: absolute;
				top: 5px;
				right: 30px;
			}
			
			* {
				margin: 0px;
				padding: 0px
			}
			
			body {
				width: 100%;
				background-image: url(img/bg_login.jpg);
				background-repeat: no-repeat;
				background-position: center 50%;
			}
			
			a {
				text-decoration: none;
			}
			
			.footer {
				line-height: 30px;
				text-align: center;
				color: #333;
				font-size: 14px;
			}
			
			.header {
				text-align: center;
				font-size: 40px;
				letter-spacing: 2em;
				text-shadow: 2px 2px 2px #fff;
				margin-top: 30px;
				height: 90px;
			}
			
			.main {
				width: 1000px;
				margin: 0 auto;
				background-color: rgba(255, 255, 255, 0.5);
				padding: 25px;
				overflow: hidden;
				box-shadow: 3px 3px 10px #fff, -3px -3px 10px #fff, 3px -3px 10px #fff, -3px 3px #fff;
			}
			
			.left {
				float: left;
				width: 385px;
			}
			
			.top {
				background: #eee;
				padding: 15px;
				box-shadow: 2px 2px 2px #ccc;
			}
			
			.field {
				margin-bottom: 20px;
			}
			
			input {
				border: 1px solid #ccc;
				border-radius: 4px;
			}
			
			.input_1 input {
				height: 40px;
				padding: 15px;
				width: 330px;
			}
			
			.input_2 input {
				height: 35px;
				width: 100px;
			}
			
			.input_2 span {
				font-size: 12px;
			}
			
			.right {
				float: right;
				width: 330px;
			}
			
			#submit {
				height: 45px;
				width: 340px;
				background-color: #3399ff;
				color: #fff;
				font-weight: bold;
				margin-bottom: 20px;
				font-size: 16px;
			}
			
			#submit:hover {
				background-color: #6666ff;
			}
			
			.jinru:hover {
				text-decoration: underline;
			}
			
			.bottom {
				margin-top: 20px;
			}
			
			.bottom span {
				color: #666;
				font-size: 16px;
				font-weight: bold;
				margin: 0px 20px;
			}
			
			.list {
				margin-top: 20px;
			}
			
			ul li {
				list-style: none;
				float: left;
				padding: 10px;
			}
			
			ul li img {
				width: 20px;
			}
			
			#right {
				float: left;
				margin: 0px 50px;
			}
			
			#right h2 {
				color: #000;
			}
			
			#comment {
				margin-top: 30px;
				position: relative;
			}
			#username:focus,#password:focus{
				background: #ddd;
			}
			.field span{
				padding: 0px 8px 0px 8px;
				color: #999;
			}
			.in1{
				width: 120px;
				padding: 6px 8px;
			}
			.login_a{
				padding: 0px 8px;
			}
			img {
			    vertical-align: middle;
			}
			.wang{
				float: right;
				margin-right: 20px;
				font-size: 12px;
			}
			.wang a{
				color: #1383EB;
			}
			.fasong{
				padding: 6px 15px;
				font-size: 12px;
				color: #fff;
				border: none;
				background: #60CF65;
				margin-left: 20px;
			}
			.fasong:hover{
				opacity: 0.7;
			}
		</style>
		<script type="text/javascript" src="js/jquery.js"></script>
		<link rel="shortcut icon" href="ico/2.ico" />
	</head>

	<body>
		<div class="header">
			学霸养成系统
		</div>
		<div class="main">
			<div class="left">
				<div class="top">
					<div class="field">
						<div class="input_1">
							<i><img src="img/login_user.jpg"/></i>
							<input type="text" name="tel" id="tel" placeholder="手机号" />
						</div>
					</div>
					<div class="field">
						<span>验证码</span>
						<input type="text" name='authcode' value='' class="in1" id="yan" onKeyPress="if(event.keyCode==13) {document.getElementById('submit').click();}"/>
						<a class="login_A" href="javascript:;">
							<input type="button" value="发送" class="fasong" id="fasong"/>
						</a>
					</div>
					<input type="button" name="submit" id="submit" value="登录"/>
					<div class="message">
						想来密码!
						<a href="login.php" class="jinru">
							登录
						</a>
					</div>
				</div>
				<div class="bottom">
					<img src="img/login_list.jpg" />
					<span>热门推荐内容</span>
					<img src="img/login_list.jpg" />
					<ul class="list">
						<li>
							<img src="img/c.gif" /> 计算机省二
						</li>
						<li>
							<img src="img/a.gif" /> 英语三级半
						</li>
						<li>
							<img src="img/b.gif" /> c语言
						</li>
						<li>
							<img src="img/d.gif" /> 高数
						</li>
						<li>
							<img src="img/j.gif" /> 思修
						</li>
						<li>
							<img src="img/e.gif" /> 英语二级
						</li>
						<li>
							<img src="img/ll.gif" /> 赵凤芝
						</li>
						<li>
							<img src="img/nn.gif" /> 包峰
						</li>
						<li>
							<img src="img/ss.gif" /> 宋莉
						</li>
						<li>
							<img src="img/tt.gif" /> 段鸿轩
						</li>
						<li>
							<img src="img/oo.gif" /> 徐晶
						</li>
					</ul>
				</div>
			</div>
			<div class="right" id="right">
				<h2>平台简介</h2>
				<div id="comment"></div>
			</div>
		</div>
		<div class="footer">
			主要负责人孙航，施海鑫，陈海益，王泽，关江涛
			<br /> Copyright@2019东北石油大学挑战杯比赛
		</div>
	</body>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="layer/layer.js"></script>
	<script type="text/javascript">
		var timer=null;
		var oTel=document.getElementById('tel');
		var i=60;
		
		fasong.onclick = function() {
			if(fasong.value=='发送'){
				if(oTel.value == '') {
					layer.msg('请填写手机号',{time:2000});
					return false;
				}
				if(!(/^1[34578]\d{9}$/.test(oTel.value))){ 
			        layer.msg('手机号码有误',{time:1000});  
			        return false; 
			    }
				timer = setInterval(fnMove, 1000);
				$.post('ajax_duan.php', {
					otel: oTel.value
				}, function(data) {
					if(data == -1) {
						layer.msg('你输入的手机号码不存在',{time:2000});
						return false;
					}else if(data == 1){
						layer.msg('发送成功',{time:2000});
						return false;
					}else{
						layer.msg('发送失败',{time:2000});
						return false;
					}
				});
			}
			return false;
		}
		
		function fnMove(){
			i--;
			fasong.value='重新发送'+i;
			fasong.style.background='#ccc';
			if(i==0){
				clearInterval(timer);
				fasong.style.background='#60CF65';
				fasong.value='发送';
				i=60;
			}
		}
		
		submit.onclick = function() {
			if(yan.value == '') {
				layer.msg('验证码为空',{time:2000});
				return false;
			}
			$.post('ajaxCode.php', {
				yan: yan.value,
				otel: oTel.value
			}, function(data) {
				if(data == -1) {
					layer.msg('你的验证码错误',{time:2000});
					return false;
				}else if(data == 1){
					if(confirm('欢迎你，你的密码已经被修改为123，账号已经在验证码中，请你尽快登录修改')){
						window.location.href='login.php';
					}
				}
			});
			return false;
		}
		
	</script>
	<script src="js/login.js"></script>
</html>