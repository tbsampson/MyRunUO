<?php

require("header.php");

check_get($tp, "tp");
$tp = intval($tp);

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
  default: // name
    $sortby = "char_name";
}

$nflip = $cflip = $kflip = $fflip = 0;
if (!$flip) {
  if ($sortby == "char_name")
    $nflip = 1;
  else if ($sortby == "char_counts")
    $cflip = 1;
  else if ($sortby == "char_karma")
    $kflip = 1;
  else if ($sortby == "char_fame")
    $fflip = 1;
}

$link = sql_connect();

// Get players online
$result = sql_query($link, "SELECT IFNULL(COUNT(char_id),0) AS players_online FROM myrunuo_status");
if (!(list($totalplayers) = mysqli_fetch_row($result)))
  $totalplayers = 0;
mysqli_free_result($result);

// Get status and total online players (non-staff)
$result = sql_query($link, "SELECT myrunuo_status.char_id,myrunuo_characters.char_karma,myrunuo_characters.char_fame,myrunuo_characters.char_name,myrunuo_characters.char_nototitle,myrunuo_characters.char_counts,myrunuo_characters.char_public
                    FROM myrunuo_status
                    LEFT JOIN myrunuo_characters ON myrunuo_characters.char_id=myrunuo_status.char_id
                    WHERE char_name<>''
                    ORDER BY $sortby $sw LIMIT $tp,$status_perpage");

echo <<<EOF
<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" valign="middle"> 
    <th><a href="players.php"><b>View Players</b></a></th>
    <th><a href="searchplayers.php"><b>Search Players</b></a></th>
    <th><a href="guilds.php"><b>View Guilds</b></a></th>
  </tr>
</table>

<h1>Server Status</h1>

Online players: $totalplayers<br>
<table width="640">
  <tr>
     <th width="150"><a href="status.php?sortby=Name&flip=$nflip" style="color: white">Name</a></th>
     <th><font color="white">Title</th>
     <th align="center" width="50"><a href="status.php?sortby=Kills&flip=$cflip" style="color: white">Kills</a></th>
     <th align="center" width="50"><a href="status.php?sortby=Karma&flip=$kflip" style="color: white">Karma</a></th>
     <th align="center" width="50"><a href="status.php?sortby=Fame&flip=$fflip" style="color: white">Fame</a></th>
  </tr>
  <tr>
    <td colspan="5">

EOF;

if ($tp - $status_perpage >= 0) {
  $num = $tp - $status_perpage;
  echo "        <a href=\"status.php?tp=$num&sortby=$s\"><img src=\"images/items/back.jpg\" border=\"0\"></a>\n";
}
else
  echo "        &nbsp; &nbsp;";

$page = intval($tp / $status_perpage) + 1;
$pages = ceil($totalplayers / $status_perpage);
if ($pages > 1)
  echo "Page [$page/$pages]";

if ($tp + $status_perpage < $totalplayers) {
  $num = $tp + $status_perpage;
  echo "<a href=\"status.php?tp=$num&sortby=$s\"><img src=\"images/items/next.jpg\" border=\"0\"></a>\n";
}

echo <<<EOF
    </td>
  </tr>

EOF;


$result = sql_query($link, "SELECT myrunuo_characters.char_id, myrunuo_characters.char_name, myrunuo_characters.char_title, myrunuo_characters.char_counts, myrunuo_characters.char_karma, myrunuo_characters.char_fame
							FROM myrunuo_characters
							JOIN  myrunuo_status ON myrunuo_status.char_id = myrunuo_characters.char_id");

$num = 0;
if ($totalplayers && mysqli_num_rows($result)) {
  while ($row = mysqli_fetch_row($result)) {
    $id = $row[0];
    $charname = $row[1];
	$title = $row[2];
    $kills = $row[3];
    $karma = $row[4];
    $fame = $row[5];


    if ($charname != "") {
      echo <<<EOF
  <tr>
    <td><a href="player.php?id=$id">$charname</a></td>
    <td>$title</td>
    <td align="right">$kills</td>
    <td align="right">$karma</td>
    <td align="right">$fame</td>
  </tr>

EOF;
      $num++;
    }
  }
}

if (!$num) {
  echo <<<EOF
  <tr>
    <td colspan="5">
      There are no players online.
    </td>
  </tr>

EOF;
}

// Last Update
$result = sql_query($link, "SELECT timestamp FROM   myrunuo_updates ORDER  BY timestamp DESC LIMIT  1");
if (!(list($timestamp) = mysqli_fetch_row($result)))
  $timestamp = "";
mysqli_free_result($result);

mysqli_close($link);

if ($timestamp != "")
  $dt = date("F j, Y, g:i a", strtotime($timestamp));
else
  $dt = date("F j, Y, g:i a");

echo <<<EOF
  <tr>
    <td class="gold" style="text-align:center;font-size:80%;font-style: italic;" colspan="5">
      <small>Last Updated&nbsp;:&nbsp;$dt</small>
    </td>
  </tr>
</table>

</body>
</html>

EOF;

?>