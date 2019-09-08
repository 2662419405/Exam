<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	
	$my_name=$_GET['friend_name'];
	if($my_name==null){
		$friend_id   = $_GET['friend_id'];
			if($friend_id==null){
				$friend_id=$user['id'];
			}
	}else{
		$s="select * from user where username =:name";
		$mingzi=$db->query($s,array('name'=>$my_name));
		$friend_id=$mingzi[0]['id'];
	}
    
    //判断是否自己的空间
    if($user_id==$friend_id){
    	$chuan_id=$user_id;
    }else{
    	$chuan_id=$friend_id;
    }
    
    $friend_info = get_user_info($friend_id);
    $na=$friend_info['username'];
		    
    //分页
	$pageSize=5;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from post where post_type != 1 and username = :username order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql,array('username'=>$na));
	$toutal=$db->single("select count(*) from post where post_type != 1 and username = :username",array('username'=>$na));
	$yeshu=ceil($toutal/$pageSize);

    foreach($chaxun as $vo){
        $vo['avatar']  = $db->single('select avatar from user where id = :user_id',array('user_id'=>$vo['user_id']));
        //图片数据格式由字符串转化为数组
        if($vo['pictures']){
            $vo['pictures'] = explode(',',$vo['pictures']);
        }

        //转发数
        $vo['forward_count'] = $db->single('select count(*) from post where post_type = 2 and pid = '.$vo['id']);

        //评论数量
        $vo['comment_count'] = $db->single('select count(*) from post where post_type = 1 and pid = '.$vo['id']);

        //点赞数量
        $vo['praise_count']  = $db->single('select count(*) from praise where post_id = '.$vo['id']);

        //如果转发
        if(isset($vo['pid']) && $vo['post_type'] == 2){
            $parent  = array();
            $content = '';
            $pid = $vo['pid'];
            $parent  = $db->row('select * from post where id = '.$pid);//查找父级
            do{
                if(isset($parent) && $parent['post_type'] == 2){
                    //查找父级
                    $content = '@'.$parent['username'].':'.$parent['content'].'//'.$content;
                    $parent  = $db->row('select * from post where id = '.$parent['pid']);//查找父级
                    $flag = true;
                }else{
                    //图片数据格式由字符串转化为数组
                    if($parent['pictures']){
                        $parent['pictures'] = explode(',',$parent['pictures']);
                    }
                    $sub['parent'] = $parent;
                    $flag = false;
                }
            }while($flag === true);

            $sub['content'] = substr($content,0,-2);
            $vo['sub'] = $sub;
        }

        $lists[] = $vo;
    }
    
    include("view/header.html");
	?>
