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

$fp = pfsockopen($shard_addr, $shard_port);

if (!$fp) {
    echo "<td class=\"red\" align=\"center\">Offline</td></tr></table>";
} else {

    fwrite($fp, "\x7f\x00\x00\x01\xf1\x00\x04\xff");
    stream_set_timeout($fp, 1);
    $res = fread($fp, 2000);

    $info = stream_get_meta_data($fp);
    fclose($fp);

    if ($info['timed_out']) {
        echo "<td class=\"red\" align=\"center\">Offline</td></tr></table>";
    } else {

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


// Example usage
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
		
	</center>
<?php include('footer.php');?>
