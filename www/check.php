<?php


// Paperdoll Graphic Area
$mulpath = "OLD_FILES/";
$width = 182;
$height = 237;
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



?>