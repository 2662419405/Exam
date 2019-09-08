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
	
    //分页
	$pageSize=8;
	$pageNum=empty($_GET['pageNum'])?1:$_GET['pageNum'];
	$sql="select * from friends where user_id = :user_id and status =1 order by id desc limit ".(($pageNum-1)*$pageSize).",".$pageSize;
	$friends = $db->query($sql,array('user_id'=>$flag));
	$total   = $db->single("select count(*) from friends where user_id = :user_id and status =1 ",array('user_id'=>$flag));
	$yeshu=ceil($total/$pageSize);

    if(isset($friends)){
        foreach($friends as $vo){
            $data = $db->row('select * from user where id = :user_id',array('user_id'=>$vo['friend_id']));
            $lists[] = $data;
        }
    }
    include("view/header.html");
    ?>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="layer/layer.js" type="text/javascript"></script>
<script>
$(function(){
	
$('#follow,#cancel-follow').click(function(){
    var friend_id = $(this).attr('value');
    $.post("follow.php",{friend_id:friend_id},function(re){
        if(re == 1){
            layer.msg('关注成功',{time:2000});
        }else{
            layer.msg('已取消',{time:2000});
        }
        window.location.reload();
    });
});
	
});
</script>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
		<div class="main">
			<div class="left1">
				<h4 class="list_title">
					全部关注
					<span><?php echo $total?></span>
				</h4>
				<div class="my_friend">
		            <?php if (!isset($lists)) {
		                echo "还没有关注哦！";
		            }else{
		                foreach($lists as $v){
		                	$username=$v['id']; 
		                	?>
		                    <div class="my_friend_list">
		                    	<a href="homepage.php?friend_id=<?php echo $username?>">
		                        	<img class="fl" src="<?php echo get_cover_path($v['avatar']) ?>">
		                    	</a>
		                        <ul class="fl">
		                            <li><?php echo $v['username'] ?></li>
		                            <li><span>注册于：<?php echo date('Y-m-d',$v['addtime']) ?></span>
		                                <span>QQ:<?php echo $v['qq'] ?></span>
		                            </li>
		                        </ul>
		                        <?php
		                        	if($_GET['friend_id']==$_SESSION['user']['id']){
		                        		?>
		                        	<button id="cancel-follow" class="fr" value="<?php echo $v['id'] ?>">取消关注</button>
		                        	<?php
		                        	}
		                        	?>
		                    </div>
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