<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	$sql="select * from user order by addtime desc limit 7";
	$chengyuan=$db->query($sql);
	$sql1="select * from exam_news where height = 0 order by addtime desc limit 8";
	$news=$db->query($sql1);
	$sql2="select * from sort order by true_sum desc limit 7";
	$sort=$db->query($sql2);
	$sql3="select * from exception where height = 2 order by addtime desc limit 8";
	$jingyan=$db->query($sql3);
	$pai=0;
	$ming=0;
	
	//查询我的好友
	$sql_cha="select * from friends where user_id = :user and status = 1 order by addtime desc";
	$hao=$db->query($sql_cha,array('user'=>$user_id));	
	include("view/header.html");
	
	#考试内容的
	$sql="select * from exam_zhuanye group by name order by num desc limit 5";
	$re=$db->query($sql);
	
	//查询最后一次登录时间
	$last_time=$user['last_addtime'];	
?>

<script type="text/javascript" src="js/move.js"></script>
<script>
	
	window.onload=function(){
		//右下角回调函数 
		var oBtn=document.getElementById('but');
		var oBottom=document.getElementById('zhu_bottom');
		var oBox=document.getElementById('zhu_box');
		var oBtnClose=document.getElementById('btn_close');
		var initBottomRight=parseInt(getStyle(oBottom, 'right'));
		var initBoxBottom=parseInt(getStyle(oBox, 'bottom'));
		oBtn.onclick=function ()
		{
			startMove(oBottom, {right: 0}, function (){
				oBox.style.display='block';
				startMove(oBox, {bottom: 0});
			});
			oBtn.className='but_hide';
		};
		oBtnClose.onclick=function ()
		{
			xianshi.style.display='none';
			startMove(oBox, {bottom: initBoxBottom}, function (){
				oBox.style.display='none';
				startMove(oBottom, {right: initBottomRight}, function (){
					oBtn.className='but_show';
				});
			});
		};
		
		var oDiv=document.getElementsByClassName('divv');
		for(var i=0;i<oDiv.length;i++){
			oDiv[i].style.display='none';
		}
		
		cang();
		
		oDiv[0].style.display='block';
		
		tanchu.onclick=function(ev){
			cang();
			if(getStyle(tanchu,'left')=='-490px'){
				tanchu_a.className='tanchu_b';
				move(0);
			}else if(getStyle(tanchu,'left')=='0px'){
				tanchu_a.className='tanchu_a';
				move(-490);
			}
			
		}
		
		function getStyle(obj, attr) {
			return obj.currentStyle ? obj.currentStyle[attr] : getComputedStyle(obj)[attr];
		}
		
		function move(target){
            var timer=null;
            var speed;
            clearInterval(timer);
            timer=setInterval(function () {
                speed=(target-tanchu.offsetLeft)/10;
                if(speed>0)
                {
                    speed=Math.ceil(speed);
                }
                else
                {
                    speed=Math.floor(speed);
                }
                if(Math.abs(target-tanchu.offsetLeft)==0)
                {
                    clearInterval(timer);
                }
                else
                {
                    tanchu.style.left=tanchu.offsetLeft+speed+'px';
                }
            },30);
		}
		
	}
	
	function cang(){
		var oD=document.getElementsByClassName('div222');		
		
		for(var i=0;i<oD.length;i++){
			oD[i].style.display='none';
		}
	}
	
	function ka(cursel, n){
		
		for(var i = 1; i <= n; i++) {
			var oD=document.getElementById('div_'+i);
			if(i==cursel){
				oD.style.display='block';
			}else{
				oD.style.display='none';
			}
		}
	}
	
