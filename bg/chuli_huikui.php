<?php
	require('library/Db.class.php');
    require("library/function.php");
	is_login();
	$db = new Db();
	$user_id = $_SESSION['user']['id'];
	$user = $db->row("select * from user where id = :user_id",array('user_id'=>$user_id));
	include("bg_view/header.html");
	
	$wenti_id=$_GET['chuli_id'];//接受报错id的回馈
	$biaoji=$_GET['biaoji'];//标记为1表示学习经验  2 意见  3 报错
	
	if($biaoji==1){
		
		$sql="select * from exception where id =:s";
		$chaxun=$db->query($sql,array('s'=>$wenti_id));
		$tou=$db->single("select count(*) from exception where height=2");
		
	}elseif($biaoji==2){
		
		$sql="select * from fankui where id =:s";
		$chaxun=$db->query($sql,array('s'=>$wenti_id));
		
	}elseif($biaoji==3){
		
		$sql="select * from exam_baocuo where cuowu_id =:s";
		$chaxun=$db->query($sql,array('s'=>$wenti_id));
		
	}
	
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
            	描述：信息处理中心
            -->
            <div  class="border_content">
            	<div class="low">
            		<div class="col">
            			<div class="box_title">
            				<h4>信息处理中心</h4>
            			</div>
            			<div class="box_content">
            				<?php
            					if($biaoji==1){
            						?>
            						
        						<form method="post" action="ajaxHuikui.php">
        							<input type="hidden" name="huikui_id" id="huikui_id" value="<?php echo $wenti_id?>" />
									<div class="form_group">
	            						<label class="clo_sm">姓名&nbsp;:</label>
	            						<div class="clo_sm_2">
	            							<input type="text" readonly="readonly" name="huikui_name" value="<?php echo $chaxun[0]['user_name']?>"/>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<label class="clo_sm">支持&nbsp;:</label>
	            						<div class="clo_sm_2">
	            							<input type="text" readonly="readonly" name="huikui_good" value="<?php echo $chaxun[0]['good']?>"/>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<label class="clo_sm">反对&nbsp;:</label>
	            						<div class="clo_sm_2">
	            							<input type="text" readonly="readonly" name="huikui_low" value="<?php echo $chaxun[0]['low']?>"/>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<label class="clo_sm">发布时间&nbsp;:</label>
	            						<div class="clo_sm_2">
	            							<input readonly="readonly" type="text" name="huikui_time" value="<?php echo tranTime($chaxun[0]['addtime']) ?>"/>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<label class="clo_sm">
	            							经验内容&nbsp;:
	            						</label>
	            						<div class="clo_sm_2">
	            							<textarea name="huikui_content"><?php echo $chaxun[0]['content']?></textarea>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<label class="clo_sm">推荐与否&nbsp;:</label>
	            						<div class="clo_sm_2">
	            							<select name="huikui_tui" class="xi_tiku" id="xi_tiku">
		            							<option value='0'> </option>
		            							<option value='2'>推荐</option>
		            							<option value='1'>反对</option>
		            						</select>
		            						<span style="color: orange;"><?php
		            							echo "首页面可推荐8个(当前".$tou."个)";
            									?>
		            						</span>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<div class="clo_sm_3">
	            							<!--
                                            	作者：2662419405@qq.com
                                            	时间：2019-01-22
                                            	描述：对回馈的是哪个信息进行判断
                                            -->
	            							<input type="hidden" name="huikui_biaoji" id="huikui_biaoji" value="1" />
			            					<input type="submit" value="提交" class="shiti_tijiao"/>
		            					</div>
	            					</div>
								</form>      
            						
            					<?
            					}elseif($biaoji==2){
            						?>
            						
            						<div class="form_group">
	            						<label class="clo_sm">
	            							姓名&nbsp;:
	            						</label>
	            						<div class="clo_sm_2">
	            							<input type="text" readonly="readonly" name="xuan_A" value="<?php echo $chaxun[0]['user_name']?>"/>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<label class="clo_sm">发布时间&nbsp;:</label>
	            						<div class="clo_sm_2">
	            							<input readonly="readonly" type="text" name="huikui_time" value="<?php echo tranTime($chaxun[0]['addtime']) ?>"/>
	            						</div>
	            					</div>
	            					<div class="form_group">
	            						<label class="clo_sm">
	            							反馈内容&nbsp;:
	            						</label>
	            						<div class="clo_sm_2">
	            							<textarea readonly="readonly" name="chuti_content"><?php echo $chaxun[0]['content']?></textarea>
            						</div>
            					</div>
            					<div class="form_group">
            						<div class="clo_sm_3">
		            					<input type="button" value="了解" class="shiti_tijiao" onclick="window.location.href='yijian_huikui.php'"/>
	            					</div>
            					</div>
            						
            					<?
            					}elseif($biaoji==3){
            						?>
            						
            						<form method="post" action="ajaxHuikui.php">
	        							<input type="hidden" name="huikui_id" id="huikui_id" value="<?php echo $wenti_id?>" />
										<div class="form_group">
		            						<label class="clo_sm">姓名&nbsp;:</label>
		            						<div class="clo_sm_2">
		            							<input type="text" readonly="readonly" name="huikui_name" value="<?php echo $chaxun[0]['exam_name']?>"/>
		            						</div>
		            					</div>
		            					<div class="form_group">
		            						<label class="clo_sm">专业&nbsp;:</label>
		            						<div class="clo_sm_2">
		            							<input type="text" readonly="readonly" name="huikui_good" value="<?php echo $chaxun[0]['exam_xi']?>"/>
		            						</div>
		            					</div>
		            					<div class="form_group">
		            						<label class="clo_sm">哪个表&nbsp;:</label>
		            						<div class="clo_sm_2">
		            							<input type="text" readonly="readonly" name="huikui_good" value="<?php if($chaxun[0]['biaoji']==1){
		            								echo "课堂随机";
		            							}else{
		            								echo "热门题库";
		            							}?>"/>
		            						</div>
		            					</div>
		            					<div class="form_group">
		            						<label class="clo_sm">发布时间&nbsp;:</label>
		            						<div class="clo_sm_2">
		            							<input readonly="readonly" type="text" name="huikui_time" value="<?php echo tranTime($chaxun[0]['exam_addtime']) ?>"/>
		            						</div>
		            					</div>
		            					<div class="form_group">
		            						<label class="clo_sm">
		            							反馈内容&nbsp;:
		            						</label>
		            						<div class="clo_sm_2">
		            							<textarea readonly="readonly" name="huikui_content"><?php echo $chaxun[0]['exam_content']?></textarea>
		            						</div>
		            					</div>
		            					<div class="form_group">
		            						<label class="clo_sm"></label>
		            						<div class="clo_sm_2">
		            						</div>
		            					</div>
		            					<div class="form_group">
		            						<label class="clo_sm">考题详情&nbsp;:</label>
		            						<div class="clo_sm_2">
		            						</div>
		            					</div>
		            					
		            					<!--
                                        	作者：2662419405@qq.com
                                        	时间：2019-01-22
                                        	描述：考题内容
                                        -->
                                        
                                        <?php
                                        	if($chaxun[0]['biaoji']==1){
                                        		$sql11="select * from exam_problem where id =:s";
												$chaxun1=$db->query($sql11,array('s'=>$chaxun[0]['cuowu_id']));
                                        	}else{
                                        		$sql11="select * from exam_hot where id =:s";
												$chaxun1=$db->query($sql11,array('s'=>$chaxun[0]['cuowu_id']));
                                        	}
                                        	$biao=$chaxun[0]['biaoji'];
                                        	?>
                                        <div class="form_group">
		            						<label class="clo_sm">考题题目&nbsp;:</label>
		            						<div class="clo_sm_2">
		            							<textarea readonly="readonly" name="huikui_time" value=""/><?php echo $chaxun1[0]['content']?></textarea>
		            						</div>
		            					</div>
		            					<?php if($chaxun1[0]['pro_type']==1){
		            						?>
		            						<div class="form_group">
			            						<label class="clo_sm">
			            							A选项&nbsp;:
			            						</label>
			            						<div class="clo_sm_2">
			            							<input readonly="readonly" type="text" name="xuan_A" value="<?php echo $chaxun1[0]['xuanze_A']?>"/>
			            						</div>
			            					</div>
			            					<div class="form_group">
			            						<label class="clo_sm">
			            							B选项&nbsp;:
			            						</label>
			            						<div class="clo_sm_2">
			            							<input readonly="readonly" type="text" name="xuan_B" value="<?php echo $chaxun1[0]['xuanze_B'];?>"/>
			            						</div>
			            					</div>
			            					<div class="form_group">
			            						<label class="clo_sm">
			            							C选项&nbsp;:
			            						</label>
			            						<div class="clo_sm_2">
			            							<input readonly="readonly" type="text" name="xuan_C" value="<?php echo  $chaxun1[0]['xuanze_C']?>"/>
			            						</div>
			            					</div>
			            					<div class="form_group">
			            						<label class="clo_sm">
			            							D选项&nbsp;:
			            						</label>
			            						<div class="clo_sm_2">
			            							<input readonly="readonly" type="text" name="xuan_D" value="<?php echo  $chaxun1[0]['xuanze_D']?>"/>
			            						</div>
			            					</div>
		            					<?}?>
		            					<div class="form_group">
		            						<label class="clo_sm">
		            							答案&nbsp;:
		            						</label>
		            						<div class="clo_sm_2">
		            							<input readonly="readonly" type="text" name="xuan_D" value="<?php if($chaxun1[0]['pro_type']==3){if($chaxun1[0]['answer']==1){echo "正确";}else{echo "错误";}}else{
		            								echo $chaxun1[0]['answer'];
		            							}?>"/>
		            						</div>
		            					</div>
							            					
		            					<div class="form_group">
		            						<div class="clo_sm_3" style="margin-left: 40%;">
		            							<!--
	                                            	作者：2662419405@qq.com
	                                            	时间：2019-01-22
	                                            	描述：对回馈的是哪个信息进行判断
	                                            -->
		            							<input type="hidden" name="huikui_biaoji" id="huikui_biaoji" value="2" />
				            					<input type="submit" value="没有问题" class="shiti_tijiao" title="认为没有问题点击" style="margin-right: 5%;"/>
				            					<input type="button" value="开始处理" class="shiti_tijiao" title="点击编辑具体详情" onclick="window.location.href='bianji_shiti.php?biaoji=<?php echo $biao?>&shiti_id=<?php echo $wenti_id?>'"/>
			            					</div>
		            					</div>
									</form>  
            					<?
            					}
            					?>
            			</div>
            		</div>
            	</div>
            </div>
		</div>
	</div>
</body>
</html>