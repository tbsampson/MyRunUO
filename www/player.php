<?php

include('header.php');
check_get($id, "id");
$id = intval($id);
$link = sql_connect();

// Get a list of skills for the player
$result = mysqli_query($link, "SELECT `id`,`short_name`,`long_name`,`uo_guide_name` FROM myrunuo_skills LEFT JOIN myrunuo_characters_skills ON myrunuo_skills.id=myrunuo_characters_skills.skill_id WHERE myrunuo_characters_skills.char_id=$id");

echo <<<EOF
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>View Player</title>
  <meta http-equiv="Content-Type" content="text/html; CHARSET=iso-8859-1">
</head>
<link rel="stylesheet" type="text/css" href="./styles/default.css" media="screen" />
<body>
EOF;

if ($id) {
  $result = mysqli_query($link, "SELECT char_name,char_nototitle FROM myrunuo_characters WHERE char_id=$id");
  if (!(list($charname,$chartitle) = mysqli_fetch_row($result))) {
    echo "Invalid character ID!\n";
    die();
  }
  mysqli_free_result($result);

  echo <<<EOF
<table>
    <tr>
		<th colspan=3 style="font-size:6px;">&nbsp;</th>
	</tr>
	<tr>
	<td colspan="3" align="center" valign="top" style="background-image: url(images/bg_dark_slate.png);">
      <img src="paperdoll.php?id=$id" width="304" height="505">
    </td>
    </th>
	</tr>
	<tr>
EOF;

  $result = sql_query($link, "SELECT id,short_name,long_name,uo_guide_name,myrunuo_characters_skills.skill_value AS skill_value 
								FROM myrunuo_skills LEFT JOIN myrunuo_characters_skills ON myrunuo_skills.id=myrunuo_characters_skills.skill_id 
								WHERE myrunuo_characters_skills.char_id=$id
								ORDER BY myrunuo_characters_skills.skill_value DESC LIMIT 3");
  $num = 0;
  while (list($skillid,$skillshort,$skilllong,$skilluoguide,$skillvalue) = mysqli_fetch_row($result)) {
    $skillid = intval($skillid);
	$image = "images/skills/".$skilluoguide.".png";
	$skillrank = '';
	if ($skillvalue >= 1200 ) $skillrank = "Legendary<br>";
		else if ($skillvalue >= 1100 ) $skillrank = "Elder<br>";
			else if ($skillvalue >= 1000 ) $skillrank = "Grandmaster<br>";
	
    echo <<<EOF
    <td align="center" valign="top">
      <a href="http://www.uoguide.com/$skilluoguide" target="_blank"><img src="$image" border="0" width="100" height="64" alt="$skilllong"></a><br><p class="grey" style="text-align:center; font-size:70%; font-style:italic;">$skillrank$skilllong</p>
    </td>
EOF;
    $num++;
  }
  mysqli_free_result($result);

  while ($num < 3) {
    echo "    <td>&nbsp;</td>\n";
    $num++;
  }

  echo "</tr>\n";

 $result = sql_query($link, "SELECT myrunuo_guilds.guild_id,myrunuo_guilds.guild_name FROM myrunuo_characters INNER JOIN myrunuo_guilds ON myrunuo_characters.char_guild=myrunuo_guilds.guild_id WHERE myrunuo_characters.char_id=$id");
  if (list($gid,$guild) = mysqli_fetch_row($result)) {
    $gid = intval($gid);
    echo <<<EOF
  <tr style="background-image: url(images/bg_dark_slate.png);">
    <td align="center" colspan="3"><p class="green" style="text-align:center; font-size:90%; font-style:bold;">Guild:<a href="guild.php?id=$gid">$guild</a></p>
    </td>
  </tr>

EOF;
  }
  mysqli_free_result($result);
}

mysqli_close($link);

echo <<<EOF
</table>

</body>
</html>

EOF;
include('footer.php');
?>