</script>
<script type="text/javascript" src="js/function.js" ></script>
<script type="text/javascript" src="js/jquery.js"></script>
<body style="background: linear-gradient(to bottom, #d4e8fe, #fff);">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="index_top">
			<ul class="index_title">
				<li><p>学</p><span>XUE</span></li>
			</ul>
			<ul>
				<li><p>霸</p><span>BA</span></li>
			</ul>
			<ul>
				<li><p>养</p><span>YANG</span></li>
			</ul>
			<ul>
				<li><p>成</p><span>CHENG</span></li>
			</ul>
			<ul>
				<li><p>平</p><span>PING</span></li>
			</ul>
			<ul>
				<li><p>台</p><span>TAI</span></li>
			</ul>
		</div>
		<div id="tanchu">
			<ul>
				<li>
					<div class="div111">
						<img src="img/ac5.jpg" class="img_222" onmouseover="ka(1,6)" onmouseout="cang()">
						<div class="div222" id="div_1"><img src="img/ac_5.jpg" class="img_333"></div>
					</div>
				</li>
				<li>
					<div class="div111">
						<img src="img/ac1.jpg" class="img_222" onmouseover="ka(2,6)" onmouseout="cang()">
						<div class="div222" id="div_2"><img src="img/ac_1.jpg" class="img_333"></div>
					</div>
				</li>
				<li>
					<div class="div111">
						<img src="img/ac2.jpg" class="img_222" onmouseover="ka(3,6)" onmouseout="cang()">
						<div class="div222" id="div_3"><img src="img/ac_2.jpg" class="img_333"></div>
					</div>
				</li>
				<li>
					<div class="div111">
						<img src="img/ac3.jpg" class="img_222" onmouseover="ka(4,6)" onmouseout="cang()">
						<div class="div222" id="div_4"><img src="img/ac_3.jpg" class="img_333"></div>
					</div>
				</li>
				<li>
					<div class="div111">
						<img src="img/ac4.jpg" class="img_222" onmouseover="ka(5,6)" onmouseout="cang()">
						<div class="div222"  id="div_5"><img src="img/ac_4.jpg" class="img_333"></div>
					</div>
				</li>
				<li>
					<div class="div111">
						<img src="img/ac11.jpg" class="img_222" onmouseover="ka(6,6)" onmouseout="cang()">
						<div class="div222"  id="div_6"><img src="img/ac_11.jpg" class="img_333"></div>
					</div>
				</li>
			</ul>
			<a href="#" class="tanchu_a" id="tanchu_a"></a>
		</div>
		<div class="index_content">
			<div class="index_shouye" id="nnnnn">
				<ul>
					<li><a href="index.php" class="current">
						<strong>
							<span>题库大厅</span>
							<span class="active_span">题库大厅</span>
						</strong>
					</a></li>
					<li><a href="rankling_list.php">
						<strong>
							<span>成绩排名</span>
							<span class="active_span">成绩排名</span>
						</strong>
					</a></li>
					<li><a href="re_teacher.php">
						<strong>
							<span>最新成员</span>
							<span class="active_span">最新成员</span>
						</strong>
					</a></li>
					<li><a href="geren.php">
						<strong>
							<span>讨论专区</span>
							<span class="active_span">讨论专区</span>
						</strong>
					</a></li>
					<li><a href="hot_source.php">
						<strong>
							<span>热门学科</span>
							<span class="active_span">热门学科</span>
						</strong>
					</a></li>
					<li><a href="tiku.php">
						<strong>
							<span>题库练习</span>
							<span class="active_span">题库练习</span>
						</strong>
					</a></li>
					<li><a href="test.php">
						<strong>
							<span>模拟考试</span>
							<span class="active_span">模拟考试</span>
						</strong>
					</a></li>
					<li><a href="info_my.php">
						<strong>
							<span>关于我们</span>
							<span class="active_span">关于我们</span>
						</strong>
					</a></li>
				</ul>
			</div>
		</div>
		<script>
			
			var oDiv=document.getElementById('nnnnn');
			var aStrong=oDiv.getElementsByTagName('strong');
			var aA=oDiv.getElementsByTagName('a');
			var iTarget=oDiv.getElementsByTagName('li')[0].offsetHeight;
		 
			for(var i=0; i<aStrong.length; i++)
			{
				aA[i].style.width=aStrong[i].style.width=aStrong[i].getElementsByTagName('span')[0].offsetWidth+'px';
				aStrong[i].style.position='absolute';
				aStrong[i].style.top=aStrong[i].style.left=0;
				
				aStrong[i].onmouseover=function()
				{
					startMove1(this, -iTarget);
				};
				aStrong[i].onmouseout=function()
				{
					startMove1(this, 0);
				};
			}
			
			function startMove1(obj,target)
			{
				clearInterval(obj.iTime);
				obj.iTime=setInterval(function(){
					if(obj.offsetTop==target)
					{
						clearInterval(obj.iTime);
					}
					else
					{
						var iSpeed=(target-obj.offsetTop)/4;
						iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed);
						obj.style.top=obj.offsetTop+iSpeed+'px';
					}
				}, 30);
			}
			
		</script>
		<div class="index_main">
			<div class="main_left">
				<div class="index_news">
					<div class="news_top"><img src="img/index_list.jpg" class="img1"><span>学习指导</span></div>
					<ul>
						<li><a href="<?php echo $news[0]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[0]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[0]['addtime']) ?></span>
						</a></li>
						<li><a href="<?php echo $news[1]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[1]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[1]['addtime']) ?></span>
						</a></li>
						<li><a href="<?php echo $news[2]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[2]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[2]['addtime']) ?></span>
						</a></li>
						<li><a href="<?php echo $news[3]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[3]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[3]['addtime']) ?></span>
						</a></li>
						<li><a href="<?php echo $news[4]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[4]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[4]['addtime']) ?></span>
						</a></li>
						<li><a href="<?php echo $news[5]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[5]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[5]['addtime']) ?></span>
						</a></li>
						<li><a href="<?php echo $news[6]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[6]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[6]['addtime']) ?></span>
						</a></li>
						<li><a href="<?php echo $news[7]['news_href']?>">
							<img src="img/jt.png">
							<?php echo "<strong>".$news[7]['title']."</strong>";?>
							<span><?php echo date('m-d',$news[7]['addtime']) ?></span>
						</a></li>
					</ul>
				</div>
			</div>
			<div class="main_c">
				<div class="index_soft">
					<div class="soft_top"><img src="img/index_list.jpg" class="img1"><span>优秀考榜</span></div>
					<ul>
						<li>
							<span class="span1">名次</span>
							<span class="span2">姓名</span>
							<span class="span3">做题</span>
							<span class="span4" style="margin-right: 30px;">专业</span>
						</li>
						<li>
							<?php $ziji_id=$sort[0]['user_id']?>
							<a href="homepage.php?friend_id=<?php echo $ziji_id?>">
								<span class="span1">&nbsp;&nbsp;1</span>
								<span class="span2"><?php echo $sort[0]['username']?></span>
								<span class="span3"><?php echo $sort[0]['true_sum']?></span>
								<span class="span4"><?php echo $sort[0]['class_id']?></span>
							</a>
						</li>
						<li>
							<?php $ziji_id=$sort[1]['user_id']?>
							<a href="homepage.php?friend_id=<?php echo $ziji_id?>">
								<span class="span1">&nbsp;&nbsp;2</span>
								<span class="span2"><?php echo $sort[1]['username']?></span>
								<span class="span3"><?php echo $sort[1]['true_sum']?></span>
								<span class="span4"><?php echo $sort[1]['class_id']?></span>
							</a>
						</li>
						<li>
							<?php $ziji_id=$sort[2]['user_id']?>
							<a href="homepage.php?friend_id=<?php echo $ziji_id?>">
								<span class="span1">&nbsp;&nbsp;3</span>
								<span class="span2"><?php echo $sort[2]['username']?></span>
								<span class="span3"><?php echo $sort[2]['true_sum']?></span>
								<span class="span4"><?php echo $sort[2]['class_id']?></span>
							</a>
						</li>
						<li>
							<?php $ziji_id=$sort[3]['user_id']?>
							<a href="homepage.php?friend_id=<?php echo $ziji_id?>">
								<span class="span1">&nbsp;&nbsp;4</span>
								<span class="span2"><?php echo $sort[3]['username']?></span>
								<span class="span3"><?php echo $sort[3]['true_sum']?></span>
								<span class="span4"><?php echo $sort[3]['class_id']?></span>
							</a>
						</li>
						<li>
							<?php $ziji_id=$sort[4]['user_id']?>
							<a href="homepage.php?friend_id=<?php echo $ziji_id?>">
								<span class="span1">&nbsp;&nbsp;5</span>
								<span class="span2"><?php echo $sort[4]['username']?></span>
								<span class="span3"><?php echo $sort[4]['true_sum']?></span>
								<span class="span4"><?php echo $sort[4]['class_id']?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="main_right">
				<div class="index_teacher">
					<div class="teacher_top"><img src="img/index_list.jpg" class="img1"><span>最新成员</span></div>
					<ul>
						<li id="stu_index_btn">
							<span>姓名</span>
							<span>等级</span>
							<span>注册时间</span>
						</li>
						<?php $cheng=$chengyuan[0]['id']?>
						<li><a href="homepage.php?friend_id=<?php echo $cheng?>">
							<img src="img/sl.png">
								<?php echo $chengyuan[0]['username'];?>
								<?php if($chengyuan[0]['level']==2){echo '&nbsp;&nbsp;&nbsp;&nbsp;老师';}else{echo '&nbsp;&nbsp;&nbsp;&nbsp;学生';}?>
								<span><?php echo date('m-d',$chengyuan[0]['addtime']) ?></span>
							</a>
						</li>
						<?php $cheng=$chengyuan[1]['id']?>
						<li><a href="homepage.php?friend_id=<?php echo $cheng?>">
							<img src="img/sl.png">
								<?php echo $chengyuan[1]['username'];?>
								<?php if($chengyuan[1]['level']==2){echo '&nbsp;&nbsp;&nbsp;&nbsp;老师';}else{echo '&nbsp;&nbsp;&nbsp;&nbsp;学生';}?>
								<span><?php echo date('m-d',$chengyuan[1]['addtime']) ?></span>
							</a>
						</a></li>
						<?php $cheng=$chengyuan[2]['id']?>
						<li><a href="homepage.php?friend_id=<?php echo $cheng?>">
							<img src="img/sl.png">
								<?php echo $chengyuan[2]['username'];?>
								<?php if($chengyuan[2]['level']==2){echo '&nbsp;&nbsp;&nbsp;&nbsp;老师';}else{echo '&nbsp;&nbsp;&nbsp;&nbsp;学生';}?>
								<span><?php echo date('m-d',$chengyuan[2]['addtime']) ?></span>
							</a>
						</a></li>
						<?php $cheng=$chengyuan[3]['id']?>
						<li><a href="homepage.php?friend_id=<?php echo $cheng?>">
							<img src="img/sl.png">
								<?php echo $chengyuan[3]['username'];?>
								<?php if($chengyuan[3]['level']==2){echo '&nbsp;&nbsp;&nbsp;&nbsp;老师';}else{echo '&nbsp;&nbsp;&nbsp;&nbsp;学生';}?>
								<span><?php echo date('m-d',$chengyuan[3]['addtime']) ?></span>
							</a>
						</a></li>
						<?php $cheng=$chengyuan[4]['id']?>
						<li><a href="homepage.php?friend_id=<?php echo $cheng?>">
							<img src="img/sl.png">
								<?php echo $chengyuan[4]['username'];?>
								<?php if($chengyuan[4]['level']==2){echo '&nbsp;&nbsp;&nbsp;&nbsp;老师';}else{echo '&nbsp;&nbsp;&nbsp;&nbsp;学生';}?>
								<span><?php echo date('m-d',$chengyuan[4]['addtime']) ?></span>
							</a>
						</a></li>
						<?php $cheng=$chengyuan[5]['id']?>
						<li><a href="homepage.php?friend_id=<?php echo $cheng?>">
							<img src="img/sl.png">
								<?php echo $chengyuan[5]['username'];?>
								<?php if($chengyuan[5]['level']==2){echo '&nbsp;&nbsp;&nbsp;&nbsp;老师';}else{echo '&nbsp;&nbsp;&nbsp;&nbsp;学生';}?>
								<span><?php echo date('m-d',$chengyuan[5]['addtime']) ?></span>
							</a>
						</a></li>
						<?php $cheng=$chengyuan[6]['id']?>
						<li><a href="homepage.php?friend_id=<?php echo $cheng?>">
							<img src="img/sl.png">
								<?php echo $chengyuan[6]['username'];?>
								<?php if($chengyuan[6]['level']==2){echo '&nbsp;&nbsp;&nbsp;&nbsp;老师';}else{echo '&nbsp;&nbsp;&nbsp;&nbsp;学生';}?>
								<span><?php echo date('m-d',$chengyuan[6]['addtime']) ?></span>
							</a>
						</a></li>
					</ul>
				</div>
			</div>
			<div class="main_bottom_left">
				<div class="index_exam">
					<div class="exam_top">
						<img src="img/index_list.jpg" class="img1"><span>热门考试</span>
						<ul>
							<?php
								foreach($re as $v){
									$na=$v['name'];
									echo "<li>";
									echo "<a href='test_kaoshi.php?text_name=$na'>";
									echo "<b>".$na."</b>";
									echo "<strong>".$v['num']."人做过"."</strong>";
									echo "<em>";
									echo date('m-d',$v['exam_addtime']);
									echo "</em>";
									echo "</a>";
									echo "</li>";
								}
								?>
						</ul>
					</div>
				</div>
			</div>
			<div class="main_bottom_right">
				<div class="index_exception">
					<div class="exception_top">
						<img src="img/index_list.jpg" class="img1"><span class="span100">学习经验</span>
						<div class="neirong">
							<div class="MenuBox">
									<?php
										foreach($jingyan as $jy){
											$pai++;
											echo "<li id='two$pai' onmouseover='secBoard($pai,10)'>";
											echo $jy['user_name'];
											echo "</li>";
										}									
									?>
							</div>
							<div class="ContentBox" id="ContentBox">
								<?php
										foreach($jingyan as $jy){
											$ming++;
											echo "<div id='con_two_$ming' class='divv'>";
											echo "<div class='Contentbox_con'>";
											echo "<form name='form100' action='dianzan.php' method='post' accept-charset='UTF-8'>";
											echo "<span class='span13'>";
											echo $jy['content'];
											echo "</span>";
											echo "<span class='span14'>";
											echo "<input name='addtime' type='hidden' value='{$jy['addtime']}'>";
											echo "<input name='user_na' type='hidden' value='{$jy['user_name']}'>";
											echo "<span class='span15'>";
											echo "<input name='radio101' type='radio' value='1'>";
											echo "</span>";
											echo "<span class='span16'>";
											echo '支持(';
											echo $jy['good'].")";
											echo "</span>";
											echo "<span class='span15'>";
											echo "<input name='radio101' type='radio' value='2'>";
											echo "</span>";
											echo "<span class='span16'>";
											echo '反对(';
											echo $jy['low'].")";
											echo "</span>";
											echo "</span>";
											echo "<span class='span18'>";
											echo "<input type='submit' name='image34'  class='input11'>";
											echo "</span>";
											echo "</form>";
											echo "</div>";
											echo "</div>";
										}									
									?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="index_foot">
			Copyright@2019<a href='info_my.php'>东北石油大学挑战杯比赛</a>
			<br /><a href="info_my.php">孙航</a> | <a href="info_my.php">施海鑫</a> | <a href="info_my.php">陈海益</a> | <a href="info_my.php">王泽</a> | <a href="info_my.php">关江涛</a> | 版权所有@由<a href="info_my.php">IT Club</a>技术支持
		</div>
	</div>
	<div class="page">
		<div id="zhu_bottom">
			<h2 class="zhuyao">学霸管理平台 friends</h2>
		</div>
		<a class="but_show" id="but" href="javascript:;"></a>
		<div id="zhu_box">
			<div class="bg"></div>
			<div class="nav2_bg"></div>
			<ul id="list_nav">       
				<li><a  class="show" href="javascript:;">关注</a></li>
				<li class="tab2"><a href="javascript:;">粉丝</a></li>
				<li class="tab3"><a href="rankling_list.php">排行</a></li>
				<li class="tab4"><a href="re_teacher.php">成员</a></li>
				<li class="tab5"><a href="geren.php">发帖</a></li>
			</ul>
			<a class='clos' id="btn_close"></a>
				<div class="box_right">
					<?php
						foreach($hao as $vo){
							$hao_id=$vo['friend_id'];//先获取好友id 
							$sql111="select * from user where id = :id";
							$yong=$db->query($sql111,array('id'=>$hao_id));
							$nam=$yong[0]['username'];
						?>
					     <div class="ge" onclick="youjian('<?php echo $nam?>')">
					     	<div class="fl" style="margin-right: 3px;">
					     		<img class="index_hao_img" src="<?php if($yong[0]['avatar']==null){
					     		echo "img/avatar.jpg";
					     	}else{echo "images/".$yong[0]['avatar'];}?>">
					     	</div>
					     	<ul class="fl">
					     		<li>
					     			<strong><?php echo $yong[0]['username']?></strong>
					     		</li>
					     		<li>
					     			<span class="span_hao"><?php echo tranTime($yong[0]['last_addtime']);?></span>
								</li>	
					     	</ul>
					     </div>
				     <?php }?>
				</div>
			</div>
			<input type="hidden" name="cun" value="" id="zhi"/>
			<input type="hidden" name="cun" value="<?php echo $_SESSION['user']['username']?>" id="cunname"/>
			<div id="xianshi">
				<ul>
					<li onclick="jinru()">他的空间</li>
					<li>和他pk</li>
					<li id="mingzi"></li>
					<li id="ding"><a href="javascript:;" class="top_a" id="top_a">X</a></li>					
				</ul>
				<div class="text_nei" id="liaotian"></div>
				<div class="chat">
					<span>颜色</span>
					<input type="color" name="color" id="color"/>
				</div>
				<div class="chat_content">
					<textarea class="text_con"  onKeyPress="if(event.keyCode==13) {document.getElementById('send').click();}" id="message" placeholder="请在这里输入聊天信息"></textarea>
					<input type="button" id="send" name="fayan" value="发言" class="fayan" onClick="send_message()">
				</div>
			</div>
		</div>
