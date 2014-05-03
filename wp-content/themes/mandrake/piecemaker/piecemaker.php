<?php require_once('../../../../wp-load.php');

$effect = theme_get_option('slideshow','3d_effect');
$speed = theme_get_option('slideshow','3d_speed');
$pause = theme_get_option('slideshow','3d_pause');

$output = '<?xml version="1.0" encoding="utf-8"?>
<Piecemaker>
  <Settings ImageWidth="940" ImageHeight="400" LoaderColor="0x333333" InnerSideColor="0x222222" SideShadowAlpha="0.8" DropShadowAlpha="0.7" DropShadowDistance="15" DropShadowScale="0.95" DropShadowBlurX="40" DropShadowBlurY="8" MenuDistanceX="20" MenuDistanceY="30" MenuColor1="0x999999" MenuColor2="0x333333" MenuColor3="0xFFFFFF" ControlSize="100" ControlDistance="0" ControlColor1="0x222222" ControlColor2="0xFFFFFF" ControlAlpha="0.8" ControlAlphaOver="0.95" ControlsX="470" ControlsY="280&#xD;&#xA;" ControlsAlign="center" TooltipHeight="30" TooltipColor="0x222222" TooltipTextY="5" TooltipTextStyle="P" TooltipTextColor="0xFFFFFF" TooltipMarginLeft="5" TooltipMarginRight="7" TooltipTextSharpness="50" TooltipTextThickness="-100" InfoWidth="400" InfoBackground="0x000000" InfoBackgroundAlpha="0.6" InfoMargin="15" InfoSharpness="0" InfoThickness="0" Autoplay="'. $pause .'" FieldOfView="45"></Settings>
  <Transitions>
    <Transition Pieces="8" Time="'. $speed .'" Transition="'. $effect .'" Delay="0.1" DepthOffset="300" CubeDistance="20"></Transition>
  </Transitions>
  <Contents>';

$images = theme_builder('slideshow_images');
foreach ($images as $image){
    if ($image['desc'] != '' && $image['link'] != '') {
    	$output.='<Image Source="'.$image['src'].'">
        	<Text>'. $image['desc'] .'</Text>
            <Hyperlink URL="'.$image['link'].'" Target="_self" />
        </Image>';
    } else if ($image['desc'] != '') {
    	$output.='<Image Source="'.$image['src'].'">
        	<Text>'. $image['desc'] .'</Text>
        </Image>';
    } else if ($image['link'] != '') {
        $output.='<Image Source="'.$image['src'].'">
            <Hyperlink URL="'.$image['link'].'" Target="_self" />
        </Image>';
    } else {
    	$output.='<Image Source="'.$image['src'].'"></Image>';
    }
}
$output.='</Contents>';
$output.='</Piecemaker>';
header("Content-type: text/xml");
echo $output;

?>