<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$sql="select * from exception where user_name = :user_name order by addtime desc limit 2";
	$liuyan=$db->query($sql,array('user_name'=>$user['username']));
	
	$shu = $db->query("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	include("view/header.html");
	?>

<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
<script type="text/javascript" src="js/jquery.js" ></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script>
	
function checknum(v,tar) {
	var regex = new RegExp('(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{8,30}');
	if(tar==1){
		if (!regex.test(v)){
			$('#new_password'+tar).css('border','2px solid red')
			$('#ti'+tar).css('display','block')
		}else{
			$('#new_password'+tar).css('border','')
			$('#ti'+tar).css('display','none')
		}
	}
	if(tar==2){
		if($('#new_password1').val()!==$('#new_password2').val()){
			$('#new_password'+tar).css('border','2px solid red')
			$('#ti'+tar).css('display','block')
		}
		else{
			$('#new_password'+tar).css('border','')
			$('#ti'+tar).css('display','none')
		}
	}
	if($('#ti1').css('display')=='none' && $('#ti2').css('display')=='none' && $('#new_password1').val()==$('#new_password2').val()){
		$('#tijiao').removeAttr('disabled')
	}
}
	
</script>
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="my_head" style="background: url(img/my_bg.png) center center no-repeat;">
			<img src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" class="touxiang" value="<?php echo $user['avatar'] ?>">
			<p class="p1"><?php echo $user['username']?></p>
			<p class="p2"><marquee behavior="scroll" direction="left">我的努力求学没有得到别的好处，只不过是愈来愈发觉自己的无知！</marquee></p>
			<span>注册于<?php echo date('Y-m-d',$user['addtime']) ?></span>
		</div>
		<div class="bottom">
			<div class="left">
				<ul>
					<!--
                    	作者：2662419405@qq.com
                    	时间：2019-01-09
                    	描述：这个地方经过后期修改，吧头像设置设为第一个，欢乐留言版为最后一个
                    -->
					<li><a id="tab4" class="active" >头像设置</a></li>
					<li><a id="tab1">资料修改</a></li>
					<li><a id="tab2">密码修改</a></li>
					<li><a id="tab3">欢乐留言板 </a></li>
				</ul>
				<div id="div4">
					<div style="height: 400px">
		                <div id="altContent"></div>
		            </div>
				</div>
				<div id="div1">
					<form action="saveSetting.php" method="post">
						<div class="filed">
							<label>用户名</label>
							<input type="text" readonly="readonly" value="<?php echo $user['username']?>"/>
						</div>
						<div class="filed">
							<label>性别</label>
							<select class="ui fluid dropdown" name="sex">
		                        <option value="0">保密</option>
		                        <option value="1">男</option>
		                        <option value="2">女</option>
		                    </select>
						</div>
						<div class="filed">
							<label>qq号</label>
							<input type="text" name="qq" value="<?php echo $shu[0]['qq']?>" id="qq1"/>
						</div>
						<div class="filed">
							<label>专业班级</label>
							<input type="text" name="class_id" value="<?php echo $shu[0]['class_id']?>" id="class_id1"/>
						</div>
						<div class="filed">
							<label>手机号</label>
							<input type="text" name="tel" value="<?php echo $shu[0]['tel']?>" id="tel1"/>
						</div>
						<input type="submit" value="提交" class="tijiao" id="tijiao1"/>
					</form>
				</div>
				<div id="div2">
					<div class="filed">
						<label>原始密码<sup>*</sup></label>
						<input type="password" id="old_password" name="old_password"/>
					</div>
					<div class="filed">
						<label>新密码<sup>*</sup></label>
						<input type="password" id="new_password1" name="new_password1"  onkeyup="checknum(this.value,1)"/>
						<p class="tixing" id="ti1">您的密码复杂度太低（密码中必须包含字母、数字、特殊字符）</p>
					</div>
					<div class="filed">
						<label>再次确认密码<sup>*</sup></label>
						<input type="password" id="new_password2" name="new_passowrd2" onkeyup="checknum(this.value,2)"/>
						<p class="tixing" id="ti2">两次密码不一致</p>
					</div>
					<input type="submit" value="确认" class="tijiao" id="tijiao" disabled="false"/>
				</div>
				<div id="div3">
					<div class="liuyan">
						<div class="content_title">
							随时随地  , 想发就发~~~
						</div>
						<div class="content_text">
							<textarea name="setting_content" id="setting_content" rows="3" cols="67" placeholder="大家分享的优秀经验我们会推荐到首页当中，大家给我们的宝贵意见我们也会努力修改"></textarea>
						</div>
						<div class="relese">
							<span>现在是:<?php $now_time=time(); echo date('Y/m/d',$now_time); ?></span>
							<div class="liuyan_zuihou">
								<span>还可以输入<em class="count" id="count"></em> 字</span>
								<button class="liuyan_tijiao" id="liuyan_tijiao">经验</button>
								<button class="liuyan_tijiao" id="liuyan_fankui">意见</button>
							</div>
						</div>
						<div class="liuyan_wenben">
							<?php
								$len=sizeof($liuyan);
								if($len==0){
									echo "暂无经验分享";
								}else if($len==1){
									?>
									<p>学习经验</p>
									<ul>
										<li id="li1">
											<img src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" value="<?php echo $user['avatar'] ?>">
												<strong>
												<?php echo $user['username']?></strong>
												<span><?php echo date('m-d H:i',$liuyan[0]['addtime']+25200) ?></span>
												<div class="liuyan_neirong">
													<p>
													<?php echo $liuyan[0]['content']?></p>
												</div>
										</li>
									</ul>
								<?php
								}
									elseif($len==2){
									?>
									<p>学习经验</p>
									<ul>
										<li id="li1">
											<img src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" value="<?php echo $user['avatar'] ?>">
												<strong>
												<?php echo $user['username']?></strong>
												<span><?php echo date('m-d H:i',$liuyan[0]['addtime']+25200) ?></span>
												<div class="liuyan_neirong">
													<p>
													<?php echo $liuyan[0]['content']?></p>
												</div>
										</li>
										<li id="li2">
											<img src="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>" value="<?php echo $user['avatar'] ?>">
												<strong>
												<?php echo $user['username']?></strong>
												<span><?php echo date('m-d H:i',$liuyan[1]['addtime']+25200) ?></span>
												<div class="liuyan_neirong">
													<p>
													<?php echo $liuyan[1]['content']?></p>
												</div>
										</li>
									</ul>
								<?php
								}
								?>
							
						</div>
					</div>
				</div>
			</div>
			<?php include_once("view/right.php"); ?>
			<?php include_once("view/footer.html"); ?>
		</div>
	</div>
	</body>
	<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/meitu.js" ></script>
	<script>
		
		var old_password = document.getElementById('old_password');
		var new_password1 = document.getElementById('new_password1');
		var new_password2 = document.getElementById('new_password2');
		var tijiao=document.getElementById('tijiao');
		var liuyan_content=document.getElementById('setting_content');
		var liuyan_tijiao=document.getElementById('liuyan_tijiao');
		tijiao.onclick = function() {
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
			$.post('savePassword.php',{
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
		var count=document.getElementById('count');
		var cont=140;
		var tijiao1=document.getElementById('tijiao1');
		tijiao1.onclick=function(){
			var qq=document.getElementById('qq1').value;
			var class_id=document.getElementById('class_id1');
			var phone=document.getElementById('tel1').value;
			console.log(qq+" "+class_id.value.length+" "+phone);
		  	if(!(/^[1-9][0-9]{4,9}$/.test(qq))){ 
		        layer.msg('QQ号码有误',{time:1000});  
		        return false; 
		    }
		  	if(!(class_id.value.length>0&&class_id.value.length<=6)){
		  		layer.msg('班级名字不要超过6个字',{time:1000});
		  		return false;
		  	}
		  	 if(!(/^1[34578]\d{9}$/.test(phone))){ 
		        layer.msg('手机号码有误',{time:1000});  
		        return false; 
		    } 
		}
		setInterval(function(event){
			count.innerHTML=cont-liuyan_content.value.length;
			if(cont-liuyan_content.value.length<0){
				count.style.color='red';
			}
			else{
				count.style.color='#999';
			}
		},100);
		liuyan_tijiao.onclick=function(){
			if(liuyan_content.value==''){
				layer.msg('输入的内容不能为空',{time:1000});
				return false;
			}
			if(liuyan_content.value.length>140){
				layer.msg('修改的内容过多',{time:1000});
				return false;
			}
			$.post('ajaxException.php',{content:liuyan_content.value},function(data){
				if(data==-1){
					layer.msg('提交失败',{time:1000});
					liuyan_content.value='';
					return false;
				}
				if(data==1){
					layer.msg('提交成功',{time:1000});
					window.location.reload();
				}
			})
		};
		var fankui=document.getElementById('liuyan_fankui');
		fankui.onclick=function(){
			if(liuyan_content.value==''){
				layer.msg('提交的内容为空',{time:1000});
				return false;
			}
			if(liuyan_content.value.length>140){
				layer.msg('输入的内容过多',{time:1000});
				return false;
			}
			$.post('ajaxFankui.php',{content:liuyan_content.value},function(data){
				if(data==-1){
					layer.msg('提交失败',{time:1000});
					liuyan_content.value='';
					return false;
				}
				if(data==1){
					layer.msg('提交成功',{time:1000});
					liuyan_content.value='';
				}
			})
		};
		
		var div1 = document.getElementById('div1');
		var div2 = document.getElementById('div2');
		var div3 = document.getElementById('div3');
		var div4 = document.getElementById('div4');
		var a1 = document.getElementById('tab1');
		var a2 = document.getElementById('tab2');
		var a3 = document.getElementById('tab3');
		var a4 = document.getElementById('tab4');
		a1.onclick = function() {
			a1.className = 'active';
			a2.className = '';
			a3.className = '';
			a4.className = '';
			div1.style.display = 'block';
			div2.style.display = 'none';
			div3.style.display = 'none';
			div4.style.display = 'none';
		};
		a2.onclick = function() {
			a2.className = 'active';
			a1.className = '';
			a3.className = '';
			a4.className = '';
			div2.style.display = 'block';
			div1.style.display = 'none';
			div3.style.display = 'none';
			div4.style.display = 'none';
			return false;
		};
		a3.onclick = function() {
			a3.className = 'active';
			a2.className = '';
			a1.className = '';
			a4.className = '';
			div3.style.display = 'block';
			div2.style.display = 'none';
			div1.style.display = 'none';
			div4.style.display = 'none';
			return false;
		};
		a4.onclick = function() {
			a4.className = 'active';
			a2.className = '';
			a1.className = '';
			a3.className = '';
			div4.style.display = 'block';
			div2.style.display = 'none';
			div1.style.display = 'none';
			div3.style.display = 'none';
			return false;
		};
	</script>
</html>