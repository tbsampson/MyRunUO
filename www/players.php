<?php

include('header.php');
check_get($tp, "tp");
$tp = intval($tp);

check_get($fn, "fn");
if ($fn != "")
  $where = "WHERE char_name LIKE '" . addslashes($fn) . "%'";
else
  $where = "";


// ----------------------------------------------------------------------------------------------------------------------------
check_get($flip, "flip");
if ($flip)
  $sw = "desc";
else
  $sw = "";

check_get($sortby, "sortby");
$s = $sortby;
switch (strtolower($s)) {
  case "kills":
    $sortby = "char_counts";
    break;
  case "karma":
    $sortby = "char_karma";
    break;
  case "fame":
    $sortby = "char_fame";
    break;
  case "gtitle":
    $sortby = "char_guildtitle";
    break;
  case "gname":
    $sortby = "guild_name";
    break;
  case "gabbr":
    $sortby = "guild_abbr";
    break;
  default: // name
    $sortby = "char_name";
}

$nflip = $cflip = $kflip = $fflip = $gtflip = $gnflip = $gaflip = 0;
if (!$flip) {
  if ($sortby == "char_name")
    $nflip = 1;
  else if ($sortby == "char_counts")
    $cflip = 1;
  else if ($sortby == "char_karma")
    $kflip = 1;
  else if ($sortby == "char_fame")
    $fflip = 1;
  else if ($sortby == "char_guildtitle")
    $gtflip = 1;
  else if ($sortby == "guild_name")
    $gnflip = 1;
  else if ($sortby == "guild_abbr")
    $gaflip = 1;
}
// ----------------------------------------------------------------------------------------------------------------------------










$link = sql_connect();

// Total public players
if ($where != "")
  $wherep = $where." AND char_public=0";
else
  $wherep = "WHERE char_public=0";
$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_characters $wherep");
list($totalpublic) = mysqli_fetch_row($result);
$totalpublic = intval($totalpublic);
mysqli_free_result($result);

// Total players
$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_characters $where");
list($totalplayers) = mysqli_fetch_row($result);
$totalplayers = intval($totalplayers);
mysqli_free_result($result);

// Last Update
$result = sql_query($link, "SELECT timestamp FROM   myrunuo_updates ORDER  BY timestamp DESC LIMIT  1");
if (!(list($timestamp) = mysqli_fetch_row($result)))
  $timestamp = "";
mysqli_free_result($result);

echo <<<EOF
<table width="1000">
    <tr>
	  <th width="650"><h1 class="gold">Citizens of $shard_name</h1></th>
	  
	  <th colspan="5" width="350" style="text-align:right; vertical-align:middle; margin-bottom:0;">
			<form action="players.php" method="get" style="margin-bottom:0; margin-right:4;">		    
				<input type="search" placeholder="Search for a player" name="fn">		    	
				<button>Search</button>
			</form>
	  </th>
	</tr>
    <tr style="background-image: url(images/bg_dark_slate.png);">
      <td colspan="6" align="center">
        <table width="994" class="rolodex">
		  <tr class="gold">
			<td class="rolodex" width=30><a href="players.php">ALL</a></td><td class="rolodex" width=30><a href="players.php?fn=A">A</a></td>
			<td class="rolodex" width=30><a href="players.php?fn=B">B</a></td><td class="rolodex" width=30><a href="players.php?fn=C">C</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=D">D</a></td><td class="rolodex" width=30><a href="players.php?fn=E">E</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=F">F</a></td><td class="rolodex" width=30><a href="players.php?fn=G">G</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=H">H</a></td><td class="rolodex" width=30 width=30><a href="players.php?fn=I">I</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=J">J</a></td><td class="rolodex" width=30><a href="players.php?fn=K">K</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=L">L</a></td><td class="rolodex" width=30><a href="players.php?fn=M">M</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=N">N</a></td><td class="rolodex" width=30><a href="players.php?fn=O">O</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=P">P</a></td><td class="rolodex" width=30><a href="players.php?fn=Q">Q</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=R">R</a></td><td class="rolodex" width=30><a href="players.php?fn=S">S</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=T">T</a></td><td class="rolodex" width=30><a href="players.php?fn=U">U</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=V">V</a></td><td class="rolodex" width=30><a href="players.php?fn=W">W</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=X">X</a></td><td class="rolodex" width=30><a href="players.php?fn=Y">Y</a></td> 
			<td class="rolodex" width=30><a href="players.php?fn=Z">Z</a></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td style="width:255px;" class="grey">
        <p class="grey" style="text-align:left; font-size:90%; font-style:italic;">Total Players Found:&nbsp;$totalplayers</p>
	  </td>
	  <td style="width:300px;" class="grey"></td>
	  <td style="width:300px;" class="grey"></td>
      <td width="40">
EOF;

if ($tp - $players_perpage >= 0) {
  $num = $tp - $players_perpage;
echo <<<EOF
	<a href="players.php?tp=$num&fn=$fn&sortby=$s&flip=$flip"><img height="18" width="18" src="images/buttons/arrow_left.png" border="0"></a>
EOF;
}

echo <<<EOF
	</td><td width="65">
EOF;

$page = intval($tp / $players_perpage) + 1;
$pages = ceil($totalplayers / $players_perpage);
if ($pages > 1) {
echo <<<EOF
	<p class="grey" style="text-align:center;font-size:80%;font-style: italic;">Page&nbsp;$page/$pages</p>
EOF;
}

