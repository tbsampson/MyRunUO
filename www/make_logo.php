<?php
require_once('config.php');



function LoadRAZORsetup($logo,$shard,$port,$name)
{
	$args = func_get_args();
    /* Get base image, shard address, and port */
	$logo = $args[0];
	$shard = $args[1];
	$port = $args[2];
	$name = $args[3];
	/* Attempt to open */
    $im = @imagecreatefrompng($logo);
	imagealphablending( $im, true );  // Alpha Blending True
	imagesavealpha( $im, true );  // Keep transparent background
	
    /* Set text color */
    $tc  = imagecolorallocate($im, 231, 207, 74);	

    /* Set shadow color */
    $sc  = imagecolorallocate($im, 0, 0, 0);	
	
    /* Did image load? */
    if(!$im)
    {
        /* Create a blank image the same size as razor_load_screen */
        $im  = imagecreatetruecolor(100, 1020);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        imagefilledrectangle($im, 0, 0, 100, 1020, $bgc);

        /* Output an error message */
        imagestring($im, 5, 5, 5, 'Error loading image...', $tc);
		imagestring($im, 5, 5, 30, $logo, $tc);
    }
	else
	{
		/* Everything looks good, write in the shard_addr and shard_port */
		$font_name = 'fonts/Avatar.ttf';
		$font_server = 'fonts/Calibri.ttf'; // Choose a more readble font for the server name and port
		imagettftext($im, 45, 0, 82, 53, $sc, $font_name, $name); // Write Server Name Shadow First
		imagettftext($im, 45, 0, 80, 55, $tc, $font_name, $name); // Write Server Name
		imagettftext($im, 18, 0, 81, 89, $sc, $font_server, $shard . ":" . $port); // Write Server address and port Shadow First
		imagettftext($im, 18, 0, 80, 90, $tc, $font_server, $shard . ":" . $port); // Write Server address and port

	}
	return $im;
}
header('Content-Type: image/png');
$img = LoadRAZORsetup($img_logo,$shard_addr,$shard_port,$shard_name); //$razor_load_screen

imagepng($img);
imagedestroy($img);
?>