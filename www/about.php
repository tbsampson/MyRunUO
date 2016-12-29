<?php
  include('header.php');
  
  ?>
		</table>
		<table width=960>
			<tr>
				<th class="cyan" style="text-align:center;text-decoration: underline;"><a href="<?=$url_download_client?>"><font color ="#e7cf4a"><?=$text_step_one?></font>&nbsp;<?=$text_download_client?></a></th>
				<th class="cyan" style="text-align:center;text-decoration: underline;"><a href="<?=$url_download_razor?>"><font color ="#e7cf4a"><?=$text_step_two?></font>&nbsp;<?=$text_download_razor?></a></th>
			</tr>
			<tr>

				<td style="background-image: url(images/bg_dark_slate.png);"><img src="<?=$image_path?>getting_started.png" width="356" height="142"></td>
				<td style="background-image: url(images/bg_dark_slate.png);" rowspan="2"><img src="<?=$image_path?>uo_load_screen.png" width="570" height="426"></td>
			</tr>
			<tr>
				<td style="background-image: url(images/bg_dark_slate.png);"><img src="razor_setup.php" width="356" height="284"></td>

			</tr>
			<tr>
				<th class="cyan" style="text-align:center;font-size:18px;"><font color ="#e7cf4a"><?=$text_step_three?></font>&nbsp;<font color ="#FFFFFF"><?=$text_enter_server_info?></font></th>
				<th class="cyan" style="text-align:center;font-size:18px;"><font color ="#e7cf4a"><?=$text_step_four?></font>&nbsp;<font color ="#FFFFFF"><?=$text_create_account?></font></th>
			<tr>			
		</table>
	</center>
<?php include('footer.php');?>