echo <<<EOF
	</td><td width="40">
EOF;

// Players
$result = sql_query($link, "SELECT char_id,char_name,char_race,char_female,char_counts, (case when myrunuo_characters.char_guildtitle <> 'NULL' then myrunuo_characters.char_guildtitle else '' end) AS char_guildtitle ,COALESCE(IFNULL(myrunuo_guilds.guild_name, ''), 'no name') AS guild_name
,COALESCE(IFNULL(myrunuo_guilds.guild_abbreviation, ''), 'no name') AS guild_abbr, myrunuo_guilds.guild_id, myrunuo_characters.char_karma, myrunuo_characters.char_fame
FROM myrunuo_characters LEFT OUTER JOIN myrunuo_guilds ON myrunuo_characters.char_guild = myrunuo_guilds.guild_id $where ORDER by $sortby $sw LIMIT $tp,$players_perpage");
$num = mysqli_num_rows($result);

if ($tp + $players_perpage < $totalplayers) {
  $num = $tp + $players_perpage;
  
echo <<<EOF
	<a href="players.php?tp=$num&fn=$fn&sortby=$s&flip=$flip"><img height="20" width="20" src="images/buttons/arrow_right.png" border="0"></a>
EOF;
}

echo <<<EOF

	</td>
 </tr>
 <tr>
  <td colspan="8">
    <table width="994">

EOF;
$headerloaded=false;
if ($num) {
  while ($row = mysqli_fetch_row($result)) {

if ($headerloaded == false)
	{
		echo <<<EOF
				  <tr>
					  <th class="gold" width="30"></th>
					  <th class="gold" width="224"><a href="players.php?sortby=name&flip=$nflip">Name</a></th>
					  <th class="gold" width="220"><a href="players.php?sortby=gtitle&flip=$gtflip">Guild Title</a></th>
					  <th class="gold" width="220"><a href="players.php?sortby=gname&flip=$gnflip">Guild Name</th>
					  <th class="gold" style="text-align:center" width="70"><a href="players.php?sortby=gabbr&flip=$gaflip">Abbr.</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="players.php?sortby=kills&flip=$cflip">Kills</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="players.php?sortby=karma&flip=$kflip">Karma</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="players.php?sortby=fame&flip=$fflip">Fame</a></th>										  
				  </tr>
EOF;
	}
	$headerloaded = true;
    $id = $row[0];
    $charname = $row[1];
    $race = $row[2];
    $female = $row[3];	
    $counts = $row[4];
    $guild_title = $row[5];	
    $guild_name = $row[6];		
    $guild_abbr = $row[7];
	$guild_id = $row[8];
	$karma = $row[9];
	$fame = $row[10];
    $race_icon = "";
	$gender = "";
	$redblue = "";
	
	if ($counts == 0) $counts = "";
	if ($fame == 0) $fame = "";
	if ($karma == 0) $karma = "";
	if ($karma < 0) $karmacolor = "red";
		else $karmacolor = "cyan";
	if ($karma < 0 && $counts >=5) $redblue = "red";
		else $redblue = "cyan";
	
	if ($female == 1 && $race == "Human"){
			$race_icon = "images/races/icon_hum_fem.png";
			$gender = "Female";
	}			
	else if ($female == 0 && $race == "Human"){
			$race_icon="images/races/icon_hum_male.png";
			$gender = "Male";
	}			
	else if ($female == 1 && $race == "Elf"){
			$race_icon = "images/races/icon_elf_fem.png";
			$gender = "Female";
	}			
	else if($female == 0 && $race == "Elf"){
			$race_icon ="images/races/icon_elf_male.png";
			$gender = "Male";
	}			
	else if ($female == 1 && $race == "Gargoyle"){
			$race_icon ="images/races/icon_garg_fem.png";
			$gender = "Female";
	}			
	else if ($female == 0 && $race == "Gargoyle"){
			$race_icon="images/races/icon_garg_male.png";
			$gender = "Male";
	}			
	
echo <<<EOF
		  <tr>
            <td><img src="$race_icon" height="30" width="30" alt="$gender $race" title="$gender $race"></td>
            <td class="$redblue"><a href="player.php?id=$id">$charname</a></td>
            <td class="green"><a href="guild.php?id=$guild_id">$guild_title</a></td>				
            <td class="green"><a href="guild.php?id=$guild_id">$guild_name</a></td>				
            <td class="green" align="center"><a href="guild.php?id=$guild_id">$guild_abbr</a></td>				
            <td class="red" align="center">$counts</td>
            <td class="$karmacolor" align="center">$karma</td>
            <td class="gold" align="center">$fame</td>			
	      </tr>
EOF;
  }
}
else {
   echo <<<EOF
          <tr>
            <td class="no-results" colspan="8">Your search found no players</td>
          </tr>

EOF;
}

echo <<<EOF
        </table>
      </td>
    </tr>

EOF;

mysqli_free_result($result);
mysqli_close($link);

if ($timestamp != ""){
	$dt = date("F j, Y, g:i a", strtotime($timestamp));
}

else
  $dt = date("F j, Y, g:i a");

echo <<<EOF
  <tr>
    <td class="grey" style="text-align:center;font-size:75%;font-style: italic;" colspan="6">
      <small>Last Updated&nbsp;:&nbsp;$dt</small>
    </td>
  </tr>

</table>

</body> 
</html>

EOF;
include('footer.php');
?>