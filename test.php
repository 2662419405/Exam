<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("view/header.html");
	$n=$db->query("select count(*) from exam_problem");
	$n_hot=$db->query("select count(*) from exam_hot");
	
	//检索热门考试文本
	$sql="select * from exam_zhuanye group by name order by num desc limit 5";
	$re=$db->query($sql);
	
	$shu=0;
	
	$xun=(date("y")-16)*12+(date("m"));//时间戳的动态生成
	
	?>
<body style="background: url(img/body_bg.png) center 35px no-repeat #d4e8fe;">
	<?php include_once("view/head.html"); ?>
	<div class="main">
		<div class="left">
			<div class="text_kaoshi" id="kaoshi1">
				<?php
					for($i=0;$i<6;$i++){
						echo "<div class='pai'>"."</div>";
					}
					?>
			</div>
			<div class="test_t">
				<div class="diva">
					<ul id="kao">
						<li onclick="yincang(this)">课程随机</li>
						<li onclick="yincang(this)">热门随机</li>
						<li onclick="yincang(this)">专业模拟</li>
					</ul>
					<div class="box_sha" id="suiji">
						<form action="test_suiji.php" method="post">
							<span>数量:</span><input type="text" name="chuti_shuliang" class="chuti_shuliang" placeholder="数量(<?php echo '当前题库共有'.$n[0]['count(*)']?>     最多提交为30个 )"/><br />
							<span>类型:</span>
							<select name="chuti_xuanxiang" class="chuti_xibie">
								<option value="0">全部</option>
								<option value="1">单选题</option>
								<option value="2">填空题</option>
								<option value="3">判断题</option>
							</select><br />
							<span>课程:</span>
							<select name="chuti_xibie" class="chuti_xibie">
							<optgroup label="全部">
								<option value="全部">全部</option>
							</optgroup>
							<optgroup label="大数据与计算机系">
								<option value="面向对象程序设计">面向对象程序设计</option>
								<option value=".NET编程及高级应用">.NET编程及高级应用</option>
								<option value="软件工程">软件工程</option>
								<option value="专业英语">专业英语</option>
								<option value="计算机网络与通信">计算机网络与通信</option>
								<option value="C++程序设计">C++程序设计</option>
								<option value="C语言程序设计能力教程">C语言程序设计能力教程</option>
								<option value="C#程序设计">C#程序设计</option>
								<option value="网络安全与管理">网络安全与管理</option>
								<option value="网络设备调试与优化">网络设备调试与优化</option>
								<option value="网络设备与组网技术">网络设备与组网技术</option>
								<option value="大数据技术原理及应用">大数据技术原理及应用</option>
								<option value="Microsoft.NET技术应用">Microsoft.NET技术应用</option>
								<option value="嵌入式系统设计与开发">嵌入式系统设计与开发</option>
								<option value="Mysql数据库">Mysql数据库</option>
								<option value="JSP与网站建设">JSP与网站建设</option>
								<option value="Linux操作系统及应用">Linux操作系统及应用</option>
								<option value="网页三剑客">网页三剑客</option>
								<option value="操作系统">操作系统</option>
								<option value="微机安装与维护">微机安装与维护</option>
								<option value="数据结构">数据结构</option>
								<option value="计算机组成原理">计算机组成原理</option>
							</optgroup>
							<optgroup label="电信系">
								<option value="电机与拖动">电机与拖动</option>
								<option value="电气控制技术">电气控制技术</option>
								<option value="PLC控制技术">PLC控制技术</option>
								<option value="电力电子技术">电力电子技术</option>
								<option value="控制理论基础">控制理论基础</option>
								<option value="传感器原理及应用">传感器原理及应用</option>
								<option value="计算机控制技术">计算机控制技术</option>
								<option value="运动控制系统">运动控制系统</option>
								<option value="电子信息工程概论">电子信息工程概论</option>
								<option value="高频电子技术">高频电子技术</option>
								<option value="电子测量技术">电子测量技术</option>
								<option value="电能计量">电能计量</option>
								<option value="交流调速">交流调速</option>
								<option value="供用电网络及设备">供用电网络及设备</option>
								<option value="PLC原理及应用">PLC原理及应用</option>
								<option value="数字电子线路">数字电子线路</option>
								<option value="模拟电子线路">模拟电子线路</option>
								<option value="无线通信软件开发">无线通信软件开发</option>
								<option value="网络设计">网络设计</option>
								<option value="综合布线">综合布线</option>
								<option value="电路基础">电路基础</option>
								<option value="现代交换技术">现代交换技术</option>
								<option value="通信工程设计与管理">通信工程设计与管理</option>
								<option value="网络通信">网络通信</option>
								<option value="串口通信">串口通信</option>
								<option value="供配电技术">供配电技术</option>
								<option value="无线传感器网络">无线传感器网络</option>
								<option value="光纤通信">光纤通信</option>
								<option value="移动通信">移动通信</option>
								<option value="数字通信原理">数字通信原理</option>
								<option value="传感器与检测技术">传感器与检测技术</option>
								<option value="AutoCAD">AutoCAD</option>
								<option value="嵌入式技术">嵌入式技术</option>
								<option value="电子工艺">电子工艺</option>
								<option value="物联网技术">物联网技术</option>
								<option value="单片机原理">单片机原理</option>
								<option value="检测与转换技术">检测与转换技术</option>
								<option value="EDA电路设计">EDA电路设计</option>
							</optgroup>
							<optgroup label="建工系">
								<option value="画法几何与建筑制图">画法几何与建筑制图</option>
								<option value="建筑工程测量">建筑工程测量</option>
								<option value="建筑材料">建筑材料</option>
								<option value="建筑力学">建筑力学</option>
								<option value="结构力学">结构力学</option>
								<option value="建筑构造">建筑构造</option>
								<option value="建筑设计">建筑设计</option>
								<option value="混泥土结构与砌体结构">混泥土结构与砌体结构</option>
								<option value="施工技术">施工技术</option>
								<option value="施工组织设计">施工组织设计</option>
								<option value="地基与基础">地基与基础</option>
								<option value="建筑工程概预算">建筑工程概预算</option>
								<option value="高层建筑结构">高层建筑结构</option>
								<option value="钢结构">钢结构</option>
								<option value="抗震">抗震</option>
								<option value="建筑设备工程">建筑设备工程</option>
								<option value="建筑工程资料管理">建筑工程资料管理</option>
								<option value="建设工程监理">建设工程监理</option>
								<option value="建设法规">建设法规</option>
								<option value="建设工程经济">建设工程经济</option>
								<option value="招标投标与合同管理">招标投标与合同管理</option>
								<option value="文秘管理与应用写作">文秘管理与应用写作</option>
								<option value="社交礼仪">社交礼仪</option>
								<option value="物业管理招标与投标">物业管理招标与投标</option>
								<option value="物业管理实务">物业管理实务</option>
								<option value="物业管理法规">物业管理法规</option>
								<option value="管理学基础">管理学基础</option>
								<option value="装饰施工组织与管理">装饰施工组织与管理</option>
								<option value="建筑装饰工程概预算">建筑装饰工程概预算</option>
								<option value="装饰施工技术">装饰施工技术</option>
								<option value="电脑美术设计">电脑美术设计</option>
								<option value="效果图表现技法">效果图表现技法</option>
								<option value="室内设计原理">室内设计原理</option>
								<option value="房屋建筑学">房屋建筑学</option>
								<option value="建筑绘画">建筑绘画</option>
								<option value="建筑AutoCAD">建筑AutoCAD</option>
								<option value="色彩构成">色彩构成</option>
								<option value="立体构成">立体构成</option>
								<option value="平面构成">平面构成</option>
								<option value="建筑史">建筑史</option>
								<option value="建筑装饰材料">建筑装饰材料</option>
								<option value="建筑装饰制图">建筑装饰制图</option>
								<option value="人体工程学">人体工程学</option>
								<option value="绘画">绘画</option>
								<option value="3DMAX">3DMAX</option>
								<option value="PKPM">PKPM</option>
								<option value="AutoCAD">AutoCAD</option>
								<option value="建设工程项目管理">建设工程项目管理</option>
								<option value="施工组织设计与进度管理">施工组织设计与进度管理</option>
								<option value="建筑施工技术">建筑施工技术</option>
								<option value="施工企业会计与财务">施工企业会计与财务</option>
								<option value="建筑测量">建筑测量</option>
								<option value="建筑工程制图与识图">建筑工程制图与识图</option>
								<option value="物业数据库管理">物业数据库管理</option>
								<option value="物业管理办公自动化">物业管理办公自动化</option>
								<option value="小区规划">小区规划</option>
								<option value="园林与绿化">园林与绿化</option>
								<option value="房地产综合开发与经营">房地产综合开发与经营</option>
								<option value="房地产政策与法规">房地产政策与法规</option>
								<option value="智能建筑的物业管理">智能建筑的物业管理</option>
								<option value="物业管理会计">物业管理会计</option>
								<option value="建筑设计规范">建筑设计规范</option>
								<option value="建筑表现图技法">建筑表现图技法</option>
								<option value="计算机辅助设计">计算机辅助设计</option>
								<option value="外国建筑史">外国建筑史</option>
								<option value="中国建筑史">中国建筑史</option>
								<option value="城市规划原理">城市规划原理</option>
								<option value="园林景观设计">园林景观设计</option>
								<option value="居住区规划设计">居住区规划设计</option>
								<option value="公共建筑原理与设计">公共建筑原理与设计</option>
								<option value="住宅建筑原理与设计">住宅建筑原理与设计</option>
								<option value="建筑设计初步">建筑设计初步</option>
								<option value="建筑安装工程预算">建筑安装工程预算</option>
								<option value="工程造价管理">工程造价管理</option>
								<option value="工程造价案例分析">工程造价案例分析</option>
								<option value="工程经济分析">工程经济分析</option>
							</optgroup>
							<optgroup label="石化系">
								<option value="有机化学">有机化学</option>
								<option value="工程力学">工程力学</option>
								<option value="工程流体力学">工程流体力学</option>
								<option value="油层物理">油层物理</option>
								<option value="钻井工程">钻井工程</option>
								<option value="采油工程">采油工程</option>
								<option value="钻采机械">钻采机械</option>
								<option value="钻井液工艺学">钻井液工艺学</option>
								<option value="石油地质学">石油地质学</option>
								<option value="井下作业与工具">井下作业与工具</option>
								<option value="专业外语">专业外语</option>
								<option value="无机化学基础">无机化学基础</option>
								<option value="精细化学品检测技术">精细化学品检测技术</option>
								<option value="化工仪表及自动化">化工仪表及自动化</option>
								<option value="化工单元操作技术">化工单元操作技术</option>
								<option value="精细化工工艺学">精细化工工艺学</option>
								<option value="精细有机合成">精细有机合成</option>
								<option value="化工制图">化工制图</option>
								<option value="油田化学品生产与应用">油田化学品生产与应用</option>
								<option value="石油钻采概论">石油钻采概论</option>
								<option value="表面活性剂">表面活性剂</option>
								<option value="高分子化学">高分子化学</option>
								<option value="油田化学">油田化学</option>
								<option value="物理化学">物理化学</option>
								<option value="化工原理">化工原理</option>
								<option value="仪器分析">仪器分析</option>
								<option value="分析化学">分析化学</option>
								<option value="环境污染控制">环境污染控制</option>
								<option value="清洁生产">清洁生产</option>
								<option value="室内环境检测">室内环境检测</option>
								<option value="环境影响评价">环境影响评价</option>
								<option value="固体与噪声治理">固体与噪声治理</option>
								<option value="大气污染控制工程">大气污染控制工程</option>
								<option value="水污染控制工程">水污染控制工程</option>
								<option value="环境监测">环境监测</option>
								<option value="工程制图与CAD">工程制图与CAD</option>
								<option value="环境学概论">环境学概论</option>
								<option value="井控技术">井控技术</option>
							</optgroup>
							<optgroup label="管理系">
								<option value="网络营销">网络营销</option>
								<option value="广告与促销">广告与促销</option>
								<option value="销售管理">销售管理</option>
								<option value="零售管理">零售管理</option>
								<option value="市场调查与预测">市场调查与预测</option>
								<option value="服务营销管理">服务营销管理</option>
								<option value="消费者行为学">消费者行为学</option>
								<option value="市场营销学">市场营销学</option>
								<option value="经济学">经济学</option>
								<option value="管理学">管理学</option>
								<option value="网络营销策划">网络营销策划</option>
								<option value="电子商务案例">电子商务案例</option>
								<option value="网站建设">网站建设</option>
								<option value="网页设计">网页设计</option>
								<option value="网络技术">网络技术</option>
								<option value="物流管理">物流管理</option>
								<option value="网络营销">网络营销</option>
								<option value="网店装修">网店装修</option>
								<option value="网店运营">网店运营</option>
								<option value="电子商务概论">电子商务概论</option>
								<option value="酒店专业英语">酒店专业英语</option>
								<option value="酒店人力资源管理">酒店人力资源管理</option>
								<option value="酒水及酒吧管理">酒水及酒吧管理</option>
								<option value="餐饮运行管理">餐饮运行管理</option>
								<option value="房屋管理实务">房屋管理实务</option>
								<option value="前厅运行与管理">前厅运行与管理</option>
								<option value="酒店管理概论">酒店管理概论</option>
								<option value="旅游心理学">旅游心理学</option>
								<option value="管理学原理">管理学原理</option>
								<option value="旅游地理">旅游地理</option>
								<option value="主要客源国概况">主要客源国概况</option>
								<option value="导游专业英语">导游专业英语</option>
								<option value="旅游学概论">旅游学概论</option>
								<option value="旅行社管理">旅行社管理</option>
								<option value="导游概论">导游概论</option>
								<option value="税务筹划">税务筹划</option>
								<option value="税务会计">税务会计</option>
								<option value="税法">税法</option>
								<option value="财经法规">财经法规</option>
								<option value="会计应用软件">会计应用软件</option>
								<option value="会计电算化">会计电算化</option>
								<option value="管理会计">管理会计</option>
								<option value="成本会计">成本会计</option>
								<option value="财务管理">财务管理</option>
								<option value="审计学">审计学</option>
								<option value="高级财务会计">高级财务会计</option>
								<option value="中级财务会计">中级财务会计</option>
								<option value="会计学基础">会计学基础</option>
								<option value="商务礼仪">商务礼仪</option>
								<option value="商务沟通与谈判">商务沟通与谈判</option>
							</optgroup>
							<optgroup label="基础部">
								<option value="基础英语">基础英语</option>
								<option value="英语语音">英语语音</option>
								<option value="英语语法">英语语法</option>
								<option value="英语听力">英语听力</option>
								<option value="英语口语">英语口语</option>
								<option value="英语泛读">英语泛读</option>
								<option value="英语写作">英语写作</option>
								<option value="旅游英语">旅游英语</option>
								<option value="翻译实践">翻译实践</option>
								<option value="饭店英语">饭店英语</option>
								<option value="商务英语">商务英语</option>
								<option value="旅游学概论">旅游学概论</option>
								<option value="导游基础知识">导游基础知识</option>
								<option value="酒店餐饮服务知识">酒店餐饮服务知识</option>
							</optgroup>
					</select>
					<br />
							<span>出题老师:</span><input type="text" name="chuti_name" class="chuti_name" placeholder="出题老师(不想选择老师请填写    全部    )"/>
							<span>试题出题时间:</span><select name="chuti_shijian" class="chuti_shijian1">
								<?php
										for($j=$xun-2;$j>=0;$j--){
											$i=$xun-$j-1;//获取第几个月的时间戳
											?>
											
											<option value="<?php echo $beginThismonth=mktime(0,0,0,date('m')-$i,1,date('Y'));?>"><?php echo  floor(($j/12)+2016)."年".(($j%12)+1)."月";?></option>
											
										<?
										}?>
										<option value="1">再往前</option>
								   </select>
							<span>试题截止时间：</span><select name="chuti_jiezhi" class="chuti_jiezhi">
									   <?php
										for($j=$xun-2;$j>=0;$j--){
											$i=$xun-$j-1;//获取第几个月的时间戳
											?>
											
											<option value="<?php echo $beginThismonth=mktime(23,59,59,date('m')-$i,date('t'),date('Y'));?>"><?php echo  floor(($j/12)+2016)."年".(($j%12)+1)."月";?></option>
											
										<?
										}?>
								   </select>
								   <br />
							<input type="submit" name="chuti_submit" id="chuti_submit" value="开始测试   》" />
						</form>
					</div>
					<div class="box_sha" id="remen">
						<form action="test_hot.php" method="post">
							<span>数量:</span><input type="text" name="chuti_shuliang" class="chuti_shuliang" placeholder="数量(<?php echo '当前题库共有'.$n_hot[0]['count(*)']?>    最多提交为30个   )"/><br />
							<span>出题老师:</span><input type="text" name="chuti_name" class="chuti_name" placeholder="出题老师(不想选择老师请填写    全部    )"/><br />
							<span>类型:</span>
							<select name="chuti_xuanxiang" class="chuti_xibie">
								<option value="0">全部</option>
								<option value="1">单选题</option>
								<option value="2">填空题</option>
								<option value="3">判断题</option>
							</select>
							<br />
							<span>课程:</span>
							<select name="chuti_xibie" class="chuti_xibie">
								<optgroup label="全部">
									<option value="全部">全部</option>
								</optgroup>
								<optgroup label="专升本">
									<option value="高数">高数</option>
									<option value="英语">英语</option>
									<option value="有机化学">有机化学</option>
									<option value="无机化学">无机化学</option>
									<option value="管理学">管理学</option>
									<option value="精读英语">精读英语</option>
									<option value="泛读英语">泛读英语</option>
									<option value="公共英语">公共英语</option>
									<option value="艺术概论">艺术概论</option>
								</optgroup>
								<optgroup label="英语">
									<option value="英语三级半">英语三级半</option>
									<option value="英语四级">英语四级</option>
								</optgroup>
								<optgroup label="计算机">
									<option value="办公国二">办公国二</option>
									<option value="c语言国二">c语言国二</option>
									<option value="省二c语言">省二c语言</option>
									<option value="省二vb">省二vb</option>
								</optgroup>
								<optgroup label="证书">
									<option value="导游证">导游证</option>
									<option value="初级会计">初级会计</option>
									<option value="教师资格证">教师资格证</option>
								</optgroup>
							</select>
							<br />
							<span>试题出题时间:</span><select name="chuti_shijian" class="chuti_shijian1">
									<?php
										for($j=$xun-2;$j>=0;$j--){
											$i=$xun-$j-1;//获取第几个月的时间戳
											?>
											
											<option value="<?php echo $beginThismonth=mktime(0,0,0,date('m')-$i,1,date('Y'));?>"><?php echo  floor(($j/12)+2016)."年".(($j%12)+1)."月";?></option>
											
										<?
										}?>
										<option value="1">再往前</option>
							</select>
							<span>试题截止时间：</span><select name="chuti_jiezhi" class="chuti_jiezhi">
								     <?php
										for($j=$xun-2;$j>=0;$j--){
											$i=$xun-$j-1;//获取第几个月的时间戳
											?>
											
											<option value="<?php echo $beginThismonth=mktime(23,59,59,date('m')-$i,date('t'),date('Y'));?>"><?php echo  floor(($j/12)+2016)."年".(($j%12)+1)."月";?></option>
											
										<?
										}?>
								   </select>
								   <br />
							<input type="submit" class="chuti_sum" name="chuti_submit" id="chuti_submit2" value="开始测试   》" />
						</form>
					</div>
					<div class="box_sha" id="zhuanye">
						<form action="test_zhuanye.php" method="post">
							<span>课程:</span>
							<select name="chuti_xibie" class="chuti_xibie">
							<optgroup label="全部">
								<option value="全部">全部</option>
							</optgroup>
							<optgroup label="大数据与计算机系">
								<option value="面向对象程序设计">面向对象程序设计</option>
								<option value=".NET编程及高级应用">.NET编程及高级应用</option>
								<option value="软件工程">软件工程</option>
								<option value="专业英语">专业英语</option>
								<option value="计算机网络与通信">计算机网络与通信</option>
								<option value="C++程序设计">C++程序设计</option>
								<option value="C语言程序设计能力教程">C语言程序设计能力教程</option>
								<option value="C#程序设计">C#程序设计</option>
								<option value="网络安全与管理">网络安全与管理</option>
								<option value="网络设备调试与优化">网络设备调试与优化</option>
								<option value="网络设备与组网技术">网络设备与组网技术</option>
								<option value="大数据技术原理及应用">大数据技术原理及应用</option>
								<option value="Microsoft.NET技术应用">Microsoft.NET技术应用</option>
								<option value="嵌入式系统设计与开发">嵌入式系统设计与开发</option>
								<option value="Mysql数据库">Mysql数据库</option>
								<option value="JSP与网站建设">JSP与网站建设</option>
								<option value="Linux操作系统及应用">Linux操作系统及应用</option>
								<option value="网页三剑客">网页三剑客</option>
								<option value="操作系统">操作系统</option>
								<option value="微机安装与维护">微机安装与维护</option>
								<option value="数据结构">数据结构</option>
								<option value="计算机组成原理">计算机组成原理</option>
							</optgroup>
							<optgroup label="电信系">
								<option value="电机与拖动">电机与拖动</option>
								<option value="电气控制技术">电气控制技术</option>
								<option value="PLC控制技术">PLC控制技术</option>
								<option value="电力电子技术">电力电子技术</option>
								<option value="控制理论基础">控制理论基础</option>
								<option value="传感器原理及应用">传感器原理及应用</option>
								<option value="计算机控制技术">计算机控制技术</option>
								<option value="运动控制系统">运动控制系统</option>
								<option value="电子信息工程概论">电子信息工程概论</option>
								<option value="高频电子技术">高频电子技术</option>
								<option value="电子测量技术">电子测量技术</option>
								<option value="电能计量">电能计量</option>
								<option value="交流调速">交流调速</option>
								<option value="供用电网络及设备">供用电网络及设备</option>
								<option value="PLC原理及应用">PLC原理及应用</option>
								<option value="数字电子线路">数字电子线路</option>
								<option value="模拟电子线路">模拟电子线路</option>
								<option value="无线通信软件开发">无线通信软件开发</option>
								<option value="网络设计">网络设计</option>
								<option value="综合布线">综合布线</option>
								<option value="电路基础">电路基础</option>
								<option value="现代交换技术">现代交换技术</option>
								<option value="通信工程设计与管理">通信工程设计与管理</option>
								<option value="网络通信">网络通信</option>
								<option value="串口通信">串口通信</option>
								<option value="供配电技术">供配电技术</option>
								<option value="无线传感器网络">无线传感器网络</option>
								<option value="光纤通信">光纤通信</option>
								<option value="移动通信">移动通信</option>
								<option value="数字通信原理">数字通信原理</option>
								<option value="传感器与检测技术">传感器与检测技术</option>
								<option value="AutoCAD">AutoCAD</option>
								<option value="嵌入式技术">嵌入式技术</option>
								<option value="电子工艺">电子工艺</option>
								<option value="物联网技术">物联网技术</option>
								<option value="单片机原理">单片机原理</option>
								<option value="检测与转换技术">检测与转换技术</option>
								<option value="EDA电路设计">EDA电路设计</option>
							</optgroup>
							<optgroup label="建工系">
								<option value="画法几何与建筑制图">画法几何与建筑制图</option>
								<option value="建筑工程测量">建筑工程测量</option>
								<option value="建筑材料">建筑材料</option>
								<option value="建筑力学">建筑力学</option>
								<option value="结构力学">结构力学</option>
								<option value="建筑构造">建筑构造</option>
								<option value="建筑设计">建筑设计</option>
								<option value="混泥土结构与砌体结构">混泥土结构与砌体结构</option>
								<option value="施工技术">施工技术</option>
								<option value="施工组织设计">施工组织设计</option>
								<option value="地基与基础">地基与基础</option>
								<option value="建筑工程概预算">建筑工程概预算</option>
								<option value="高层建筑结构">高层建筑结构</option>
								<option value="钢结构">钢结构</option>
								<option value="抗震">抗震</option>
								<option value="建筑设备工程">建筑设备工程</option>
								<option value="建筑工程资料管理">建筑工程资料管理</option>
								<option value="建设工程监理">建设工程监理</option>
								<option value="建设法规">建设法规</option>
								<option value="建设工程经济">建设工程经济</option>
								<option value="招标投标与合同管理">招标投标与合同管理</option>
								<option value="文秘管理与应用写作">文秘管理与应用写作</option>
								<option value="社交礼仪">社交礼仪</option>
								<option value="物业管理招标与投标">物业管理招标与投标</option>
								<option value="物业管理实务">物业管理实务</option>
								<option value="物业管理法规">物业管理法规</option>
								<option value="管理学基础">管理学基础</option>
								<option value="装饰施工组织与管理">装饰施工组织与管理</option>
								<option value="建筑装饰工程概预算">建筑装饰工程概预算</option>
								<option value="装饰施工技术">装饰施工技术</option>
								<option value="电脑美术设计">电脑美术设计</option>
								<option value="效果图表现技法">效果图表现技法</option>
								<option value="室内设计原理">室内设计原理</option>
								<option value="房屋建筑学">房屋建筑学</option>
								<option value="建筑绘画">建筑绘画</option>
								<option value="建筑AutoCAD">建筑AutoCAD</option>
								<option value="色彩构成">色彩构成</option>
								<option value="立体构成">立体构成</option>
								<option value="平面构成">平面构成</option>
								<option value="建筑史">建筑史</option>
								<option value="建筑装饰材料">建筑装饰材料</option>
								<option value="建筑装饰制图">建筑装饰制图</option>
								<option value="人体工程学">人体工程学</option>
								<option value="绘画">绘画</option>
								<option value="3DMAX">3DMAX</option>
								<option value="PKPM">PKPM</option>
								<option value="AutoCAD">AutoCAD</option>
								<option value="建设工程项目管理">建设工程项目管理</option>
								<option value="施工组织设计与进度管理">施工组织设计与进度管理</option>
								<option value="建筑施工技术">建筑施工技术</option>
								<option value="施工企业会计与财务">施工企业会计与财务</option>
								<option value="建筑测量">建筑测量</option>
								<option value="建筑工程制图与识图">建筑工程制图与识图</option>
								<option value="物业数据库管理">物业数据库管理</option>
								<option value="物业管理办公自动化">物业管理办公自动化</option>
								<option value="小区规划">小区规划</option>
								<option value="园林与绿化">园林与绿化</option>
								<option value="房地产综合开发与经营">房地产综合开发与经营</option>
								<option value="房地产政策与法规">房地产政策与法规</option>
								<option value="智能建筑的物业管理">智能建筑的物业管理</option>
								<option value="物业管理会计">物业管理会计</option>
								<option value="建筑设计规范">建筑设计规范</option>
								<option value="建筑表现图技法">建筑表现图技法</option>
								<option value="计算机辅助设计">计算机辅助设计</option>
								<option value="外国建筑史">外国建筑史</option>
								<option value="中国建筑史">中国建筑史</option>
								<option value="城市规划原理">城市规划原理</option>
								<option value="园林景观设计">园林景观设计</option>
								<option value="居住区规划设计">居住区规划设计</option>
								<option value="公共建筑原理与设计">公共建筑原理与设计</option>
								<option value="住宅建筑原理与设计">住宅建筑原理与设计</option>
								<option value="建筑设计初步">建筑设计初步</option>
								<option value="建筑安装工程预算">建筑安装工程预算</option>
								<option value="工程造价管理">工程造价管理</option>
								<option value="工程造价案例分析">工程造价案例分析</option>
								<option value="工程经济分析">工程经济分析</option>
							</optgroup>
							<optgroup label="石化系">
								<option value="有机化学">有机化学</option>
								<option value="工程力学">工程力学</option>
								<option value="工程流体力学">工程流体力学</option>
								<option value="油层物理">油层物理</option>
								<option value="钻井工程">钻井工程</option>
								<option value="采油工程">采油工程</option>
								<option value="钻采机械">钻采机械</option>
								<option value="钻井液工艺学">钻井液工艺学</option>
								<option value="石油地质学">石油地质学</option>
								<option value="井下作业与工具">井下作业与工具</option>
								<option value="专业外语">专业外语</option>
								<option value="无机化学基础">无机化学基础</option>
								<option value="精细化学品检测技术">精细化学品检测技术</option>
								<option value="化工仪表及自动化">化工仪表及自动化</option>
								<option value="化工单元操作技术">化工单元操作技术</option>
								<option value="精细化工工艺学">精细化工工艺学</option>
								<option value="精细有机合成">精细有机合成</option>
								<option value="化工制图">化工制图</option>
								<option value="油田化学品生产与应用">油田化学品生产与应用</option>
								<option value="石油钻采概论">石油钻采概论</option>
								<option value="表面活性剂">表面活性剂</option>
								<option value="高分子化学">高分子化学</option>
								<option value="油田化学">油田化学</option>
								<option value="物理化学">物理化学</option>
								<option value="化工原理">化工原理</option>
								<option value="仪器分析">仪器分析</option>
								<option value="分析化学">分析化学</option>
								<option value="环境污染控制">环境污染控制</option>
								<option value="清洁生产">清洁生产</option>
								<option value="室内环境检测">室内环境检测</option>
								<option value="环境影响评价">环境影响评价</option>
								<option value="固体与噪声治理">固体与噪声治理</option>
								<option value="大气污染控制工程">大气污染控制工程</option>
								<option value="水污染控制工程">水污染控制工程</option>
								<option value="环境监测">环境监测</option>
								<option value="工程制图与CAD">工程制图与CAD</option>
								<option value="环境学概论">环境学概论</option>
								<option value="井控技术">井控技术</option>
							</optgroup>
							<optgroup label="管理系">
								<option value="网络营销">网络营销</option>
								<option value="广告与促销">广告与促销</option>
								<option value="销售管理">销售管理</option>
								<option value="零售管理">零售管理</option>
								<option value="市场调查与预测">市场调查与预测</option>
								<option value="服务营销管理">服务营销管理</option>
								<option value="消费者行为学">消费者行为学</option>
								<option value="市场营销学">市场营销学</option>
								<option value="经济学">经济学</option>
								<option value="管理学">管理学</option>
								<option value="网络营销策划">网络营销策划</option>
								<option value="电子商务案例">电子商务案例</option>
								<option value="网站建设">网站建设</option>
								<option value="网页设计">网页设计</option>
								<option value="网络技术">网络技术</option>
								<option value="物流管理">物流管理</option>
								<option value="网络营销">网络营销</option>
								<option value="网店装修">网店装修</option>
								<option value="网店运营">网店运营</option>
								<option value="电子商务概论">电子商务概论</option>
								<option value="酒店专业英语">酒店专业英语</option>
								<option value="酒店人力资源管理">酒店人力资源管理</option>
								<option value="酒水及酒吧管理">酒水及酒吧管理</option>
								<option value="餐饮运行管理">餐饮运行管理</option>
								<option value="房屋管理实务">房屋管理实务</option>
								<option value="前厅运行与管理">前厅运行与管理</option>
								<option value="酒店管理概论">酒店管理概论</option>
								<option value="旅游心理学">旅游心理学</option>
								<option value="管理学原理">管理学原理</option>
								<option value="旅游地理">旅游地理</option>
								<option value="主要客源国概况">主要客源国概况</option>
								<option value="导游专业英语">导游专业英语</option>
								<option value="旅游学概论">旅游学概论</option>
								<option value="旅行社管理">旅行社管理</option>
								<option value="导游概论">导游概论</option>
								<option value="税务筹划">税务筹划</option>
								<option value="税务会计">税务会计</option>
								<option value="税法">税法</option>
								<option value="财经法规">财经法规</option>
								<option value="会计应用软件">会计应用软件</option>
								<option value="会计电算化">会计电算化</option>
								<option value="管理会计">管理会计</option>
								<option value="成本会计">成本会计</option>
								<option value="财务管理">财务管理</option>
								<option value="审计学">审计学</option>
								<option value="高级财务会计">高级财务会计</option>
								<option value="中级财务会计">中级财务会计</option>
								<option value="会计学基础">会计学基础</option>
								<option value="商务礼仪">商务礼仪</option>
								<option value="商务沟通与谈判">商务沟通与谈判</option>
							</optgroup>
							<optgroup label="基础部">
								<option value="基础英语">基础英语</option>
								<option value="英语语音">英语语音</option>
								<option value="英语语法">英语语法</option>
								<option value="英语听力">英语听力</option>
								<option value="英语口语">英语口语</option>
								<option value="英语泛读">英语泛读</option>
								<option value="英语写作">英语写作</option>
								<option value="旅游英语">旅游英语</option>
								<option value="翻译实践">翻译实践</option>
								<option value="饭店英语">饭店英语</option>
								<option value="商务英语">商务英语</option>
								<option value="旅游学概论">旅游学概论</option>
								<option value="导游基础知识">导游基础知识</option>
								<option value="酒店餐饮服务知识">酒店餐饮服务知识</option>
							</optgroup>
					</select>
					<br />
							<span>出题老师:</span><input type="text" name="chuti_name" class="chuti_name" placeholder="出题老师(不想选择老师请填写    全部    )"/>
							<span>试题出题时间:</span><select name="chuti_shijian" class="chuti_shijian1">
									   <?php
										for($j=$xun-2;$j>=0;$j--){
											$i=$xun-$j-1;//获取第几个月的时间戳
											?>
											
											<option value="<?php echo $beginThismonth=mktime(0,0,0,date('m')-$i,1,date('Y'));?>"><?php echo  floor(($j/12)+2016)."年".(($j%12)+1)."月";?></option>
											
										<?
										}?>
										<option value="1">再往前</option>
								   </select>
							<span>试题截止时间：</span><select name="chuti_jiezhi" class="chuti_jiezhi">
									   <?php
										for($j=$xun-2;$j>=0;$j--){
											$i=$xun-$j-1;//获取第几个月的时间戳
											?>
											
											<option value="<?php echo $beginThismonth=mktime(23,59,59,date('m')-$i,date('t'),date('Y'));?>"><?php echo  floor(($j/12)+2016)."年".(($j%12)+1)."月";?></option>
											
										<?
										}?>
								   </select>
								   <br />
							<input type="submit" class="chuti_sum" name="chuti_submit" id="chuti_submit1" value="开始测试   》" />
						</form>
					</div>
				</div>
				<div class="remen">
					<p>热门考试~~~</p>
					<div class="aa" id="div11">
						<div id="div22">
							<?php
							foreach($re as $v){
								$shu++;
								$na=$v['name'];
								echo "<a href='test_kaoshi.php?text_name=$na' class='test_a'>";
								echo "<div>";
								if($shu==1){
									echo "<span class='span_content' style='color:red;'>";
									echo $na."(当前最热)";
									echo "</span>";
								}else{
									echo "<span class='span_content'>";
									echo $na;
									echo "</span>";
								}
								echo "<span style='color:#aaa; margin-left:20px;float:left;'>";
								echo "(已有".$v['num']."人做过)";
								echo "</span>";
								echo "<span style='float:right;'>";
								echo date('Y-m-h',$v['exam_addtime']);
								echo "</span>";
								echo "</div>";
								echo "</a>";
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include_once("view/right.php"); ?>
		<?php include_once("view/footer.html"); ?>
	</div>
</body>
<script>
	
	window.onload=function(){
		start();
		setInterval(function(){start()},3000);
		
		//无缝滚动
		var oDiv = document.getElementById('div11');
		var oUl = document.getElementById('div22');
		var oli = oUl.getElementsByTagName('a');
		var timer = null;
		var speed = -1;
		oUl.innerHTML += oUl.innerHTML;
		oUl.style.height = oli.length * oli[0].offsetHeight + 'px';
	
		timer = setInterval(fnMove, 100);
	
		function fnMove() {
	
			if(oUl.offsetTop < -oUl.offsetHeight / 2) {
				oUl.style.top = 0;
			}
			oUl.style.top = oUl.offsetTop + speed + 'px';
	
		};
	
		oDiv.onmouseover = function() {
			clearInterval(timer);
		};
	
		oDiv.onmouseout = function() {
			timer = setInterval(fnMove, 50);
		};	
		
	}
	
	function yincang(that){
		var oLi=kao.getElementsByTagName('li');
		if(that.innerHTML=='课程随机'){
			suiji.style.display='block';
			remen.style.display='none';
			zhuanye.style.display='none';
			for(var i=0;i<oLi.length;i++){
				oLi[i].className='';
			}
			that.className='ho';
		}else if(that.innerHTML=='热门随机'){
			remen.style.display='block';
			zhuanye.style.display='none';
			suiji.style.display='none';
			for(var i=0;i<oLi.length;i++){
				oLi[i].className='';
			}
			that.className='ho';
		}else{
			remen.style.display='none';
			zhuanye.style.display='block';
			suiji.style.display='none';
			for(var i=0;i<oLi.length;i++){
				oLi[i].className='';
			}
			that.className='ho';
		}
	}
	
	function getStyle(obj, attr) {
		return obj.currentStyle ? obj.currentStyle[attr] : getComputedStyle(obj)[attr];
	}

	function start(){
		var oDiv=kaoshi1.getElementsByTagName('div');
		var a=['学','霸','养','成','平','台'];
		for(var i=0;i<oDiv.length;i++){
			oDiv[i].innerHTML=a[i];
			oDiv[i].style.left=50+i*110+'px';
			shake(oDiv[i],'left');
		}
	}
	
	function shake(obj,attr){
		var pos = parseInt( getStyle(obj, attr));
		var arr = [];
		var num=0;
		for ( var i=5; i>0; i-=1 ) {
		arr.push( i, -i );
		}
			arr.push(0);
		
			clearInterval(obj.shake);
			obj.shake = setInterval(function (){
			obj.style[attr] = pos + arr[num] + 'px';
			num++;
			if ( num === arr.length ) {
				clearInterval( obj.shake );
			}
		}, 50);
	}
	
</script>