</body>
<script type="text/javascript" src="layer/layer.js"></script>
<script>
	
function jinru(){
	var name=mingzi.innerHTML;
	window.location.href='homepage.php?friend_name='+name;
}	

top_a.onclick=function(){
	xianshi.style.display='none';
}
	
function youjian(ev){
	xianshi.style.display='block';
	zhi.value=ev;
	mingzi.innerHTML=ev;
}

function send_message(){
	var message = document.getElementById('message').value;
	var name=zhi.value;
	var send=cunname.value;
	
	if(message.length<1){
		layer.msg('输入内容为空',{time:1000});
		return false;
	}	
	
	if(message != ''){            		
		send_request('message.php?message='+message+'&sender='+send+'&receiver='+name);
	    document.getElementById('message').value = '';               
    }
    
    var ming=mingzi.innerHTML;
    var s='';
    var str = '';
    var now_time=new Date();
    var iMonth = now_time.getMonth() + 1;
	var iDate = now_time.getDate();
	var iHours = now_time.getHours();
	var iMin = now_time.getMinutes();
	var iSec = now_time.getSeconds();
    str = iMonth + '月' + iDate + '日 ' + toTwo(iHours) + ' : ' + toTwo(iMin) + ' : ' + toTwo(iSec);
    s += "("+str+") >>";
	s += "<p>";    
	s += "我&nbsp;对&nbsp;" + "<span class='liao'>"+ming +"<span>"+"&nbsp;说:&nbsp;" +message;
	s += "</p>";
	
    var showmessage = document.getElementById("liaotian");
    showmessage.innerHTML += s;
    showmessage.scrollTop = showmessage.scrollHeight-showmessage.style.height;
    
}

