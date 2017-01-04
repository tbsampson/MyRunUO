<?php
include('header.php');

// ---------------------------------------------------------------------------------------------------------------------------- Status
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

// Players
$result = sql_query($link, "SELECT myrunuo_characters.char_id,char_name,char_race,char_female,char_counts, (case when myrunuo_characters.char_guildtitle <> 'NULL' then myrunuo_characters.char_guildtitle else '' end) AS char_guildtitle ,COALESCE(IFNULL(myrunuo_guilds.guild_name, ''), 'no name') AS guild_name
,COALESCE(IFNULL(myrunuo_guilds.guild_abbreviation, ''), 'no name') AS guild_abbr, myrunuo_guilds.guild_id, myrunuo_characters.char_karma, myrunuo_characters.char_fame
FROM myrunuo_characters LEFT OUTER JOIN myrunuo_guilds ON myrunuo_characters.char_guild = myrunuo_guilds.guild_id 
RIGHT JOIN myrunuo_status ON myrunuo_characters.char_id=myrunuo_status.char_id
$where ORDER by $sortby $sw LIMIT $tp,$players_perpage");
$num = mysqli_num_rows($result);

		echo <<<EOF
				  <table width="1000">
    <tr>
	  <th><h1 class="gold">$shard_name Citizens Online Now</h1></th>
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
					  <th class="gold" width="224"><a href="index.php?sortby=name&flip=$nflip">Name</a></th>
					  <th class="gold" width="220"><a href="index.php?sortby=gtitle&flip=$gtflip">Guild Title</a></th>
					  <th class="gold" width="220"><a href="index.php?sortby=gname&flip=$gnflip">Guild Name</th>
					  <th class="gold" style="text-align:center" width="70"><a href="index.php?sortby=gabbr&flip=$gaflip">Abbr.</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="index.php?sortby=kills&flip=$cflip">Kills</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="index.php?sortby=karma&flip=$kflip">Karma</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="index.php?sortby=fame&flip=$fflip">Fame</a></th>										  
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

// Last Update
$result = sql_query($link, "SELECT timestamp FROM   myrunuo_updates ORDER  BY timestamp DESC LIMIT  1");
if (!(list($timestamp) = mysqli_fetch_row($result)))
  $timestamp = "";
mysqli_free_result($result);

mysqli_close($link);

if ($timestamp != ""){
	$dt = date("F j, Y, g:i a", strtotime($timestamp));
}

else
  $dt = date("F j, Y, g:i a");

echo <<<EOF
  <tr>
    <td class="grey" style="text-align:center;font-size:75%;font-style: italic;" colspan="4">
      <small>Last Updated&nbsp;:&nbsp;$dt</small>
    </td>
  </tr>

</table>

</body> 
</html>

EOF;
include('footer.php');
?>
