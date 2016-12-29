<?php
include('header.php');
require("skill_list.php");

check_get($id, "id");
$id = intval($id);

check_get($nc, "nc");
$nc = intval($nc);

check_get($guild, "g");
$guild = htmlspecialchars($guild);

$link = sql_connect();

// Last Update
$result = sql_query($link, "SELECT timestamp FROM   myrunuo_updates ORDER  BY timestamp DESC LIMIT  1");
if (!(list($timestamp) = mysqli_fetch_row($result)))
  $timestamp = "";
mysqli_free_result($result);
echo <<<EOF

<table width=530>
    <tr> 
      <th colspan="3" class="gold" style="text-align:center;">Skill Averages<a href="guild.php?id=$id"><p class="green">$guild</p></a></th>
    </tr>
EOF;

$result = sql_query($link, "SELECT id, short_name, long_name, uo_guide_name, SUM(myrunuo_characters_skills.skill_value) AS skill_total
							FROM myrunuo_skills
							JOIN myrunuo_characters_skills ON  myrunuo_skills.id = myrunuo_characters_skills.skill_id
							JOIN myrunuo_characters ON myrunuo_characters.char_id = myrunuo_characters_skills.char_id
							WHERE myrunuo_characters.char_guild = $id
							GROUP BY myrunuo_skills.id
							ORDER BY myrunuo_skills.short_name"); // AND char_public=1
				
							
  while (list($skillid,$skillshort,$skilllong,$skilluoguide,$skilltotal) = mysqli_fetch_row($result)) {
    $skillid = intval($skillid);
	$image = "images/skills/".$skilluoguide.".png";
	$skilltotal = number_format((float)$skilltotal / 10, 1, '.', '');
	
	
    echo <<<EOF
    <tr>
	  <td width=50><a href="http://www.uoguide.com/$skilluoguide" target="_blank"><img src="$image" border="0" width="50" height="32" alt="$skilllong"></a></td>
	  <td width=420 class = "gold">$skilllong</td>
	  <td width=50 class = "gold" style="text-align:right;padding-right:10px;">$skilltotal</td>
	</tr>
EOF;

  }

mysqli_free_result($result);
mysqli_close($link);

if ($timestamp != "")
  $dt = date("F j, Y, g:i a", strtotime($timestamp));
else
  $dt = date("F j, Y, g:i a");

echo <<<EOF

    </tr>
    <td class="white" style="text-align:center;font-size:90%;font-style: italic;" colspan="4">
      <small>Last Updated&nbsp;:&nbsp;$dt</small>
    </td>
</table>

</body>
</html>

EOF;

?>