function toTwo(n) {
	return n < 10 ? '0' + n : '' + n;
}

function send_request(url) {
    if (window.XMLHttpRequest) { 
        http_request = new XMLHttpRequest();
        if (http_request.overrideMimeType) {
            http_request.overrideMimeType('text/xml');
        }
    } else if (window.ActiveXObject) { 
        try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }
    if (!http_request) {
    	layer.msg('不能创建 XMLHttpRequest 对象!');
        return false;
    }
    
    send_request.onreadystatechange=function(){
    	if(http_request.readyState == 4 && http_request.status == 200){
    		
    	}
    }
    
    http_request.open('GET', url, false);
    http_request.send(null);
}

</script>
<script>
var my_name="<?php echo $_SESSION['user']['username'].''?>";
var last_time="<?php echo $last_time?>";	
var message_sum = 5;  
var maxId=0;        
var message_arr = new Array();
function show_message(){
	
	//效率上的一个优化
	if(xianshi.style.display=='none'){
		return false;
	}
	
	if (window.XMLHttpRequest) { 
        http_request = new XMLHttpRequest();
        if (http_request.overrideMimeType) {
            http_request.overrideMimeType('text/xml');
        }
    } else if (window.ActiveXObject) { 
        try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }
    if (!http_request) {
    	layer.msg('不能创建 XMLHttpRequest 对象!');
        return false;
    }
    
	function getLocalTime(nS) {     
	   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
	}    
    
   	http_request.onreadystatechange=function(){
   		if(http_request.readyState == 4 && http_request.status == 200){
   			eval('var data = '+http_request.responseText);
            var s = "";
            for(var i = 0 ; i < data.length;i++){
                s += "("+getLocalTime(data[i].addtime)+") >>";
                s += "<p class='liao_p'>";    
                s += "<span class='liao'>"+data[i].sender +"</span>" +"&nbsp;对&nbsp;我&nbsp;&nbsp;说：" + data[i].msg;
                s += "</p>";
				maxId = data[i].id;                  
            }
            var showmessage = document.getElementById("liaotian");
            showmessage.innerHTML += s;
            showmessage.scrollTop = showmessage.scrollHeight-showmessage.style.height;
   		}
   	}
   	
   	http_request.open('get','get_message.php?receiver='+my_name+'&last='+last_time+'&max_id='+maxId,false);
   	http_request.send(null);
}

setInterval("show_message()",5000);

</script>