<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="layer/layer.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$('#follow,#cancel-follow').click(function(){
	        var friend_id = $(this).attr('value');
	        var friend_name=document.getElementById('hidden1').value;
	        $.post("follow.php",{friend_id:friend_id,friend_name:friend_name},function(re){
	            if(re == 1){
	                layer.msg('关注成功',{time:1000});
	            }else{
	                layer.msg('已取消',{time:1000});
	            }
	            window.location.reload();
	        });
	    });
	});
	
	/**检测字数**/
	function checknum(v, word) {
	    var len = 140 - v.length;
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
	    var check_result = checkWordsNumber(content);
	    if(check_result){
	        layer.msg(check_result);
	        return false;
	    }
	    /**获取图片路径,拼接成字符串**/
	    var pics = '';
	    $('.img_common').each(function(){
	        pics += $(this).attr('src') + ",";
	    });
	    if(pics){
	        pics = pics.substring(0,pics.length-1);
	    }
	
	    if(type == 'comment'){
	        type = 1;
	    }else if(type == 'forward'){
	        type = 2;
	    }else{
	        type = 0;
	    }
	
	    $.post("ajaxAction.php", {pid:pid,type:type,content:content,pictures:pics}, function(data) {
	        if (data == -1) {
	            layer.msg('请先登录',{time:1000},function(){
	                window.location.href = 'login.php';
	            });
	            return false;
	        }
	        layer.msg('发布成功',{time:1000},function(){
	            var index = parent.layer.getFrameIndex(window.name);
	            parent.location.reload();
	            parent.layer.close(index); 
	        });
	    })
	}
	function checkWordsNumber(content){
	    var len = content.length;
	    var message = '';
	    if (len == 0) {
	        message = "发布内容不能为空！";
	    }
	    if (len > 140) {
	        message = "发布内容不能超过140字！";
	    }
	    return message;
	}
	$(function(){
	
	    $(".weibo_list_bottom .weibo_list_bottom_message").click(function(){
	        var total = $(this).children('span').html();
	        var comment_list = $(this).parent().siblings(".weibo_comment").children(".comment_list");
	        if(comment_list.is(":hidden")){
	            if(total > 0 ){
	                var index = layer.msg('数据加载中', {icon: 16});
	                var pid = $(this).parent().attr('value');
	                $.post("getComment.php", {pid: pid}, function(jsdata) {
	                    var data = jsdata;
	                    $(data).each(function(){
	                        var str = '';
	                        str += '<div class="weibo_list weibo-comment" >';
	                        str += '<div class="weibo_list_top">';
	                        str += '<div class="weibo_list_head">';
	                        str += '<a><img class ="avatar" src="' + this.avatar + '"></a></div>';
	                        str += '<ul class="weibo-comment-ul">';
	                        str += '<li><b>' + this.username + '</b></li>';
	                        str += '<li><span>' + this.addtime + '</span></li>';
	                        str += '<li><p>' + this.content + '</p></li>';
	                        str += '</ul></div></div>';
	                        comment_list.append(str);
	                    });
	
	                    if(total > 5){
	                        var str_total = '';
	                        str_total += '<div class="weibo_comment_more">';
	                        str_total += '<a href="comment.php?post_id='+pid+'">后面还有'+ (total-5) +'条评论，点击查看全部></a></div>';
	                        comment_list.append(str_total);
	                    }
	                    layer.close(index);
	                }, "json");
	            }
	        }else{
	            comment_list.children().remove();
	        }
	        $(this).parent().siblings(".weibo_comment").slideToggle(200);
	    });
	
	    /** 展开与关闭 **/
	    $(".weibo_list_bottom .weibo_list_bottom_message").click(function(){
	        $(this).toggleClass("weibo_list_bottom_message_cur");
	    });
	
	    $(".my_friend_list button").click(function(){
	        $(this).toggleClass("my_friend_btn_click");
	    });
	
	    $(".my_head_message .show_btn").click(function(){
	        $(this).toggleClass("show_btn_on");
	    });
	
	    $(".weibo_list_top .weibo_list_head_collect").click(function(){
	        $(this).toggleClass("weibo_list_head_collect_cur");
	    });
	
	
	    /** 转发 **/
	    $('.forward').click(function(){
	        var pid = $(this).parent().attr('value');
	        //iframe层
	        layer.open({
	            type: 2,                            //弹出框
	            title: '转发微博',                   //标题
	            area:['700px','500px'],             //弹层宽高
	            shade: 0.5,                         //背景透明度
	            content: 'getForward.php?pid='+pid //iframe的url
	        });
	    });
	
	    /** 点赞 **/
	    $('.praise').click(function(){
	        var post_id = $(this).parent().attr('value');
	        var count   = $(this).children().text();
	        var that    = $(this);
	        $.post("praise.php",{post_id:post_id},function(re){
	            if(re == 1){
	                layer.msg('点赞成功！',{time:2000});
	                count++;
	                that.children().text(count);
	            }else{
	                layer.msg('您已经赞过啦！',{time:2000});
	            }
	        });
	    });
	});
	
	/**
	 * highslide展示图片效果
	 */
	$(function(){
	    hs.graphicsDir = 'highslide/graphics/';
	    hs.align = 'center';
	    hs.transitions = ['expand', 'crossfade'];
	    hs.wrapperClassName = 'dark borderless floating-caption';
	    hs.fadeInOut = true;
	    hs.dimmingOpacity = .75;
	
	    if (hs.addSlideshow) hs.addSlideshow({
	        interval: 3000,
	        repeat: false,
	        useControls: true,
	        fixedControls: 'fit',
	        overlayOptions: {
	            opacity: .6,
	            position: 'bottom center',
	            hideOnMouseOut: true
	        }
	    });
	});
