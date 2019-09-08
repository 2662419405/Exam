<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	$yonghu_id=$_GET['yonghu_id'];
	if($yonghu_id==null){
		echo "<head><meta charset='utf-8'></head>";
	   	echo "<script>window.location.href='index.php'; alert('没有该用户');</script>";
	}
	
	$sql="select * from user where id = :id";
	$yonghu=$db->query($sql,array('id'=>$yonghu_id));	
	
	//查询他的排名
	$sql1="select * from sort order by true_sum desc";
	$sort=$db->query($sql1);
	$paiming=0;
	
	foreach($sort as $so){
		if($so['username']==$yonghu[0]['username']){
			break;
		}else{
			$paiming++;
		}
	}
	
	/*
	 * 影响力采用数据分析
	 * 一点粉丝增加10点影响力，一个正确的题增加2分，一个错题增加1分
	 * 一点发帖增加1分，获得一个转发增加5分，一个评论增加3分,一个点赞增加1分
	 * 个人信息完整，增加30分  使用头像增加10分
	 */
	$xx_yx=0;
	$yingxiangli=0;
	//个人信息
	if($yonghu[0]['tel']!=null&&$yonghu[0]['qq']!=null&&$yonghu[0]['class_id']!=null){
		$yingxiangli+=30;
		$xx_yx+=30;
	}
	if($yonghu[0]['avatar']!=null){
		$yingxiangli+=10;
		$xx_yx+=10;
	}
	//排名
	$pm_yx=0;
	$yingxiangli+=$sort[$paiming]['true_sum']*2+$sort[$paiming]['false_sum']*1;
	$yingxiangli+=$yonghu[0]['fans_num'];
	$yingxiangli+=$yonghu[0]['posts_num'];
	$pm_yx+=$sort[$paiming]['true_sum']*2+$sort[$paiming]['false_sum']*1;
	$pm_yx+=$yonghu[0]['fans_num'];
	$pm_yx+=$yonghu[0]['posts_num'];
	
	//帖子信息
	$tz_yx=0;
	$sql2="select * from post where user_id = :id";
	$cha_post=$db->query($sql2,array('id'=>$yonghu[0]['id']));
	if(isset($cha_post)){
		foreach($cha_post as $q){
			$yingxiangli+=$q['forward_num']*5+$q['comment_num']*3+$q['praise_num'];
			$tz_yx+=$q['forward_num']*5+$q['comment_num']*3+$q['praise_num'];
		}
	}
	
	//查看他的留言
	$liu="select * from liuyan where name = :username order by addtime desc limit 5";
	$liuyan=$db->query($liu,array('username'=>$yonghu[0]['username']));
	
	//聊天
	$liao="select * from message where receiver = :username order by addtime desc  limit 5";
	$message=$db->query($liao,array('username'=>$yonghu[0]['username']));

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
            	描述：个人页面
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4><?php echo $yonghu[0]['username']?>的个人资料</h4>
            			</div>
            			<div class="box_content">
            				<div class="header">
            					<img src="<?php if($yonghu[0]['avatar']==null){echo "../img/avatar.jpg";}else{echo "../images/".$yonghu[0]['avatar'];}?>" title="个人头像">
        						<ul class="header_ul">
        							<li><strong><?php echo $yonghu[0]['username']?></strong></li>
        							<li>注册于:<b><?php echo date('Y-m-d',$yonghu[0]['addtime'])?></b></li>
        							<li>最后一次登录于:<b><?php echo tranTime($yonghu[0]['last_addtime'])?></b></li>
        							<li>当前位于排行榜:<b><?php echo ($paiming+1)."名"?></b><i>累计答对:<?php echo $sort[$paiming]['true_sum']?></i><i>总共作答:<?php echo $sort[$paiming]['true_sum']+$sort[$paiming]['false_sum']?></i></li>
        							<li><span>当前QQ:<b><?php echo $yonghu[0]['qq']?></b></span><span>当前班级:<b><?php echo $yonghu[0]['class_id']?></b></span><span>当前电话:<b><?php echo $yonghu[0]['tel']?></b></span></li>
        						</ul>
            				</div>
            			</div>
            			<div class="geren_main">
            				<h4 title="查看详情" onmouseover="chufa()" onmouseout="yincang()">网站影响力<span style="margin-left: 50px;"><?php echo $yingxiangli;?></span></h4>
            				<div id="yin" class="yincang_main" style="display: none;"><span>信息影响力:<b><?php echo $xx_yx;?></b></span><span>做题影响力:<b><?php echo $pm_yx;?></b></span><span>发帖影响力:<b><?php echo $tz_yx;?></b></span></div>
            				<script src="../js/echarts.js"></script>
				            <div id="chartmain" style="width:600px; height: 400px;"></div>
				            <script type="text/javascript">
						        //指定图标的配置和数据
						        var zuoti=<?php echo $pm_yx?>;
						        var fatie=<?php echo $tz_yx?>;
						        var xinxi=<?php echo $xx_yx?>;
						        var quanbu=zuoti+fatie+xinxi;
						        var option = {
						            title:{
						                text:'网站影响力'
						            },
						            tooltip:{},
						            legend:{
						                data:['用户来源']
						            },
						            xAxis:{
						                data:["信息影响力","做题影响力","发帖影响力","全部影响力"]
						            },
						            yAxis:{
										
						            },
						            series:[{
						                name:'影响力',
						                type:'line',
						                data:[xinxi,zuoti,fatie,quanbu]
						            }]
						        };
						        //初始化echarts实例
						        var myChart = echarts.init(document.getElementById('chartmain'));
						
						        //使用制定的配置项和数据显示图表
						        myChart.setOption(option);
						    </script>
						    <div id="shuju" style="width: 400px; height: 400px;"></div>
						    <script type="text/javascript">
						        //指定图标的配置和数据
						     	var zhengque=<?php echo $sort[$paiming]['true_sum']?>;
						       	var cuowu=<?php echo $sort[$paiming]['false_sum']?>;
						        var option = {
						            title:{
						                text:"做题情况分析"
						            },            
						            series:[{
						                name:'做题',
						                type:'pie',    
						                radius:'60%', 
						                data:[
						                    {value:zhengque,name:'正确'+zhengque},
						                    {value:cuowu,name:'错误'+cuowu}
						                ]
						            }]
						        };
						        //初始化echarts实例
						        var myChart1 = echarts.init(document.getElementById('shuju'));
						
						        //使用制定的配置项和数据显示图表
						        myChart1.setOption(option);
						    </script>
            			</div>
            		</div>
            	</div>
            </div>
       </div>
    </div>
</body>
<script>
	function chufa(){
		yin.style.display='block';
	}
	function yincang(){
		yin.style.display='none';
	}
</script>
</html>