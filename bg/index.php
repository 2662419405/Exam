<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("bg_view/header.html");
	
	$sql="select * from sort order by true_sum desc limit 1";
	$paiming=$db->query($sql);
	
	$sql1="select * from user order by fans_num desc limit 1";
	$fensi=$db->query($sql1);
	
	$sql4="select * from user order by follows_num desc limit 1";
	$guanzhu=$db->query($sql4);
	
	$sql2="select * from user order by posts_num desc limit 1";
	$fatie=$db->query($sql2);
	
	$sql3="select * from today limit 1";
	$today=$db->query($sql3);
	
	$suiji=$db->single("select count(*) from exam_problem");
	$hot=$db->single("select count(*) from exam_hot");
	$kaoshi=$db->single("select count(*) from exam_zhuanye group by name");
	
	$ketang=$db->single("select count(*) from exam_zhuanye group by chinese");
	$hot_bao=$db->single("select count(*) from exam_hot group by chinese");
	
	//获取今日状况
	$todaystart = strtotime(date('Y-m-d'.'00:00:00',time()));
	$todayend = strtotime(date('Y-m-d'.'00:00:00',time()+3600*24));
	$timestart = strtotime(date('Y-m-d'.'00:00:00',time()-3600*24));
	$jinri_zhuce = $db->single("select count(*) from user where addtime between :shijian and :jiezhi ",array('shijian'=>$todaystart,'jiezhi'=>$todayend));
	$jinri_denglu = $db->single("select count(*) from user where last_addtime between :shijian and :jiezhi ",array('shijian'=>$todaystart,'jiezhi'=>$todayend));
	$zuori_zhuce = $db->single("select count(*) from user where addtime between :shijian and :jiezhi ",array('shijian'=>$timestart,'jiezhi'=>$todaystart));
	$zuori_denglu = $db->single("select count(*) from user where last_addtime between :shijian and :jiezhi ",array('shijian'=>$timestart,'jiezhi'=>$todaystart));
	
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
            	描述：中心内容
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>网站总览</h4>
            			</div>
            			<div class="box_content">
            				<div class="form_group">
        						<label class="clo_sm">网站名称&nbsp;:</label>
        						<div class="clo_sm_5">
        							学霸养成平台
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">当前包含的课堂科目&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $ketang?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">当前包含的热门科目&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $hot_bao?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">当前随机题库数量&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $suiji?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">当前热门题库数量&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $hot?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">当前拥有的考试数量&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $kaoshi?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">今日注册人数&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $jinri_zhuce."&nbsp;&nbsp;(".$zuori_zhuce.")&nbsp;&nbsp;"."昨日";?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">今日登录人数&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $jinri_denglu."&nbsp;&nbsp;(".$zuori_denglu.")&nbsp;&nbsp;"."昨日";?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">做题排行榜第一名&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $paiming[0]['username']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">粉丝排行榜第一名&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $fensi[0]['username']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">关注排行榜第一名&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $guanzhu[0]['username']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">发帖排行榜第一名&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $fatie[0]['username']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">完成的考试数量&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $today[0]['kaoshi_sum']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">注册的学生数量&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $today[0]['zhuche_sum']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">完成的考题数量&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $today[0]['shijuan_sum']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">共有的发帖数量&nbsp;:</label>
        						<div class="clo_sm_5">
        							<?php echo $today[0]['laoshi_sum']?>
        						</div>
        					</div>
        					<div class="form_group">
        						<label class="clo_sm">开发者名单&nbsp;:</label>
        						<div class="clo_sm_5">
        							孙航，施海鑫，王泽，陈海益，关江涛
        						</div>
        					</div>
            			</div>
            		</div>
            	</div>
            </div>
		</div>
	</div>
</body>
</html>