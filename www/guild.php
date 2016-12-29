<?php

include('header.php');

check_get($id, "id");
$id = intval($id);

$link = sql_connect();

// Get guild data
$result = sql_query($link, "SELECT * FROM myrunuo_guilds WHERE guild_id=$id LIMIT 1");
if ($row = mysqli_fetch_array($result)) {
  mysqli_free_result($result);
  while (list($key, $val) = each($row))
    ${$key} = $val;

  $guild_wars = intval($guild_wars);
  $guild_members = intval($guild_members);
  $guild_master = intval($guild_master);

  // $capguild = strtolower(substr($guild_name, 0, 1)).".gif";
  $full_name = $guild_name;
  // $guild_name = substr($guild_name, 1);

  if ($guild_website == "")
  {
	      $guild_website = "";
  }

  if ($guild_charter == "")
    $guild_charter = "A Charter has not yet been created.";
}
else {
  echo "Invalid guild ID.<br>\n";
  mysqli_close($link);
  die();
}

$result = sql_query($link, "SELECT char_name FROM myrunuo_characters WHERE char_id=$guild_master LIMIT 1");
if (!(list($master_name) = mysqli_fetch_row($result)))
  $master_name = "None";
mysqli_free_result($result);

// Last Update
$result = sql_query($link, "SELECT timestamp FROM   myrunuo_updates ORDER  BY timestamp DESC LIMIT  1");
if (!(list($timestamp) = mysqli_fetch_row($result)))
  $timestamp = "";
mysqli_free_result($result);

	if ($guild_type == "Standard"){
			$type_icon = "images/shields/wooden.png";
	}			
	else if ($guild_type == "Order"){
			$type_icon = "images/shields/order.png";
	}
	else if ($guild_type == "Chaos"){
			$type_icon = "images/shields/chaos.png";
	}
	
echo <<<EOF
<table width=530>
  <tr valign="middle"> 
    <th class="green" colspan="2" style="text-align:center;">$guild_name&nbsp;($guild_abbreviation)</th>
    <th class="gold" style="text-align:center;">Guild Charter</th>
	<th></th>
  </tr>
  <tr>
    <td width="100" class="gold" style="text-align:right;background-image: url(images/bg_dark_slate.png);">Type:</td>
    <td width="200" class="cyan" style="background-image: url(images/bg_dark_slate.png);">$guild_type</td>
	<td width="200" class="gold" rowspan=4 style="font-size:20px;padding:10px;background-image: url(images/bg_light_slate.png);">$guild_charter</td>
	<td width="30" rowspan=4 style="background-image: url(images/bg_dark_slate.png);"></td>
  </tr>
  <tr> 
    <td class="gold" style="background-image: url(images/bg_dark_slate.png);text-align:right">Leader:</td>
    <td class="cyan" style="background-image: url(images/bg_dark_slate.png);"><a href="player.php?id=$guild_master">$master_name</a></td>
  </tr>
  <tr> 
    <td class="gold" style="background-image: url(images/bg_dark_slate.png);text-align:right">Members:</td>
    <td class="cyan" style="background-image: url(images/bg_dark_slate.png);">$guild_members</td>
  </tr>
  <tr> 
    <td class="gold" style="background-image: url(images/bg_dark_slate.png);text-align:right">Enemies:</td>
    <td class="red" style="background-image: url(images/bg_dark_slate.png);">$guild_wars</td>
  </tr>
  <tr>
    <td colspan=2 class="cyan" style="background-image: url(images/bg_dark_slate.png);text-align:center"><a href="skills.php?id=$id&nc=$guild_members&g=$full_name">Click to See Skill Averages</a></td>
	<td class="cyan" style="background-image: url(images/bg_dark_slate.png);text-align:center"><a href="$guild_website" target="_blank">$guild_website</a></td>
	<td style="background-image: url(images/bg_dark_slate.png);"></td>
  </tr>
</table>

<img class="guildshield" src="$type_icon">

<br>
<table width="530">
  <tr>
    <th class="gold">Members</th>
    <th class="gold">Recently at war with</th>
  </tr>
  <tr>
    <td width=265 class="cyan">

EOF;

	
// Guild Members
$result = mysqli_query($link, "SELECT char_id,char_name,char_nototitle,char_guildtitle,char_public FROM myrunuo_characters WHERE char_guild=$id");
if (mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_row($result)) {
    $charid = intval($row[0]);
    $charname = $row[1];
    $chartitle = $row[2];
    $charguildtitle = $row[3];
    $charpublic = intval($row[4]);

    if (strcasecmp($charguildtitle, "NULL"))
      $charguildtitle = " [$charguildtitle]";
    else
      $charguildtitle = "";

    $cma = strpos($chartitle, ",");
    $namedisplay = substr($chartitle, 0, $cma);
    $chartitle = substr($chartitle, $cma);

    echo "<a href=\"player.php?id=$charid\">$chartitle</a> $charguildtitle<br>\n";
  }
}

echo <<<EOF
    </td>
    <td width=265 class="green">

EOF;

// Guild Wars 1
$result = mysqli_query($link, "SELECT guild_name,guild_2 FROM myrunuo_guilds_wars INNER JOIN myrunuo_guilds ON guild_2=guild_id WHERE guild_1=$id");
$num1 = mysqli_num_rows($result);

if ($num1) {
  while ($row = mysqli_fetch_row($result)) {
    $war_name = $row[0];
    $war_id = intval($row[1]);
    echo "<a href=\"guild.php?id=$war_id\">$war_name</a>";
  }
}

// Guild Wars 2
$result = mysqli_query($link, "SELECT guild_name,guild_1 FROM myrunuo_guilds_wars INNER JOIN myrunuo_guilds ON guild_1=guild_id WHERE guild_2=$id");
$num2 = mysqli_num_rows($result);
if ($num2) {
  while ($row = mysqli_fetch_row($result)) {
    $war_name = $row[0];
    $war_id = intval($row[1]);
    echo "<a href=\"guild.php?id=$war_id\">$war_name</a>";
  }
}

if (!$num1 && !$num2)
  echo "None";

mysqli_close($link);

if ($timestamp != "")
  $dt = date("F j, Y, g:i a", strtotime($timestamp));
else
  $dt = date("F j, Y, g:i a");

echo <<<EOF
  </tr>
  <tr>
    <td class="grey" style="text-align:center;font-size:75%;font-style: italic;" colspan="4">
      <small>Last Updated&nbsp;:&nbsp;$dt</small>
    </td>
  </tr>
</table>

</body>
</html>

EOF;

?>