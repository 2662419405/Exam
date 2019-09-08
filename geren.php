<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	
	//分页
	$pageSize=5;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from post where post_type != 1 order by addtime desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$chaxun = $db->query($sql);
	$toutal=$db->single("select count(*) from post where post_type != 1");
	$yeshu=ceil($toutal/$pageSize);
	
	foreach($chaxun as $vo){
        if($vo['pictures']){
            $vo['pictures'] = explode(',',$vo['pictures']);
        }

        //如果转发
        if(isset($vo['pid']) && $vo['post_type'] == 2){
            $parent  = array();
            $content = '';
            $pid = $vo['pid'];
            $parent  = $db->row('select * from post where id = '.$pid);
            do{
                if(isset($parent) && $parent['post_type'] == 2){
                    $content = '@'.$parent['username'].':'.$parent['content'].'//'.$content;
                    $parent  = $db->row('select * from post where id = '.$parent['pid']);
                    $flag = true;
                }else{
                    if($parent['pictures']){
                        $parent['pictures'] = explode(',',$parent['pictures']);
                    }
                    $sub['parent'] = $parent;
                    $flag = false;
                }
            }while($flag === true);
            //去除结尾的“//”
            $sub['content'] = substr($content,0,-2);
            $vo['sub'] = $sub;
        }
        $lists[] = $vo;
    }
	
	?>
<script type="text/javascript" src="highslide/highslide-with-gallery.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="layer/layer.js"></script>
<script>
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

