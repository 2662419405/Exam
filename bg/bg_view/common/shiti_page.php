<div class="re_teacher_page">
	<div id="page">
		<a href="?shijuan=<?php echo $shijuan;?>&keyword=<?php echo $keyword;?>&pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>"><<</a>
		<?php
			for($i=1;$i<8;$i++){
				$ye=$pageNum-4+$i;
				if($ye==$pageNum){
					?>
					<a href="#" class="page_teacher">
						<?php echo $pageNum?>
					</a>
					<?
				}else{
					if($ye>=1&&$ye!=$pageNum){
						if($ye>$yeshu){
							
						}else{
							if($ye>$toutal){//如果当前页数大于总页数，不显示
								
							}else{
								echo "<a href='?shijuan=$shijuankeyword=$keyword&pageNum=$ye'>";
								echo $ye;
								echo "</a>";
							}
						}
					}
				}
			}
			?>
		<a href="?shijuan=<?php echo $shijuan;?>&keyword=<?php echo $keyword;?>&pageNum=<?php echo $pageNum==$yeshu?$yeshu:($pageNum+1)?>">>></a>
	</div>
</div>