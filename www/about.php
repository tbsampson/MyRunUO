<?php
  include('header.php');
echo <<<EOF

		<table class="defaulttable" width=1000">
			<tr class="defaulttable">
			 <td width=190 class="defaulttable">
EOF;




// ------------------------------------------ Server Status

echo <<<EOF
		<table width=160 class="defaulttable">
			<tr class="defaulttable">
				<th colspan=2></th>
			</tr>
			<tr class="defaulttable">
<img class="statusscroll" src="images/server_status.png">			
EOF;
		

error_reporting(E_ERROR | E_PARSE); // Turn off error reporting for failed fsockopen

$fp = fsockopen($shard_addr, $shard_port);

if (!$fp) {
    echo "<td class=\"red\" align=\"center\">Offline</td></tr></table>";
	}
	else {

    fwrite($fp, "\x7f\x00\x00\x01\xf1\x00\x04\xff");
    stream_set_timeout($fp, 1);
    $res = fread($fp, 2000);

    $info = stream_get_meta_data($fp);
    fclose($fp);

    if ($info['timed_out']) {
        echo "<td class=\"red\" align=\"center\">Offline</td></tr></table>";
    }
	else {

	$ver = '';

	$arr = explode(',', $res);
// print_r($arr); // Uncomment if you want to see the raw array
	
$emu 	 = $arr[0];
$name 	 = ltrim(strstr($arr[1],'='), '=');
$age 	 = ltrim(strstr($arr[2], '='), '=');
$clients = ltrim(strstr($arr[3], '='), '=');
$items 	 = ltrim(strstr($arr[4], '='), '=');
$mobs 	 = ltrim(strstr($arr[5], '='), '=');
$mem 	 = ltrim(strstr($arr[6], '='), '=');

if ($emu <> "ServUO") $ver = "Unknown"; // Only ServUO Shards return version
else $ver = ltrim(strstr($arr[07], '='), '=');

if ($name == '' || $age == '') { // Server is online but blocking repeated requests
    echo "<td class=\"green\" align=\"center\">Online</td></tr></table>";
	}
else {
echo <<<EOF



		<td colspan=2 class="green" align="center" style="font-size:20px;">Online</td>
	</tr>
	<tr class="defaulttable">
		<th class="status_title">Emu:</th>
		<td class="status_results">$emu</td>
	</tr>
	<tr class="defaulttable">
		<th class="status_title">Name:</th>
		<td class="status_results">$name</td>
	</tr>
	<tr class="defaulttable">
		<th class="status_title">Uptime:</th>
		<td class="status_results">$age hours</td>
	</tr>
	<tr class="defaulttable">
		<th class="status_title">Players Online:</th>
		<td class="status_results">$clients</td>
	</tr>
	<tr class="defaulttable">
		<th class="status_title">Total Items:</th>
		<td class="status_results">$items</td>
	</tr>
	<tr class="defaulttable">
		<th class="status_title">Mobs:</th>
		<td class="status_results">$mobs</td>
	</tr>
<!-- <tr class="defaulttable">
		<th class="status_title">Memory Used:</th>
		<td class="status_results">$mem</td>
	</tr>	
	<tr class="defaulttable">
		<th class="status_title">Version:</th>
		<td class="status_results">$ver</td>
	</tr> -->
</table>
</div>
EOF;
    }
	}
}

?>
			 </td>
			 <td width=810 class="defaulttable">

		<table width=810>
			<tr style="background-image:none;padding:20px;" height="248">
				<td colspan=4 class="gold" style="padding:20px;padding-top:10px;;padding-left:30px;background-image:url(images/yellow_bar_grad_980.png);background-size: 810px 248px;"><?=$text_banner?></td>
			</tr>
		</table>
		
				</td>
			</tr>
		</table>
<!--  Setup info    -->
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
