<?php
// Gump reader for paperdoll
require("config.php");
// Get id from URL
check_get($id, "id");
$id = intval($id);
if (!$id)
  die();
// Don't allow just anyone to load this
if (!empty($validhosts)) {
  if (isset($_SERVER["HTTP_REFERER"]))
    $ref = strtolower($_SERVER["HTTP_REFERER"]);
  else
	$ref = "";   
	$validhosts = strtolower($validhosts);
	$vhosts = explode(" ", $validhosts);
	$host = 0;
	$valid = false;
  while (isset($vhosts[$host]) && !$valid) {
  	if (substr($ref, 0, strlen($vhosts[$host])) == $vhosts[$host])
  	  $valid = true;
  	$host++;
  }
  if (!$valid)
    die();
}
// Query the database for character info
$link = sql_connect();
$result = sql_query($link, "SELECT char_nototitle,char_race,char_body,char_female,char_bodyhue,char_karma , char_fame, char_counts, (case when myrunuo_characters.char_guildtitle <> 'NULL' then myrunuo_characters.char_guildtitle else '' end) AS char_guildtitle ,COALESCE(IFNULL(myrunuo_guilds.guild_name, ''), 'no name') AS guild_name
							FROM myrunuo_characters LEFT OUTER JOIN myrunuo_guilds ON myrunuo_characters.char_guild = myrunuo_guilds.guild_id
							WHERE myrunuo_characters.char_id = $id");
if (!(list($nametitle,$charRace,$charBodyType,$charfemale,$charbodyhue,$charKarma,$charFame,$charCounts,$charGuildTitle,$charGuildName) = mysqli_fetch_row($result)))
  die();
mysqli_free_result($result);

if ($charKarma < 0 && $charCounts >=5)
	$ispker = TRUE; // red for pkers
else
	$ispker = FALSE; // cyan for good players

// Insert body into variables
$indexA = $charBodyType;
$femaleA = $charfemale;
// Convert body type -  Doing this because at the time I created, I did not know how to read the new UOL files, and need to convert for pre-7.0.9x MUL files
if ($indexA == 400) 
	$indexA = 12;	// Human Male
if ($indexA == 401)
	$indexA = 13;	// Human Female
if ($indexA == 605)
	$indexA = 14;   // Elf Male
if ($indexA == 606)
	$indexA = 15;   // Elf Female
if ($indexA == 667)
	$indexA = 665;	// Garg Female
// Garg Male is ok (666)

$hueA = $charbodyhue;
$isgumpA = "1";
// Query database for items player is wearing
$result = mysqli_query($link, "SELECT item_id,item_hue,layer_id FROM myrunuo_characters_layers WHERE char_id=$id ORDER BY layer_id");
$items = array(array());
$num = $dosort = 0;
while ($row = mysqli_fetch_row($result)) {
  $items[0][$num] = $row[0];
  $items[1][$num] = $row[1];
  if ($row[2] == 13) {
    $items[2][$num++] = 3.5; // Fix for tunic
    $dosort = 1;
  }
  else
	  $items[2][$num++] = $row[2];
}
mysqli_free_result($result);
mysqli_close($link);

if ($dosort)
  array_multisort($items[2], SORT_ASC, SORT_NUMERIC, $items[0], SORT_ASC, SORT_NUMERIC, $items[1], SORT_ASC, SORT_NUMERIC);

for ($i = 0; $i < $num; $i++) {
  // Insert items into variables
  $indexA .= ",".$items[0][$i];
  $hueA .= ",".$items[1][$i];
  if ($charfemale)
    $femaleA .= ",1";
  else
    $femaleA .= ",0";
  $isgumpA .= ",0";
}

// Paperdoll Graphic Area
$width = 320;
$height = 505;

if (strpos($indexA, ",")) {
  $indexA = explode(",", $indexA);
  $femaleA = explode(",", $femaleA);
  $hueA = explode(",", $hueA);
  $isgumpA = explode(",", $isgumpA);
}
else {
  $indexA = array($indexA);
  $femaleA = array($femaleA);
  $hueA = array($hueA);
  $isgumpA = array($isgumpA);
}

$hues = FALSE;
$tiledata = FALSE;
$gumpfile = FALSE;
$gumpindex = FALSE;

$hues = fopen("{$mulpath}hues.mul", "rb");
if ($hues == FALSE)
{
  die("Unable to open hues.mul - ERROR\nDATAEND!");
  exit;
}

$tiledata = fopen("{$mulpath}tiledata.mul", "rb");
if ($tiledata == FALSE)
{
  fclose($hues);
  die("Unable to open tiledata.mul - ERROR\nDATAEND!");
  exit;
}

$gumpfile = fopen("{$mulpath}gumpart.mul", "rb");
if ($gumpfile == FALSE)
{
  fclose($hues);
  fclose($tiledata);
  die("Unable to open gumpart.mul - ERROR\nDATAEND!");
  exit;
}

$gumpindex = fopen("{$mulpath}gumpidx.mul", "rb");
if ($gumpindex == FALSE)
{
  fclose($hues);
  fclose($tiledata);
  fclose($gumpfile);
  die("Unable to open gumpidx.mul - ERROR\nDATAEND!");
  exit;
}

InitializeGump($gumprawdata, $width, $height);
for ($i = 0; $i < sizeof($indexA); $i++)
{
  $index = intval($indexA[$i]);
  $female = intval($femaleA[$i]);
  $hue = intval($hueA[$i]);
  $isgump = intval($isgumpA[$i]);

  if ($female >= 1)
    $female = 1;
  else
    $female = 0;

  if ($hue < 1 || $hue > 65535)
    $hue = 0;

  if($isgump > 0 || $index == $indexA)
    $isgump = 1;
  else
    $isgump = 0;

 if ($index > 0x9FFF || $index <= 0 || $hue > 65535 || $hue < 0) //  
    continue;

  if ($isgump == 1) // Male/Female Gumps or IsGump Param
    $gumpid = $index;
  else {
    $group = intval($index / 32);
    $groupidx = $index % 32;
    fseek($tiledata, 512 * 836 + 1188 * $group + 4 + $groupidx * 37, SEEK_SET); // 512 * 836
    if (feof($tiledata))
		continue;

  
    // Read the flags -------------------------------------------------------------------------------------------------
    $flags = read_big_to_little_endian($tiledata, 4); /// set to 4 for old files, 8 for new files, but as of now 8 does not work properly!
	
    if ($flags == -1)
      continue;

    if ($flags & 0x404002) { // Change this from  0x404002 to 0x00400000 if you are pre v6.x MUL files

 	fseek($tiledata, 6, SEEK_CUR);
      $gumpid = read_big_to_little_endian($tiledata, 2);
      $gumpid = ($gumpid & 0xFFFF);
      if ($gumpid > 65535 || $gumpid <= 0)
      continue; // Invalid gump ID

	   if ($gumpid < 10000) { // For GumpID less than 10k, adjust for male/female versions
        if ($female == 1) 
			if ($gumpid < 940) $gumpid += 60000; // Some elf items have only one version
			 else $gumpid += 50000;
          // $gumpid += 60000; // Show female version of wearable
        else
         $gumpid += 50000; // Otherwise show male version
      } 
    }

    else
  continue; // Not wearable



  }
  LoadRawGump($gumpindex, $gumpfile, intval($gumpid), $hue, $hues, $gumprawdata);
}

// Separate name and skill title
$nametitle = striphtmlchars($nametitle);
if (($i = strpos($nametitle, ",")) !== FALSE) {
	$name = substr($nametitle, 0, $i);
  $title = substr($nametitle, $i + 2);
}
else {
	$name = $nametitle;
	$title = "";
}

AddText($gumprawdata, $name, $charGuildTitle, $charGuildName, $ispker);
CreateGump($gumprawdata);
fclose($hues);
fclose($tiledata);
fclose($gumpfile);
fclose($gumpindex);
exit;

function LoadRawGump($gumpindex, $gumpfile, $index, $hue, $hues, &$gumprawdata)
{
  $send_data = '';
  $color32 = array();

  fseek($gumpindex, $index * 12, SEEK_SET);
  if (feof($gumpindex))
    return; // Invalid gumpid, reached end of gumpindex.

  $lookup = read_big_to_little_endian($gumpindex, 4);
  if ($lookup == -1) {
    if ($index >= 60000)
      $index -= 10000;
    fseek($gumpindex, $index * 12, SEEK_SET);
    if (feof($gumpindex)) // Invalid gumpid, reached end of gumpindex.
      return;
    $lookup = read_big_to_little_endian($gumpindex, 4);
    if ($lookup == -1)
      return; // Gumpindex returned invalid lookup.
  }
  $gsize = read_big_to_little_endian($gumpindex, 4);
  $gextra = read_big_to_little_endian($gumpindex, 4);
  fseek($gumpindex, $index * 12, SEEK_SET);
  $gwidth = (($gextra >> 16) & 0xFFFF);
  $gheight = ($gextra & 0xFFFF);
  $send_data .= sprintf("Lookup: %d\n", $lookup);
  $send_data .= sprintf("Size: %d\n", $gsize);
  $send_data .= sprintf("Height: %d\n", $gheight);
  $send_data .= sprintf("Width: %d\n", $gwidth);

  if ($gheight <= 0 || $gwidth <= 0)
    return; // Gump width or height was less than 0.

  fseek($gumpfile, $lookup, SEEK_SET);
  $heightTable = read_big_to_little_endian($gumpfile, ($gheight * 4));
  if (feof($gumpfile))
    return; // Invalid gumpid, reached end of gumpfile.

  $send_data .= sprintf("DATASTART:\n");
  if ($hue <= 0) {
    for ($y = 1; $y < $gheight; $y++) {
      fseek($gumpfile, $heightTable[$y] * 4 + $lookup, SEEK_SET);

      // Start of row
      $x = 0;
      while ($x < $gwidth) {
        $rle = read_big_to_little_endian($gumpfile, 4);  // Read the RLE data
        $length = ($rle >> 16) & 0xFFFF;  // First two bytes - how many pixels does this color cover
        $color = $rle & 0xFFFF;  // Second two bytes - what color do we apply

        // Begin RGB value decoding
        $r = (($color >> 10)*8);
        $g = (($color >> 5) & 0x1F)*8;
        $b = ($color & 0x1F)*8;
        if ($r > 0 || $g > 0 || $b > 0)
          $send_data .= sprintf("%d:%d:%d:%d:%d:%d***", $x, $y, $r, $g, $b, $length);
        $x = $x + $length;
      }
    }
  }
  else { // We are using the hues.mul
    $hue = $hue - 1;
    $orighue = $hue;
    if ($hue > 0x8000)
      $hue = $hue - 0x8000;
    if ($hue > 3001) // Bad hue will cause a crash
      $hue = 1;
    $colors = intval($hue / 8) * 4;
    $colors = 4 + $hue * 88 + $colors;
    fseek($hues, $colors, SEEK_SET);
    for ($i = 0; $i < 32; $i++) {
      $color32[$i] = read_big_to_little_endian($hues, 2);
      $color32[$i] |= 0x8000;
    }
    for ($y = 1; $y < $gheight; $y++) {
      fseek($gumpfile, $heightTable[$y] * 4 + $lookup, SEEK_SET);

      // Start of row
      $x = 0;
      while ($x < $gwidth) {
        $rle = read_big_to_little_endian($gumpfile, 4);  // Read the RLE data
        $length = ($rle >> 16) & 0xFFFF;  // First two bytes - how many pixels does this color cover
        $color = $rle & 0xFFFF;  // Second two bytes - what color do we apply

        // Begin RGB value decoding
        $r = (($color >> 10));
        $g = (($color >> 5) & 0x1F);
        $b = ($color & 0x1F);

        // Check if we're applying a special hue (skin hues), if so, apply only to grays
        if (($orighue > 0x8000) && ($r == $g && $r == $b)) {
          $newr = (($color32[$r] >> 10))*8;
          $newg = (($color32[$r] >> 5) & 0x1F)*8;
          $newb = ($color32[$r] & 0x1F)*8;
        }
        else if ($orighue > 0x8000) {
          $newr = $r * 8;
          $newg = $g * 8;
          $newb = $b * 8;
        }
        else {
          $newr = (($color32[$r] >> 10))*8;
          $newg = (($color32[$r] >> 5) & 0x1F)*8;
          $newb = ($color32[$r] & 0x1F)*8;
        }
        if((($r * 8) > 0) || (($g * 8) > 0) || (($b * 8) > 0))
          $send_data .= sprintf("%d:%d:%d:%d:%d:%d***", $x , $y, $newr, $newg, $newb, $length);
        $x += $length;
      }
    }
  }
  $send_data .= sprintf("DATAEND!");
  add_gump($send_data, $gumprawdata);
}
// ---------------------------------------------------------------------------------------------------------------------------------------- read_big_to_little_endian
function read_big_to_little_endian($file, $length)
{
  if (($val = fread($file, $length)) == FALSE)
    return -1;

  switch($length)
  {
    case 8: $val = unpack('V2', $val); break;
	case 4: $val = unpack('l', $val); break;
    case 2: $val = unpack('s', $val); break;
    case 1: $val = unpack('c', $val); break;
    default: $val = unpack('l*', $val); return $val;
  }
  return ($val[1]);
}

function add_gump($read, &$img)
{
  if (strpos($read, "ERROR"))
    return;

  $data = explode("DATASTART:\n", $read);
  $data = $data[1];
  $newdata = explode("***", $data);
  while (list($key, $val) = @each($newdata)) {
    if ($val == "DATAEND!")
      break;
    $val = explode(":", $val);
    $x = intval($val[0]) + 65;
    $y = intval($val[1]) + 65;
    $r = intval($val[2]);
    $g = intval($val[3]);
    $b = intval($val[4]);
    $length = intval($val[5]); // pixel color repeat length
    if ($r || $g || $b) {
      $col = imagecolorallocate($img, $r, $g, $b);
      for ($i = 0; $i < $length; $i++)
        imagesetpixel($img, $x+$i, $y, $col);
    }
  }
}

function InitializeGump(&$img, $width, $height)
{
  $img = imagecreatefrompng("images/char_stand.png") or die("couldnt create image");
  imagealphablending( $img, true ); 
  imagesavealpha( $img, true );  // Keep transparent background
  // imagecolorallocatealpha($img,0,0,8,127);
}

function AddText(&$img, $nametitle, $charGuildTitle, $charGuildName, $ispker) // Write player's name and title under the paperdoll
{
// Get rid of any NULLs
$charGuildTitle = trim($charGuildTitle);
$charGuildName = trim($charGuildName);

	$pos_vert = 415;
	$shadow_offset = 2;
	$white = imagecolorallocate($img, 255, 255, 255);
	$cyan = imagecolorallocate($img, 49, 214, 231); // For good players
	$red =  imagecolorallocate($img, 189, 0, 0); // For players killers
	$black = imagecolorallocate($img, 0, 0, 0);
	$green = imagecolorallocate($img, 132, 231, 49); // For guild names and titles
	$font = './fonts/Oswald-Regular.ttf'; // JimNightshade-Regular
	$fontsize = 14;
	$fontangle = 0;

	if ($ispker == TRUE)
		$namecolor = $red;
	else
		$namecolor = $cyan;		
	
// ------------------------------------------------- Write Character Name & Title 	
	$pos_horiz = (int) (160 - (strlen(striphtmlchars($nametitle)) * 4)); // center the name (striphtmlchars is to ensure correct character count)
		if ($pos_horiz < 0)
			$pos_horiz = 0;
// write the shadow first
imagettftext($img, $fontsize, $fontangle, $pos_horiz+$shadow_offset, $pos_vert-$shadow_offset, $black, $font, $nametitle);
// then write the text on top of it
imagettftext($img, $fontsize, $fontangle, $pos_horiz, $pos_vert, $namecolor, $font, $nametitle);
// ------------------------------------------------- Write Guild Title (if any)			
	$pos_horiz = (int) (160 - (strlen(striphtmlchars($charGuildTitle)) * 4)); // center the guild title
		if ($pos_horiz < 0)
			$pos_horiz = 0;	
			$pos_vert = $pos_vert + 25; // How many pixels below name to place guild title
		
			
// write the shadow first
imagettftext($img, $fontsize, $fontangle, $pos_horiz+$shadow_offset, $pos_vert-$shadow_offset, $black, $font, $charGuildTitle);
// then write the text on top of it
imagettftext($img, $fontsize, $fontangle, $pos_horiz, $pos_vert, $green, $font, $charGuildTitle);
// ------------------------------------------------- Write Guild Name (if any)			
	$pos_horiz = (int) (160 - (strlen(striphtmlchars($charGuildName)) * 4)); // center the guild name
		if ($pos_horiz < 0)
			$pos_horiz = 0;	
			$pos_vert = $pos_vert + 25; // How many pixels below name to place guild title
// write the shadow first
imagettftext($img, $fontsize, $fontangle, $pos_horiz+$shadow_offset, $pos_vert-$shadow_offset, $black, $font, $charGuildName);
// then write the text on top of it
imagettftext($img, $fontsize, $fontangle, $pos_horiz, $pos_vert, $green, $font, $charGuildName);

}

function CreateGump(&$img)
{
  Header("Content-type: image/png");
  imagepng($img);
  imagedestroy($img);
}

function striphtmlchars($str)
{
  $nstr = str_replace("&amp;", "&", $str);
  $nstr = str_replace("&#39;", "'", $nstr);
  return $nstr;
}

?>