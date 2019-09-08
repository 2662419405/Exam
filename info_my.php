<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="info_p1">
				未来发展
			</div>
			<div class="info_p2">
				<h4>1.我们平台现在的功能</h4>
				<p>我们现在已经开放错题本功能，排行榜功能，老师发放作业功能，外部新闻链接功能，学习经验分享（可以分享到主页上面），还附带了小部分的考试功能，包含学校里面所有的专业，系等等全部的题库</p>
				<h4>2.我们平台未来的发展</h4>
				<p>目前正在研发的功能：好友pk功能，随着时代的发展，互帮互助的学习方法越来越被人们接受，那我们也打算开发好友功能，还会开发好友pk功能，快来和你的好友一较高下吧!</p>
				<p>目部的正在研发的功能：将会更大一步促进排行榜功能，增加称号，信息更全面，增加点赞功能，可以为你心目中的偶像进行点赞，给大家更多的鼓励</p>
				<p>我们开发这个平台就是想要真正的应用他来帮助大家学习，所有我们后续会不断添加新的功能来充实网站，让本网站称为一个良好的学习网站</p>
				<h4>3.为什么选择我们平台</h4>
				<p>为了给学生提供一个拥有更全面更方便学习知
识的平台，激发大学生不断的对已知的知识学
习和思考，提高学习效率，以及创新技术的追
求，学校更应该需要一个全面概括性的知识平
台，还可以针对老师和热门学科进行帮助，方
面某些学生针对某些老师上课内容不是特别了
解的地方，可以课下进行学习。热门学科可以
帮助学生对一些证书的考试进行复习。最后可
以帮助学生互相展示自己的学术水平，相互促
进学习。并且本平台提供题库内容丰富，范围
广泛，针对方面全面。</p>
<p style="font-size: 12px; color: #666;"><span style="color: red;">特别注意:</span>开发网站的小伙伴技术还不是很好，也是第一次进行平台的搭建，很多技术都是现复习的，导致错误很多，如果小伙伴们遇到了bug可以随时联系我们哦！或者想要一起探讨和学习也非常欢迎.</p>
			</div>
		</div>
		<?php include_once("view/right.php"); ?>
		<?php include_once("view/footer.html"); ?>
	</div>
</body>
