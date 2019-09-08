<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	$flag=$_GET['friend_id'];//这个用户的id
	if(empty($_GET['friend_id'])){
		$flag=$_SESSION['user']['id'];
	} 
	$friend=$db->row("select * from user where id = :user_id",array('user_id'=>$flag));
	
	//截取滑动的留言内容
	$num=15;
	$sql1="select * from liuyan where name = :username order by id desc limit :num";
	$quanbu=$db->query($sql1,array('username'=>$friend['username'],'num'=>$num));
	
	//显示内容
	$num1=50;
	$sql="select * from liuyan where name = :username order by id desc limit :num";
	$chaxun = $db->query($sql,array('username'=>$friend['username'],'num'=>$num1));
	
	include("view/header.html");
	?>

<script src="js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script>
window.onload=function()
{
	var oDiv=document.getElementById('div_liu');
	var aA=oDiv.getElementsByTagName('a');
	var i=0;
	for(i=0;i<aA.length;i++)
	{
		aA[i].pause=1;
		aA[i].time=null;
		initialize(aA[i]);
		aA[i].onmouseover=function()
		{
			this.pause=0;	
		};
		aA[i].onmouseout=function()
		{
			this.pause=1;
		};
	}
	setInterval(starmove,30);//定义块的速度 
	function starmove()
	{
		for(i=0;i<aA.length;i++)
		{
			if(aA[i].pause)
			{
				domove(aA[i]);
			}
		}
	}
	
	function domove(obj)
	{
		if(obj.offsetTop<=-obj.offsetHeight)
		{
			obj.style.top=oDiv.offsetHeight+"px";
			initialize(obj);
		}
		else
		{
			obj.style.top=obj.offsetTop-obj.ispeed+"px";	
		}
	}
	function initialize(obj)
	{
		var iLeft=parseInt(Math.random()*oDiv.offsetWidth);
		var scale=Math.random()*1+1;
		var iTimer=parseInt(Math.random()*2000);
		obj.pause=0;

		obj.style.fontSize=12*scale+'px';

		if((iLeft-obj.offsetWidth)>0)
		{
			obj.style.left=iLeft-obj.offsetWidth+"px";
		}
		else
		{
			obj.style.left=iLeft+"px";
		}
		clearTimeout(obj.time);
		obj.time=setTimeout(function(){
			obj.pause=1;
		},iTimer);
		obj.ispeed=Math.ceil(Math.random()*4)+1;
	}
};
/**检测字数：大于0，小于140字**/
function checkWordsNumber(content){
    var len = content.length;
    var message = '';
    if (len == 0) {
        message = "发布内容不能为空！";
    }
    if (len > 70) {
        message = "发布内容不能超过70字！";
    }
    return message;
};

/**检测字数**/
function checknum(v, word) {
    var len = 70 - v.length;
    $('#sayword_' + word).text(len);
    if (len < 0) {
        $('#sayword_' + word).css({
            "color": "red"
        });
    }
}
	
/**确认发布**/
function saysub(pid,type) {
    var content = $('#saybox_'+ pid).val();
    var name=$('#btn_name').val();
    var pic=$('#btn_touxiang').val();
    var name1=$('#btn_name1').val();
    var pic1=$('#btn_touxiang1').val();
    var check_result = checkWordsNumber(content);
    if(check_result){
        layer.msg(check_result);
        return false;
    }

    $.post("ajaxLiuyan.php", {sendName:name1,name:name,content:content}, function(data) {
        if (data == -1) {
            layer.msg('提交失败',{time:1000});
            return false;
        }
        layer.msg('提交成功',{time:1000});
        addNew(name1,content,pic1);
    })
}

function addNew(sName, sMsg ,touxiang)
{
	var shijian=biao();
	var oDiv=document.getElementById('content');
	var oUl=oDiv.getElementsByTagName('ul')[0];
	var oTmpUl=document.getElementById('tmp_container');
	var oLi=null;
	var oTimer=null;
	var iHeight=0;
	
	oLi=document.createElement('li');
	oLi.innerHTML='<div class="pic"><a href="#"><img src='+touxiang+' class="fl"></a><ul><li><strong>'+sName+'</strong></li><li><i>'+shijian+'</i></li></ul><div class="pic1">'+sMsg+'<div>';
	
	oTmpUl.appendChild(oLi);
	iHeight=oLi.offsetHeight+149;
	
	oLi.innerHTML='';
	oLi.style.height='0px';
	
	if(oUl.getElementsByTagName('li').length==0)
	{
		oUl.appendChild(oLi);
	}
	else
	{
		oUl.insertBefore(oLi, oUl.getElementsByTagName('li')[0]);
	}
	
	var alpha=0;
	oTimer=setInterval
	(
		function ()
		{
			var h=parseInt(oLi.style.height)+2;
			
			if(h>=iHeight)
			{
				h=iHeight;
				clearInterval(oTimer);
				oLi.innerHTML='<div class="pic"><a href="#"><img src='+touxiang+' class="fl"></a><ul><li><strong>'+sName+'</strong></li><li><i>'+shijian+'</i></li></ul><div class="pic1">'+sMsg+'<div>';
				
				oLi.style.filter="alpha(opacity:0)";
				oLi.style.opacity="0";
				
				oTimer=setInterval
				(
					function ()
					{
						alpha+=10;
						oLi.style.filter="alpha(opacity:"+alpha+")";
						oLi.style.opacity=alpha/100;
						
						if(alpha==100)
						{
							oLi.style.filter="";
							oLi.style.opacity="";
							
							clearInterval(oTimer);
						}
					},15
				);
			}
			oLi.style.height=h+'px';
		},10
	);
}

