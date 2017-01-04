<?php
include('header.php');
// Guild page / war page to display
check_get($gp, "gp");
$gp = intval($gp);
check_get($wp, "wp");
$wp = intval($wp);

check_get($fn, "fn");
if ($fn != "")
  $where = "WHERE myrunuo_guilds.guild_name LIKE '" . addslashes($fn) . "%' OR myrunuo_guilds.guild_abbreviation LIKE '" . addslashes($fn) . "%'";
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
  case "type":
    $sortby = "type";
    break;
  case "abbr":
    $sortby = "abbr";
    break;
  case "members":
    $sortby = "members";
    break;
  case "kills":
    $sortby = "kills";
    break;
  case "wars":
    $sortby = "wars";
    break;
  default: // name
    $sortby = "name";
}

$tflip = $aflip = $mflip = $kflip = $wflip = $nflip = 0;
if (!$flip) {
  if ($sortby == "name")
    $nflip = 1;
  else if ($sortby == "type")
    $tflip = 1;
  else if ($sortby == "abbr")
    $aflip = 1;
  else if ($sortby == "members")
    $mflip = 1;
  else if ($sortby == "kills")
    $kflip = 1;
  else if ($sortby == "wars")
    $wflip = 1;
}
// ----------------------------------------------------------------------------------------------------------------------------


check_get($sortby, "sortby");
if ($sortby == "" || $sortby == "myrunuo_guilds.guild_name")
  $sort1 = "myrunuo_guilds.guild_name";
else
  $sort1 = $sortby." DESC";

check_get($sortby1, "sortby1");
if ($sortby1 == "" || $sortby1 == "myrunuo_guilds.guild_name")
  $sort2 = "myrunuo_guilds.guild_name";
else
  $sort2 = $sortby1." DESC";

$link = sql_connect();

// Total guilds count
$result = sql_query($link, "SELECT COUNT(*) FROM myrunuo_guilds");
list($totalguilds) = mysqli_fetch_row($result);
$totalguilds = intval($totalguilds);
mysqli_free_result($result);

// Last Update
$result = sql_query($link, "SELECT timestamp FROM   myrunuo_updates ORDER  BY timestamp DESC LIMIT  1");
if (!(list($timestamp) = mysqli_fetch_row($result)))
  $timestamp = "";
mysqli_free_result($result);

echo <<<EOF
<table width="1000">
    <tr>
	  <th width="350"><h1 class="gold">Guilds of $shard_name</h1></th>
	  <th colspan="5" style="text-align:right; vertical-align:middle; margin-bottom:0;">
			<form action="guilds.php" method="get" style="margin-bottom:0; margin-right:4;">		    
				<input type="search" placeholder="Search for a guild" name="fn">		    	
				<button>Search</button>
			</form>
	  </th>
	</tr>
    <tr style="background-image: url(images/bg_dark_slate.png);">
      <td colspan="6" align="center">
        <table width="994" class="rolodex">
		  <tr class="gold">
			<td class="rolodex" width=30><a href="guilds.php">ALL</a></td><td class="rolodex" width=30><a href="guilds.php?fn=A">A</a></td>
			<td class="rolodex" width=30><a href="guilds.php?fn=B">B</a></td><td class="rolodex" width=30><a href="guilds.php?fn=C">C</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=D">D</a></td><td class="rolodex" width=30><a href="guilds.php?fn=E">E</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=F">F</a></td><td class="rolodex" width=30><a href="guilds.php?fn=G">G</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=H">H</a></td><td class="rolodex" width=30 width=30><a href="guilds.php?fn=I">I</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=J">J</a></td><td class="rolodex" width=30><a href="guilds.php?fn=K">K</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=L">L</a></td><td class="rolodex" width=30><a href="guilds.php?fn=M">M</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=N">N</a></td><td class="rolodex" width=30><a href="guilds.php?fn=O">O</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=P">P</a></td><td class="rolodex" width=30><a href="guilds.php?fn=Q">Q</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=R">R</a></td><td class="rolodex" width=30><a href="guilds.php?fn=S">S</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=T">T</a></td><td class="rolodex" width=30><a href="guilds.php?fn=U">U</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=V">V</a></td><td class="rolodex" width=30><a href="guilds.php?fn=W">W</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=X">X</a></td><td class="rolodex" width=30><a href="guilds.php?fn=Y">Y</a></td> 
			<td class="rolodex" width=30><a href="guilds.php?fn=Z">Z</a></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td width="855" class="grey">
        <p class="grey" style="text-align:left; font-size:90%; font-style:italic;">Total Guilds Found:&nbsp;$totalguilds</p>
	  </td>
	  <td style="width:300px;" class="grey"></td>
	  <td style="width:300px;" class="grey"></td>	  
      <td width="40">

