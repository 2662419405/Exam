<div class="head_nav">
	<div class="sidebar">
		<ul id="side_menu">
			<li style="padding: 25px 20px;" class="nav_head">
				<div class="dropdown">
					<span>
						<img src="../img/avatar.jpg" height="60px" class="img-circle" alt="image"/>
					</span>
					<a href="index.php" title="返回首页">
						<span class="clear">
							<span class="block s-h">
								<?php echo $_SESSION['user']['username'];?>
							</span>
							<span class="block text-menu xs">
								管理员
								<b class="caret"></b>
							</span>
						</span>
					</a>
				</div>
			</li>
			<li class="active2">
				<a href="#" class="active1"><i class="fa" style="width: 50px;"></i>
					<span class="nav-label">管理</span>
				</a>
				<ul class="ul_nav">
					<div class="index_left">
						<ul id="nav" class="nav">
							<li>
						    	<h2><span>试题管理</span></h2>
						        <ul>
						            <li><a href="shiti.php">试题练习</a></li>
						            <li><a href="hot.php">热门试题</a></li>
						            <li><a href="zhuanye.php">模拟考试</a></li>
						        </ul>
						   </li>
							<li>
						    	<h2><span>成员管理</span></h2>
						        <ul>
						            <li><a href="chengyuan.php">注册用户</a></li>
						        </ul>
						 </li>
						    <li>
						    	<h2><span>信息管理</span></h2>
						        <ul>
						            <li><a href="jingyan_huikui.php">学习经验回馈</a></li>
						            <li><a href="baocuo_huikui.php">题目报错回馈</a></li>
						            <li><a href="yijian_huikui.php">网站意见回馈</a></li>
						        </ul>
						    </li>
						    <li>
						    	<h2><span>页面广告</span></h2>
						        <ul>
						            <li><a href="news.php">首页新闻推荐</a></li>
						        </ul>
						    </li>
						    <li>
						    	<h2><span>排行榜管理</span></h2>
						        <ul>
						            <li><a href="ranking_fen.php">粉丝排名</a></li>
						            <li><a href="ranking_AC.php">做题正确排名</a></li>
						            <li><a href="ranking_fatie.php">发帖排名</a></li>
						            <li><a href="ranking_yingxiang.php">最具影响力排名</a></li>
						        </ul>
						    </li>
						</ul>
					</div>
				</ul>						
			</li>
		</ul>
	</div>
</div>