<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en_US" lang="en_US" dir="ltr">
<?php require_once('config.php'); ?>
<html>
<!-- by Tom Sampson 12/20/2016 -->
<head>
	<base href="<?=$base_ref?>" />
	<title><?=$header_description?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="en_US" />
	<meta name="description" content="<?=$header_content?>" />
	<meta name="keywords" content="<?=$header_keywords?>" />
	<meta name="viewport" content="user-scalable = yes">
	<link href="favicon.ico" rel="favicon" type="image/x-icon" />
	<link rel="stylesheet" href="styles/default.css" type="text/css" />
</head>
<body>
	<center>
		<img src="make_logo.php" height=100 width=1020>
		<table class="topmenublock">
			<tr style="background-image:none;padding:0px;height:43px">
				<td style="background-image:none;padding:0px;padding-top:12px;border-collapse: collapse;" align="center"><a style="border-collapse: collapse;" href="<?=$url_home?>"><img src="<?=$image_path?><?=$img_home?>"></a></td>
				<td style="background-image:none;padding:0px;padding-top:12px;border-collapse: collapse;" align="center"><a style="border-collapse: collapse;" href="<?=$url_players?>"><img src="<?=$image_path?><?=$img_players?>"></a></td>
				<td style="background-image:none;padding:0px;padding-top:12px;border-collapse: collapse;" align="center"><a style="border-collapse: collapse;" href="<?=$url_guilds?>"><img src="<?=$image_path?><?=$img_guilds?>"></a></td>
				<td style="background-image:none;padding:0px;padding-top:12px;border-collapse: collapse;" align="center"><a style="border-collapse: collapse;" href="<?=$url_forums?>" target="_new"><img src="<?=$image_path?><?=$img_forums?>"></a></td>
				<td style="background-image:none;padding:0px;padding-top:12px;border-collapse: collapse;" align="center"><a style="border-collapse: collapse;" href="<?=$url_discord?>"  target="_blank"><img src="<?=$image_path?><?=$img_discord?>"></a></td>
				<td style="background-image:none;padding:0px;padding-top:12px;border-collapse: collapse;" align="center"><a style="border-collapse: collapse;" href="<?=$url_about?>"><img src="<?=$image_path?><?=$img_about?>"></a></td>				
			</tr>
		</table>