EOF;
if ($gp - $guilds_perpage >= 0) {
  $num = $gp - $guilds_perpage;
echo <<<EOF
	<a href="guilds.php?gp=$num&wp=$wp&sortby=$sortby&sortby1=$sortby1&fn=$fn&sortby=$s&flip=$flip"><img src="images/buttons/arrow_left.png" border="0"></a>
EOF;
}

echo <<<EOF
	</td><td width="65">
EOF;

$page = intval($gp / $guilds_perpage) + 1;
$pages = ceil($totalguilds / $guilds_perpage);
if ($pages > 1) {
echo <<<EOF
	<p class="grey" style="text-align:center;font-size:80%;font-style: italic;">Page&nbsp;$page/$pages</p>
EOF;
}

echo <<<EOF
	</td><td width="40">
EOF;

// Guilds / members
$result = sql_query($link, "SELECT guild_type AS type,guild_id AS id,guild_name AS name,guild_abbreviation AS abbr,COUNT(char_guild) AS members,SUM(char_counts) AS kills, guild_wars AS wars
                    FROM myrunuo_guilds INNER JOIN myrunuo_characters ON guild_id=char_guild
                     $where GROUP BY guild_name ORDER by  $sortby $sw LIMIT $gp,$guilds_perpage");
$num = mysqli_num_rows($result);					 

if ($gp + $guilds_perpage < $totalguilds) {
  $num = $gp + $guilds_perpage;
  
echo <<<EOF
	<a href="guilds.php?gp=$num&wp=$wp&sortby=$sortby&sortby1=$sortby1&fn=$fn&sortby=$s&flip=$flip"><img src="images/buttons/arrow_right.png" border="0"></a>
EOF;
}

echo <<<EOF

	</td>
 </tr>
 <tr>
  <td colspan="6">
    <table width="994">

EOF;
$headerloaded=false;
if ($num) {
  while ($row = mysqli_fetch_row($result)) {

if ($headerloaded == false)
	{
		echo <<<EOF
				  <tr>
					  <th class="gold" width="290"><a href="guilds.php?sortby=name&flip=$nflip">Guild Name</a></th>
					  <th class="gold" width="74" style="text-align:center"><a href="guilds.php?sortby=abbr&flip=$aflip">Abbr</a></th>
					  <th class="gold" width="30"><a href="guilds.php?sortby=type&flip=$tflip">Type</a></th>
					  <th class="gold" width="70" style="text-align:center"><a href="guilds.php?sortby=members&flip=$mflip">Members</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="guilds.php?sortby=kills&flip=$kflip">Kills</a></th>
					  <th class="gold" style="text-align:center" width="70"><a href="guilds.php?sortby=wars&flip=$wflip">Wars</a></th>
				  </tr>
EOF;
	}
	$headerloaded = true;
    $type = $row[0];
	$id = $row[1];
    $name = $row[2];
    $abbr = $row[3];
    $members = $row[4];	
    $kills = $row[5];
    $wars = $row[6];	
    $type_icon = "";
	
//	if ($kills == 0) $kills = "";
//	if ($wars == 0) $wars = "";

	if ($type == "Standard"){
			$type_icon = "images/shields/wooden.png";
	}			
	else if ($type == "Order"){
			$type_icon = "images/shields/order.png";
	}
	else if ($type == "Chaos"){
			$type_icon = "images/shields/chaos.png";
	}	
echo <<<EOF
		  <tr>
            <td class="green"><a href="guild.php?id=$id">$name</a></td>				
            <td class="green" style="text-align:center"><a href="guild.php?id=$id">$abbr</a></td>				
		    <td><img src="$type_icon" height="30" width="30" alt="$type Guild" title="$type Guild"></td>
            <td class="cyan" style="text-align:center">$members</td>				
            <td class="red" style="text-align:center">$kills</td>
            <td class="red" style="text-align:center">$wars</td>			
	      </tr>
EOF;
  }
}
else {
   echo <<<EOF
          <tr>
            <td class="no-results" colspan="8">Your search found no guilds</td>
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