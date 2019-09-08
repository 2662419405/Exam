<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	
	$flag=$_GET['friend_id'];
	if(empty($_GET['friend_id'])){
		$flag=$_SESSION['user']['id'];
	}
	
    //分页
	$pageSize=8;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from friends where friend_id = :user_id and status =1 order by id desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$friends = $db->query($sql,array('user_id'=>$flag));
	$total   = $db->single("select count(*) from friends where friend_id = :user_id and status =1 ",array('user_id'=>$flag));
	$yeshu=ceil($total/$pageSize);

    if(isset($friends)){
	    foreach($friends as $vo){
	        $data = $db->row('select * from user where id = :user_id',array('user_id'=>$vo['user_id']));
	        $lists[] = $data;
	    }
	}
	
    include("view/header.html");
    ?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
		<div class="main">
			<div class="left1">
				<h4 class="list_title">
					粉丝
					<span><?php echo $total?></span>
				</h4>
				<div class="my_fans my_friend">
		            <?php if (!isset($lists)) {
		                echo "还没有粉丝哦！";
		            }else{
		                foreach($lists as $v){
		                	$username=$v['id'];  
		                	?>
		                	<a href="homepage.php?friend_id=<?php echo $username?>" class="aaaa">
		                		<div class="my_fans_list">
			                       	<img class="fl" src="<?php echo get_cover_path($v['avatar']) ?>">
			                        <ul class="fl">
			                            <li><?php echo $v['username'] ?></li>
			                            <li>
			                                <span>关注</span><font><?php echo $v['follows_num'] ?></font><span>|</span>
			                                <span>粉丝</span><font><?php echo $v['fans_num'] ?></font><span>|</span>
			                                <span>帖子</span><font><?php echo $v['posts_num'] ?></font>
			                            </li>
			                            <li><span>注册于：<?php echo date('Y-m-d',$v['addtime']) ?></span>
			                                <span>QQ:<?php echo $v['qq'] ?></span>
			                            </li>
			                        </ul>
			                    </div>
		                	</a>
		                <?php } ?>
		            <?php } ?>
		        </div>
				<div class="ls">
					<?php include_once("view/liuyanbanpage.php"); ?>
				</div>
			</div>
			<?php include_once("view/right.php"); ?>
			<?php include_once("view/footer.html"); ?>
		</div>
	</body>
</html>