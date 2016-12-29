<?php
require_once('config.php');



function LoadRAZORsetup($imgname,$shard,$port)
{
	$args = func_get_args();
    /* Get base image, shard address, and port */
	$imgname = $args[0];
	$shard = $args[1];
	$port = $args[2];
	/* Attempt to open */
    $im = @imagecreatefrompng($imgname);

    /* Set text color to black*/
    $tc  = imagecolorallocate($im, 0, 0, 0);	
	
    /* Did image load? */
    if(!$im)
    {
        /* Create a blank image the same size as razor_load_screen */
        $im  = imagecreatetruecolor(356, 284);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        imagefilledrectangle($im, 0, 0, 356, 284, $bgc);

        /* Output an error message */
        imagestring($im, 5, 5, 5, 'Error loading image...', $tc);
		imagestring($im, 5, 5, 30, $imgname, $tc);
    }
	else
	{
		/* Everything looks good, write in the shard_addr and shard_port */
		$font_path = 'fonts/Calibri.ttf';
		imagettftext($im, 12, 0, 62, 201, $tc, $font_path, $shard);
		imagettftext($im, 12, 0, 305, 201, $tc, $font_path, $port);		
	}
	return $im;
}
header('Content-Type: image/png');
$img = LoadRAZORsetup($razor_load_screen,$shard_addr,$shard_port); //$razor_load_screen

imagepng($img);
imagedestroy($img);
?>