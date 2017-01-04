<?php
/*
Copyright 2016-2017 Tom Sampson aka. Ixtabay 

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES 
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR 
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

Check the forums on www.ServUO.com for more information about ServUO and MyRunUO

*/
// Error Reporting
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

// Path
$base_ref="localhost"; // This is the root URL where your MyRunUO resides, minus the http://

// Shard Info - This will appear on your logo and also in the Razor setup image.
$shard_name="My Shard";
$shard_addr="localhost"; // Your server name (ie. servuo.myhost.com)
$shard_port="2593"; // your server port

// Edit your database settings:
$SQLhost = "localhost";
$SQLport = "3306";
$SQLuser = "root";
$SQLpass = "";
$SQLdb   = "myrunuo";
$mulpath = "MUL_FILES/"; // Edit path of .mul files: gumpart.mul gumpidx.mul hues.mul tiledata.mul
$validhosts = ""; // Leave blank to allow any host to use your paperdoll generator.

// Edit to control number of lines of data per page:
$status_perpage = 12;
$players_perpage = 12;
$guilds_perpage = 12;

// Links 
$url_home="index.php";
$url_players="players.php";
$url_guilds="guilds.php";
$url_forums="https://www.servuo.com/threads/myrunuo-for-servuo.6016/#post-39510";
$url_discord="https://discordapp.com/invite/0cQjvnFUN26nRt7y";
$url_about="about.php";

$url_download_client="http://web.cdn.eamythic.com/us/uo/installers/20120309/UOClassicSetup_7_0_24_0.exe";
$url_download_razor="http://www.uorazor.com/downloads/Razor_Latest.exe";

// Default Language English - change below to suit your needs
// Header
$header_description="MyRunUO";
$header_keywords="MyRunUO is a great way to display information and statistics about guild and player characters from your shard!";
$header_content="MyRunUO, Ultima Online, MMORPG";

//Top Menu Images
$image_path="images/";
$img_home="menu_Home.png";
$img_players="menu_Players.png";
$img_guilds="menu_Guilds.png";
$img_forums="menu_Forums.png";
$img_discord="menu_Discord.png";
$img_about="menu_About.png";

//Content
$razor_load_screen="images/razor_load_screen.png";
$img_logo="images/Header_Logo.png";

$text_server_status="Server Status";
$text_players_online="Players Online";
$img_download_client="download_client.png";
$text_banner="MyRunUO is a web-based application that allows shard owners to display player characters, 
guilds, and other information players will enjoy seeing when they are not in game.  
MyRunUO was created for educational purposes and offers a simple web solution for novice administrators that adds additional emersion and out-of-game content to their communities.  
Setup is easy, just edit the config.php file, load the included sql file into your MySQL server, and replace the old MyRunUO files in /scripts/services/MyRunUO.   
MyRunUO allows players and guilds to show off their achievements, and could help help attract and retain players.  
Some images on this website are &copy;Copyright EA Games and UO Razor.";
$text_step_one="Step 1)";
$text_step_two="Step 2)";
$text_step_three="Step 3)";
$text_step_four="Step 4)";
$text_download_client="Download and Install the UO Client";
$text_download_razor="Download, Install, and Launch UO Razor ";
$text_enter_server_info="Enter server:".$shard_addr." and port:".$shard_port;
$text_create_account="Enter the login name and password of your choice and enter the game!";
$more_text="READ MORE!";
$text_here="HERE!";


// No need to edit anything below this line
// --------------------------------------------------------------------------------------------------------------- sql_connect
function sql_connect()
{
  global $SQLhost, $SQLport, $SQLdb, $SQLuser, $SQLpass;

  if ($SQLport != "")
    $link = @mysqli_connect("$SQLhost","$SQLuser","$SQLpass","$SQLdb","$SQLport");
  else
    $link = @mysqli_connect("$SQLhost","$SQLuser","$SQLpass","$SQLdb","$SQLport");
  if (!$link) {
    echo "Database access error ".mysql_errno().": ".mysql_error()."\n";
    die();
  }
  
  $result = mysqli_select_db($link, $SQLdb);
  if (!$result) {
    echo "Error ".mysql_errno($link)." selecting database '$SQLdb': ".mysql_error($link)."\n";
    die();
  }
  return $link;
}
// --------------------------------------------------------------------------------------------------------------- sql_query
function sql_query($link, $query)
{
  global $SQLhost, $SQLport, $SQLdb, $SQLuser, $SQLpass;

  $result = mysqli_query($link, $query);
  if (!$result) {
    echo "Error ".mysqli_errno($link).": ".mysqli_error($link)."\n";
    die();
  }
  return $result;
}
// --------------------------------------------------------------------------------------------------------------- check_get
function check_get(&$store, $val)
{
  $magic = get_magic_quotes_gpc();
  if (isset($_POST["$val"])) {
    if ($magic)
      $store = stripslashes($_POST["$val"]);
    else
      $store = $_POST["$val"];
  }
  else if (isset($_GET["$val"])) {
    if ($magic)
      $store = stripslashes($_GET["$val"]);
    else
      $store = $_GET["$val"];
  }
}


?>