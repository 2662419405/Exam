<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("bg_view/header.html");
	
	$sql="select * from user where level = 1";
	$chaxun = $db->query($sql);
	
	/*
	 * 影响力采用数据分析
	 * 一点粉丝增加10点影响力，一个正确的题增加2分，一个错题增加1分
	 * 一点发帖增加1分，获得一个转发增加5分，一个评论增加3分,一个点赞增加1分
	 * 个人信息完整，增加30分  使用头像增加10分
	 */
	
	foreach($chaxun as $v){
		$v['yingxiang']=0;
		//个人信息完整
		if($v['tel']!=null&&$v['qq']!=null&&$v['class_id']!=null){
			$v['yingxiang']+=30;
		}
		if($v['avatar']!=null){
			$v['yingxiang']+=10;
		}
		
		//获取他的排名
		$sql1="select * from sort where user_id = :id";
		$cha_sort=$db->query($sql1,array('id'=>$v['id']));
		if(isset($cha_sort)){
			$v['yingxiang']+=$cha_sort[0]['true_sum']*2+$cha_sort[0]['false_sum']*1;
		}
		
		//获取他的粉丝
		if($v['fans_num']!=0){
			$v['yingxiang']+=$v['fans_num']*10;
		}
		
		//获取发帖
		if($v['posts_num']!=0){
			$v['yingxiang']+=$v['posts_num'];
		}
		
		//获取他的其他信息
		$sql2="select * from post where user_id = :id";
		$cha_post=$db->query($sql2,array('id'=>$v['id']));
		if(isset($cha_post)){
			foreach($cha_post as $q){
				$v['yingxiang']+=$q['forward_num']*5+$q['comment_num']*3+$q['praise_num'];
			}
		}
				
		$list[]=$v;  
	}
	
	//用于排序
	$arr=array();
	foreach($list as $vm){
		$arr[]=$vm['yingxiang'];
	}
	array_multisort($arr,SORT_DESC,$list);	
	
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
            	描述：影响力页面
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>影响力排名</h4>
            			</div>
            			<div class="box_content">
        				   <table class="table__ranking_fen">
        					<thead>
            					<tr style="background: #f5f5f6;">
	            					<th>排名</th>
	            					<th>ID</th>
	            					<th>姓名</th>
	            					<th>粉丝</th>
	            					<th>班级专业</th>
	            					<th>综合影响力</th>
	            					<th style="width: 100px;">操作</th>
            					</tr>
            				</thead>
        					<tbody>
        						<?php
        							for($i=0;$i<10;$i++){
        								
        								$yonghu_id=$list[$i]['id'];//id
        								$yonghu_name=$list[$i]['username'];//name
        								$yonghu_fen=$list[$i]['fans_num'];//粉丝
        								$yonghu_banji=$list[$i]['class_id'];//班级
        								$yonghu_yingxiang=$list[$i]['yingxiang']//影响
        								
        								?>
        								
        								<tr>
	            							<td>
	            								<span><?php echo "NO.".($i+1)?></span>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_id?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_name?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_fen?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_banji?>
	            							</td>
	            							<td>
	            								<?php echo $yonghu_yingxiang?>
	            							</td>
	            							<td>
	            								<a href="geren.php?yonghu_id=<?php echo $yonghu_id?>">他的资料</a>
	            							</td>
	            						</tr>
        								
        							<?}
        							?>
        					</tbody>
            			</div>
            		</div>
            	</div>
            </div>
       </div>
    </div>
</body>
</html>