function biao() {

	var date = new Date();
	
	var iYear = date.getFullYear();
	var iMonth = date.getMonth() + 1;
	var iDate = date.getDate();
	var iHours = date.getHours();
	var iMin = date.getMinutes();
	var iSec = date.getSeconds();
	str = iYear + '-' + iMonth + '-' + iDate + ' ' + toTwo(iHours) + ':' + toTwo(iMin) + ':' + toTwo(iSec);
	return str;
	
}

function toTwo(n) {
	return n < 10 ? '0' + n : '' + n;
}	
</script>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
		<div class="main">
			<div class="left1">
				<div class="liuyanban_content">
					<div id="div_liu">
						<?php if(isset($quanbu)){ ?>
							<?php foreach($quanbu as $v) {?>
								<a href="javascript:;"><?php echo $v['content']?></a>
							<?php }?>
						<?php } ?>
					</div>
				</div>
				<div class="liuyanban_index">
					<?php if(!isset($chaxun)){ ?>
		            <div class="empty">
		                <p>还没有留言哦！</p>
		            </div>
		            <?php }else {?>
						<div class="liuyanban">
							<h1><?php echo $friend['username']?>的留言板</h1>
						</div>
						<div class="start_liuyan">
							<dl>
								<dt>快来留个言吧~~~</dt>
								<dd>
									<input id='btn_name1' class="text" type="hidden" value="<?php echo $user['username']?>"/>
									<input id='btn_touxiang1' class="text" type="hidden" value="<?php if($user['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$user['avatar'];}?>"/>
									
									<input id='btn_name' class="text" type="hidden" value="<?php echo $friend['username']?>"/>
									<input id='btn_touxiang' class="text" type="hidden" value="<?php if($friend['avatar']==null){echo "img/avatar.jpg";}else{echo "images/".$friend['avatar'];}?>"/>
									</dd>
						        <dd><textarea  name="content" id="saybox_0"   onkeyup="checknum(this.value, '0')" class="btn_msg" placeholder="  留个言吧~~"></textarea></dd>
						        <dd style="margin-top: 15px;">
						        	<div class="release">
						            <span class="countTxt">还可输入<em id="sayword_0" class="count">70</em>字</span>
						            <button class="ui teal button" onclick="saysub(0)">发布 </button>
						        </div>
						        </dd>
							</dl>							
						</div>
						<div id="content">
					        <ul>
					        	<?php
					        		foreach($chaxun as $v){
					        			//对数据进行加载
					        			$mingzi=$v['username'];
					        			$neirong=$v['content'];
					        			$shijian=$v['addtime'];
					        			$sq="select * from user where username = :mingzi";
					        			$touxiang=$db->row($sq,array('mingzi'=>$mingzi));
					        			$tou=$touxiang['avatar'];
					        			if($tou==null){
					        				$tou='img/avatar.jpg';
					        			}else{
					        				$tou="images/".$tou;
					        			}
					        			echo "<li>";
					        			echo "<div class='pic'>";
					        			echo "<a>";
					        			echo "<img class='fl' src='$tou'>";
					        			echo "</a>";
					        			echo "<ul class='fl'>";
					        			echo "<li>";
					        			echo "<strong>";
					        			echo $mingzi;
					        			echo "</strong>";
					        			echo "</li>";
					        			echo "<li>";
					        			echo tranTime($shijian);
					        			echo "</li>";
					        			echo "</ul>";
					        			echo "<div class='pic1'>";
					        			echo $neirong;
					        			echo "</div>";
					        			echo "</div>";
					        			echo "</li>";
					        		}?>
					        </ul>
					    </div>			            	
					<?php }?>
				</div>
				<ul id="tmp_container" style="height:0px; overflow:hidden;"></ul>
			</div>
			<?php include_once("view/right.php"); ?>
			<?php include_once("view/footer.html"); ?>
		</div>
	</body>
</html>