/**选择好友**/
function chooseFriend(username){
    var content = $('textarea').val();
    content = content + '@'+username + ' ';
    $('#saybox_0').val(content);
    $('.interest-link').hide();
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
/**检测字数：大于0，小于140字**/
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
                        str += '<a href=homepage.php?friend_id='+this.user_id+'><img class ="avatar" src="' + this.avatar + '"></a></div>';
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
            title: '转发帖子',                   //标题
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
        interval: 5000,
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
	<div class="main">
		<div class="left l">
			<script type="text/javascript" src="js/jquery.qqFace.js"></script>
			<script>
			    $(function(){
			        $('.emotion').qqFace({
			            id : 'facebox', 
			            assign:'saybox_0', 
			            path:'face/'
			        });
			    });
			</script>
			<div class="send-weibo" style="box-shadow: 2px 2px 5px rgba(0,0,0,0.35);">
			    <div class="ui form" style="overflow: auto">
			        <div class="field">
			            <div class="content-title" style="font-size: 16px; color: #d79f34; padding: 8px 0 4px 0;">
			                随时随地，想发就发~~~
			            </div>
			            <div class="weibo-text">
			                <textarea  name="content" id="saybox_0"   onkeyup="checknum(this.value, '0')"  rows="5" onKeyPress="if(event.keyCode==13) {document.getElementById('fabu').click();}"></textarea>
			            </div>
			        </div>
			    </div>
			    <div class="send-action">
			        <span>
			            <a href="javascript:;">
			                <span class="emotion" onclick="emotion()">
			                    <i class="smile large icon"><img src="img/index_bg1.jpg"></i>表情
			                </span>
			            </a>
			        </span>
			        <span>
			            <a class="at-friend" id="A2"><i class="at large icon "><img src="img/index_bg2.jpg"></i>一下</a>
			        </span>
			        <span>
			            <a id="btn3" href="javascript:;"><i class="file image outline large icon"></i><img src="img/index_bg3.jpg" class="index_img11">图片</a>
			        </span>
			        <div class="release">
			            <span class="countTxt">还可输入<em id="sayword_0" class="count">140</em>字</span>
			            <button class="ui teal button" onclick="saysub(0)" id="fabu">发布 </button>
			        </div>
			    </div>
			    <div class="interest-link" style="display: none" id="tu1">
			        <div class="interest-search-link">好友列表</div>
			        <div class="interest-scroll">
			            <div id="friends" class="interest-scroll-content">
			                <!--@好友列表-->
			                <?php
			                    $user_lists = $db->query('SELECT username FROM friends where user_id = :user_id and status = 1',array('user_id'=>$user['id']));
			                    foreach ($user_lists as $v) { ?>
			                    <div class="interest-search-txt">
			                        <a href="javascript:;"  onclick="chooseFriend('<?php echo $v['username']?>')" >
			                            <?php echo $v['username']?>
			                        </a>
			                    </div>
			                <?php } ?>
			            </div>
			        </div>
			    </div>
			    
			</div>
			<div class="photo_upload_box_outside" id="photo_upload_box_outside" tabindex="2000">
				    <div class="photo_upload_box">
				        <a class="photo_upload_close"href="javascript:void(0);"onclick="photo_upload_close()"></a>
				        <h1>本地上传</h1>
				        <p class="upload_num">共<span id="uploaded_length">0</span>张，还能上传<span id="upload_other">9</span>张</p>
				        <ul id="ul_pics" class="ul_pics clearfix">
				            <li id="local_upload"><img src="img/local_upload.png" id="btn2"/></li>
				        </ul>
				        <div class="arrow_layer">
				            <span class="arrow_top_area"><i class="arrow_top_bg"></i><em class="arrow_top"></em></span>
				        </div>
				    </div>
				</div>
				
				<script type="text/javascript" src="js/plupload.full.min.js"></script>
			    <script type="text/javascript">
			    	var oA2=document.getElementById('A2');
			    	oA2.onclick=function(){
			    		if(tu1.style.display=='block'){
				    		tu1.style.display='none';
				    	}else{
				    		tu1.style.display='block';
				    	}
			    	}
			    	var upload_total = 9;
				    var uploader = new plupload.Uploader({
				        runtimes: 'gears,html5,html4,silverlight,flash', 
				        browse_button: ['btn3', 'btn2'], 
				        url: "upload.php", 
				        flash_swf_url: 'js/Moxie.swf',
				        silverlight_xap_url: 'js/Moxie.xap', 
				        filters: {
				            max_file_size: '5mb',
				            mime_types: [
				                {title: "files", extensions: "jpg,png,gif,jpeg"}
				            ]
				        },
				        multi_selection: true, 
				        init: {
				            FilesAdded: function(up, files) { 
				                var length_has_upload = $("#ul_pics").children("li").length;
				                if (files.length >= upload_total) { 
				                    $("#local_upload").hide();
				                }
				                var li = '';
				                plupload.each(files, function(file) { 
				                    if (length_has_upload <= upload_total) {
				                        li += "<li class='li_upload' id='" + file['id'] + "'><div class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
				                    }
				                    length_has_upload++;
				                });
				                $("#ul_pics").prepend(li);
				                uploader.start();
				            },
				            UploadProgress: function(up, file) {
				                var percent = file.percent;
				                $("#" + file.id).find('.bar').css({"width": percent + "%"});
				                $("#" + file.id).find(".percent").text(percent + "%");
				            },
				            FileUploaded: function(up, file, info) { 
				                showPhotoUploadBox($('#btn3'));
				                var uploaded_length = $(".img_common").length;
				                if (uploaded_length <= upload_total) {
				                    var data = eval("(" + info.response + ")");//解析返回的json数据
				                    $("#" + file.id).html("<input type='hidden'name='pic[]' value='" + data.pic + "'/><input type='hidden'name='pic_name[]' value='" + data.name + "'/>\n\
				                <img class='img_common' src='" + data.pic + "'/><span class='picbg'></span><a class='pic_close' onclick=delPic('" + data.pic + "','" + file.id + "')></a>");
				                }
				                showUploadBtn();
				            },
				            Error: function(up, err) { 
				                alert(err.message);
				            }
				        }
				    });
				    uploader.init();
				
				    function delPic(pic, file_id) { 
				        $.post("deletePic.php", {pic: pic}, function(data) {
				            $("#" + file_id).remove();
				            showUploadBtn();
				        })
				    }
				    function showUploadBtn() {
				        var uploaded_length = $(".img_common").length;
				        $("#uploaded_length").text(uploaded_length);
				        var other_length = (upload_total - uploaded_length) > 0 ? upload_total - uploaded_length : 0;
				        $("#upload_other").text(other_length);
				        var uploaded_length = $(".img_common").length;
				        if (uploaded_length >= upload_total) {
				            $("#local_upload").hide();
				        } else {
				            $("#local_upload").show();
				        }
				    }
				    function showPhotoUploadBox(obj) { 
				        var left = obj.offset().left;
				        var top = obj.offset().top + 26;
				        $("#photo_upload_box_outside").css({"left": left, "top": top}).show()
				    }
				    function photo_upload_close() {
				        $("#photo_upload_box_outside").fadeOut(500, function() {
				            $(".li_upload").remove();
				        })
				    }
			    </script>
			<div class="photo">
				<input type="radio" name="btn" id="img1" checked/>
		        <div class="control">
		            <div class="image"><img src="img/1.jpg"/></div>
		            <div class="nav1">
		                <label for="img6" class="up leftjianbian"><</label>
		                <label for="img2" class="down rightjianbian">></label>
		            </div>
		        </div>
		        <input type="radio" name="btn" id="img2"/>
		        <div class="control">
		            <div class="image"><img src="img/2.jpg"/></div>
		            <div class="nav1">
		                <label for="img1" class="up leftjianbian"><</label>
		                <label for="img3" class="down rightjianbian">></label>
		            </div>
		        </div>
		        <input type="radio" name="btn" id="img3"/>
		        <div class="control">
		            <div class="image"><img src="img/3.jpg"/></div>
		            <div class="nav1">
		                <label for="img2" class="up leftjianbian"><</label>
		                <label for="img4" class="down rightjianbian">></label>
		            </div>
		        </div>
		        <!--//4-->
		        <input type="radio" name="btn" id="img4"/>
		        <div class="control">
		            <div class="image"><img src="img/4.jpg"/></div>
		            <div class="nav1">
		                <label for="img3" class="up leftjianbian"><</label>
		                <label for="img5" class="down rightjianbian">></label>
		            </div>
		        </div>
		        <!--//5-->
		        <input type="radio" name="btn" id="img5"/>
		        <div class="control">
		            <div class="image"><img src="img/5.jpg"/></div>
		            <div class="nav1">
		                <label for="img4" class="up leftjianbian"><</label>
		                <label for="img6" class="down rightjianbian">></label>
		            </div>
		        </div>
		        <!--//6-->
		        <input type="radio" name="btn" id="img6"/>
		        <div class="control">
		            <div class="image"><img src="img/6.jpg"/></div>
		            <div class="nav1">
		                <label for="img5" class="up leftjianbian"><</label>
		                <label for="img1" class="down rightjianbian">></label>
		            </div>
		        </div>
		        <div class="dots">
		            <label for="img1" class="dot" id="dot1"></label>
		            <label for="img2" class="dot" id="dot2"></label>
		            <label for="img3" class="dot" id="dot3"></label>
		            <label for="img4" class="dot" id="dot4"></label>
		            <label for="img5" class="dot" id="dot5"></label>
		            <label for="img6" class="dot" id="dot6"></label>
		        </div>
			</div>
			<script>
				//轮播的js
				var oIm=document.getElementsByClassName('image');
				for(var i=0;i<oIm.length;i++){
					oIm[i].onclick=function(){
						window.location.href='test.php';
					}
				}
				var j=0;
				var oDown=document.getElementsByClassName('down');
				var len=oDown.length;
				setInterval(function(){
					oDown[j].click();
					j++
					if(j==len){
						j=0;
					}
				},6000);
			</script>
			<h4 class="weibo_list_title">全部帖子</h4>
			<?php if(!isset($lists)){ ?>
            <div class="empty">
                <p>还没有帖子哦！</p>
            </div>
            <?php }else {?>
			<?php foreach($lists as $v){
				$avatar = $db->single('select avatar from user where id = :user_id',
                                array('user_id'=>$v['user_id']));
				 ?>
			    <div class="weibo_list">
			        <div class="weibo_list_top">
			            <div class="weibo_list_head">
			                <a href="<?php echo "homepage.php?friend_id=".$v['user_id'] ?>">
			                    <img class="avatar"    src="<?php echo get_cover_path($avatar) ?>" />
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
			                                <a id="aaaa" href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
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
			                                    <a id="aaaa" href="<?php echo $pic; ?>" class="highslide" onclick="return hs.expand(this)">
			                                        <img src="<?php echo $pic; ?>"  title="点击放大" />
			                                    </a>
			                                <?php } ?>
			                        </li>
			                    <?php } ?>
			                </ul>
			            </div>
			        <?php } ?>
			
			        <div class="weibo_list_bottom" value="<?php echo $v['id'] ?>" >
			            <!--转发-->
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
			            <div class="send-weibo" style="background: rgba(0,0,0,0); border-bottom: 3px solid rgba(225,225,225,0.6);">
			                <div class="ui form">
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
			<?php	} ?>
		</div>
		<?php include_once("view/right.php"); ?>
		<?php include_once("view/footer.html");?>	
	</div>
</body>