</script>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main_nav">
		<div class="my_main_img">
			<img src="<?php echo get_cover_path($friend_info['avatar']) ?>">
		</div>
		<h4><?php echo $friend_info['username'] ?></h4>
		<div class="my_main_message">
			<ul class="fl">
	            <li>注册于：<?php echo date('Y-m-d',$friend_info['addtime']) ?></li>
	            <li><span>QQ：<?php echo $friend_info['qq'] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
	                <span>手机：<?php echo $friend_info['tel'] ?></span></li>
	        </ul>
		
			<?php if($_SESSION['user']['id'] == $friend_id){ ?>
	            <button  class="show_btn">
	                <a href="setting.php">
	                    个人主页
	                </a>
	            </button>
	        <?php }elseif(is_follow($_GET['friend_id']) == true){ ?>
	            <button id="cancel-follow" class="show_btn" value="<?php echo $friend_info['id'] ?>">
	                取消关注
	            </button>
	            <input type="hidden" id="hidden1" value="<?php echo $na ?>"/>
	        <?php }else { ?>
	            <button id="follow" class="show_btn" value="<?php echo $friend_info['id'] ?>">
	                关注
	            </button>
	            <input type="hidden" id="hidden1" value="<?php echo $na ?>"/>
	        <?php } ?>
	        	
	        <div class="my_info_list fr">
	            <div class="fr">
	                <ul>
	                    <li><span><?php echo $friend_info['follows_num']; ?></span></li>
	                    <li>关注</li>
	                </ul>
	                <ol></ol>
	                <ul>
	                    <li>
	                        <span><?php echo $friend_info['fans_num']; ?></span>
	                    </li>
	                    <li>粉丝</li>
	                </ul>
	                <ol></ol>
	                <ul>
	                    <li><span><?php echo $friend_info['posts_num']; ?></span></li>
	                    <li>帖子</li>
	                </ul>
	            </div>
	        </div>
		</div>
	</div>
	<div class="main">
		<div class="left1">
			<div id="header">
			    <ul>
			        <li class="normal"><a href="javascript:;"><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的帖子</a></li>
			        <li class="normal"><a href="atMe.php?friend_id=<?php echo $chuan_id?>">@<?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的</a></li>
			        <li class="normal"><a href="friends.php?friend_id=<?php echo $chuan_id?>"><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的关注</a></li>
			        <li class="normal"><a href="myFans.php?friend_id=<?php echo $chuan_id?>"><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的粉丝</a></li>
			        <li class="normal"><a href="myPraise.php?friend_id=<?php echo $chuan_id?>"  ><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的赞</a></li>
			        <li class="normal"><a href="liuyanban.php?friend_id=<?php echo $chuan_id?>"  ><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的留言板</a></li>
			    </ul>
			    <div id="btn_bg">
			    	<ul>
				        <li class="active1"><a href="javascript:;"><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的帖子</a></li>
			        <li class="active1"><a href="atMe.php?friend_id=<?php echo $chuan_id?>">@<?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的</a></li>
			        <li class="active1"><a href="friends.php?friend_id=<?php echo $chuan_id?>"  ><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的关注</a></li>
			        <li class="active1"><a href="myFans.php?friend_id=<?php echo $chuan_id?>"><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的粉丝</a></li>
			        <li class="active1"><a href="myPraise.php?friend_id=<?php echo $chuan_id?>"  ><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的赞</a></li>
			        <li class="active1"><a href="liuyanban.php?friend_id=<?php echo $chuan_id?>"  ><?php if($_GET['friend_id']==null){echo "我";}else{echo "他";}?>的留言板</a></li>
				    </ul>
			    </div>
			</div>
			<script>
				var g_iSpeed=0;
				var g_iCur=0;
				var g_oTimer=null;
				var oDiv=document.getElementById('btn_bg');
				var oUl=oDiv.getElementsByTagName('ul')[0];
				var aLi=document.getElementById('header').getElementsByTagName('ul')[0].getElementsByTagName('li');
				var i=0;
				
				for(i=0;i<aLi.length;i++)
				{
					aLi[i].miaovIndex=i;
					aLi[i].onmouseover=startMove;
				}
				
				g_iCur=-oUl.offsetLeft;
				
				function startMove()
				{
					var oDiv=document.getElementById('btn_bg');
					var oUl=oDiv.getElementsByTagName('ul')[0];
					
					oDiv.style.left=80+g_iCur+'px';
					oUl.style.left=-g_iCur+'px';
					if(g_oTimer)
					{
						clearInterval(g_oTimer);
					}
					g_oTimer=setInterval("doMove("+this.offsetLeft+")", 35);
				}
				
				function doMove(iTarget)
				{
					var oDiv=document.getElementById('btn_bg');
					var oUl=oDiv.getElementsByTagName('ul')[0];
					
					g_iSpeed+=(iTarget+oUl.offsetLeft)/5;
					g_iSpeed*=0.7;
					
					if(Math.abs(g_iSpeed)>60)
					{
						g_iSpeed=g_iSpeed>0?60:-60;
					}
					
					g_iCur+=g_iSpeed;
					
					if(g_iCur>0)
					{
						g_iCur=Math.ceil(g_iCur);
					}
					else
					{
						g_iCur=Math.floor(g_iCur);
					}
					
					if(Math.abs(iTarget-g_iCur)<1 && Math.abs(g_iSpeed)<1)
					{
						clearInterval(g_oTimer);
						g_oTimer=null;
					}
					else
					{
						oDiv.style.left=80+g_iCur+'px';
						oUl.style.left=-g_iCur+'px';
					}
				}
			</script>
			<div class="jiaceng">
			</div>
			<?php if(!isset($lists)){ ?>
            <div class="empty">
                <p>还没有帖子哦！</p>
            </div>
            <?php }else {?>
			<?php foreach($lists as $v) { ?>
			    <div class="weibo_list">
			        <div class="weibo_list_top">
			            <div class="weibo_list_head">
			                <a href="<?php echo "homepage.php?friend_id=".$v['user_id'] ?>">
			                    <img class="avatar"   src="<?php echo get_cover_path($v['avatar']) ?>"  />
			                </a>
			            </div>
			
			            <ul>
			                <li><b><?php echo $v['username'] ?></b></li>
			                <li><span><?php echo tranTime($v['addtime']); ?></span></li>
			                <li>
			                    <p>
			                        <?php
			                        if($v['post_type'] == 2){
			                            echo $v['content'].'//'.$v['sub']['content'];
			                        }else{
			                            echo ubbReplace($v['content']);
			                        }
			                        ?>
			                    </p>
			                </li>
			                <?php  if($v['pictures']){ ?>
			                    <li>
			                        <div class="highslide-gallery">
			                            <?php foreach($v['pictures'] as $pic){ ?>
			                                <a href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
			                                    <img src="<?php echo $pic; ?>"  title="点击放大" />
			                                </a>
			                            <?php } ?>
			                    </li>
			                <?php } ?>
			            </ul>
			        </div>
			
			        <?php if($v['post_type'] == 2 ){ ?>
			            <div class="weibo_list_top" style="background: #F2F2F5">
			                <ul>
			                    <li><b><?php echo $v['sub']['parent']['username'] ?></b></li>
			                    <li><span><?php echo tranTime($v['sub']['parent']['addtime']) ?></span></li>
			                    <li>
			                        <p>
			                            <?php echo ubbReplace($v['sub']['parent']['content']) ?>
			                        </p>
			                    </li>
			                    <?php  if($v['sub']['parent']['pictures']){ ?>
			                        <li>
			                            <div class="highslide-gallery">
			                                <?php foreach($v['sub']['parent']['pictures'] as $pic){ ?>
			                                    <a href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
			                                        <img src="<?php echo $pic; ?>"  title="点击放大" />
			                                    </a>
			                                <?php } ?>
			                        </li>
			                    <?php } ?>
			                </ul>
			            </div>
			        <?php } ?>
			
			        <div class="weibo_list_bottom" value="<?php echo $v['id'] ?>" >
			            <a class="forward" href="javascript:;">转发
			                ( <?php echo $v['forward_num'] ?> )
			            </a>
			            <!--评论-->
			            <a class="weibo_list_bottom_message">评论
			                ( <span> <?php echo $v['comment_num'] ?> </span> )
			            </a>
			            <!--点赞-->
			            <a class="praise" href="javascript:;">点赞
			                ( <span> <?php echo $v['praise_num'] ?> </span> )
			            </a>
			        </div>
			        <div class="weibo_comment">
			            <div class="send-weibo">
			                <div class="ui form" style="overflow: auto">
			                    <div class="field">
			                        <div class="weibo-text">
			                            <textarea  name="content" id="saybox_<?php echo $v['id'] ?>" onkeyup="checknum(this.value, <?php echo $v['id'] ?>)"  rows="5" ></textarea>
			                        </div>
			                    </div>
			                </div>
			                <div class="send-action">
			                        <span style="color: #d79f34;">
			                            评论~~~
			                        </span>
			                    <div class="release">
			                        <span class="countTxt">还可输入<em id="sayword_<?php echo $v['id'] ?>" class="count">140</em>字</span>
			                        <button class="ui teal button" onclick="saysub(<?php echo $v['id'] ?> , 'comment')">发布 </button>
			                    </div>
			                </div>
			            </div>
			
			            <div class="comment_list"></div>
			        </div>
			    </div>
			<?php } ?>
			<?php } ?>
			<div class="ls">
				<?php include_once("view/page.php"); ?>
			</div>
		</div>
		<?php include_once("view/right.php"); ?>
		<?php include_once("view/footer.html"); ?>
	</div>
</body>
</html>    
