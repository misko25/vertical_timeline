<?php
require_once('vertical_front_script.php');
if(!isset($id))$id=100000000230;
if(empty($settings['style'])){
    $settings['style']='default';
}
$my_post_link_val=0;
if(!empty($settings['my-post-link'])){
    $my_post_link_val=1;
}

//wp_v_my_timeline_debug_title('Items', $itemsArray);
$append_style='';
if($settings['style']!='default'){

    if(in_array($settings['style'],array('montgomery','dover','jackson'))){
        $settings['style']='style_1';
    }
    if(in_array($settings['style'],array('boston','denver'))){
        $settings['style']='style_4';
    }
    if(in_array($settings['style'],array('springfield','sacramento'))){
        $settings['style']='style_3';
    }
    if(in_array($settings['style'],array('phoenix','atlanta'))){
        $settings['style']='style_2';
    }
    if(in_array($settings['style'],array('santafe'))){
        $settings['style']='orange';
    }
    if(in_array($settings['style'],array('nashville','austin'))){
        $settings['style']='default';
    }
    $my_css_dir_12=$this->path.'/css/frontend/themes/'.$settings['style'].'.css';
    //echo 'Dir '.$my_css_dir_12;
    if(file_exists($my_css_dir_12)){
        ob_start();
        require $my_css_dir_12;
        $append_style=ob_get_clean();
    }
}
if($settings['nav-style']=='flat_dark'){
    $my_is_dark=1;
    //echo 'My is dark '.$my_is_dark;
    $settings['nav-style']='flat';
}
$frontHtml = '
<style type="text/css" id="my_vertical_timeline_'.$id.'">
#vtl'. $id. ' .vertical_timeline_line,
#content #vtl'. $id. ' .vertical_timeline_line{
 	width: '.$settings['line-width'].'px;
}

#vtl'.$id.' .vertical_t_line_view,
#content #vtl'.$id.' .vertical_t_line_view {
 	width: '.$settings['line-width'].'px;
}

#vtl'.$id.' .vertical_t_line_m,
#content #vtl'.$id.' .vertical_t_line_m {
	width: '. (((int)$settings['line-width'])/2-2).'px;
}

#vtl'. $id.' .vertical_t_line_m.right,
#content #vtl'. $id.' .vertical_t_line_m.right {
	left: '. (((int)$settings['line-width'])/2-1).'px;
	width: '. (((int)$settings['line-width'])/2-1).'px;
}
'.

    ($settings['nav-style'] != 'flat' ?
        '#vtl'. $id.' .vertical_t_node_desc,
#content #vtl'. $id.' .vertical_t_node_desc {
	background: '.$settings['node-desc-color'].';
}' : '
#vtl'. $id.' .vertical_t_node_desc span,
#content #vtl'. $id.' .vertical_t_node_desc span {
	background: '.$settings['node-desc-color'].';
}
#vtl'. $id.' .vertical_t_node_desc span:after,
#content #vtl'. $id.' .vertical_t_node_desc span:after {
	border-top-color: '.$settings['node-desc-color'].';
}
#vtl'. $id.' .vertical_t_line_node,
#content #vtl'. $id.' .vertical_t_line_node {
	color: '.$settings['node-desc-color'].';
}
#vtl'. $id.' .vertical_t_line_node:after,
#content #vtl'. $id.' .vertical_t_line_node:after {
	background: '.$settings['node-desc-color'].';
}

#vtl'. $id.' .item.item_node_hover:before,
#content #vtl'. $id.' .item.item_node_hover:before {
	background: '.$settings['node-desc-color'].';
}

#vtl'. $id.' .item.item_node_hover:after,
#content #vtl'. $id.' .item.item_node_hover:after {
	border-top-color: '.$settings['node-desc-color'].';
}

#vtl'. $id.' #vertical_t_line_right:hover,
#content #vtl'. $id.' #vertical_t_line_right:hover,
#vtl'. $id.' #vertical_t_line_left:hover,
#content #vtl'. $id.' #vertical_t_line_left:hover {
	color: '.$settings['node-desc-color'].';
}')


    .'


#vtl'. $id.' .item h2,
#content #vtl'. $id.' .item h2 {
	font-size:'.$settings['item-header-font-size'].'px;
	color:'.$settings['item-header-font-color'].';
 	text-align: '. $settings['item-text-align'].';
	line-height:'.$settings['item-header-line-height'].'px;
 	margin-left: '. $settings['item-content-padding'].'px;
 	margin-right: '. $settings['item-content-padding'].'px;
 	margin-top: '. $settings['item-content-padding'].'px;';

switch($settings['item-header-font-type']) {
    case 'regular' : $frontHtml .= '
	font-weight:normal;
	font-style:normal;'; break;

    case 'thick' : $frontHtml .= '
	font-weight:100;
	font-style:normal;'; break;

    case 'bold' : $frontHtml .= '
	font-weight:bold;
	font-style:normal;'; break;

    case 'bold-italic' : $frontHtml .= '
	font-weight:bold;
	font-style:italic;'; break;

    case 'italic' : $frontHtml .= '
	font-weight:normal;
	font-style:italic;'; break;
}
$frontHtml .= '
}
#vtl'. $id.' .item span,
#content #vtl'. $id.' .item span {
 	text-align: '. $settings['item-text-align'].';
 	margin-bottom: '. $settings['item-content-padding'].'px;
 	margin-left: '. $settings['item-content-padding'].'px;
 	margin-right: '. $settings['item-content-padding'].'px;
}


#vtl'. $id.' .item,
#content #vtl'. $id.' .item {
 	width: '. $settings['item-width'].'px;
	height: '. $settings['item-height'].'px;';

if(in_array($settings['style'],array('style_1','style_2'))){
    if(empty($settings['item-back-color'])&&(empty($settings['item-background']))){
        $frontHtml.="background:transparent;";
    }else {
        if(!empty($settings['item-back-color'])&&(!empty($settings['item-background']))){
            $frontHtml.='background:'. $settings['item-back-color'].' url('. $settings['item-background'].') repeat;';
        }else if(!empty($settings['item-back-color'])){
            $frontHtml.='background:'. $settings['item-back-color'].';';
        }else {
            $frontHtml.='background:transparent url('. $settings['item-background'].') repeat;';
        }
    }
}else {
    $frontHtml.='background:'. $settings['item-back-color'].' url('. $settings['item-background'].') repeat;';
}

$frontHtml.='font-size:'.$settings['item-text-font-size'].'px;
	color:'.$settings['item-text-font-color'].';
	line-height:'.$settings['item-text-line-height'].'px;';


switch($settings['item-text-font-type']) {
    case 'regular' : $frontHtml .= '
	font-weight:normal;
	font-style:normal;'; break;

    case 'thick' : $frontHtml .= '
	font-weight:100;
	font-style:normal;'; break;

    case 'bold' : $frontHtml .= '
	font-weight:bold;
	font-style:normal;'; break;

    case 'bold-italic' : $frontHtml .= '
	font-weight:bold;
	font-style:italic;'; break;

    case 'italic' : $frontHtml .= '
	font-weight:normal;
	font-style:italic;'; break;
}


if($settings['shadow'] == 'show') {
    $frontHtml.= '
	box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
    -webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
    -moz-box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
    -webkit-transition: box-shadow 0.3s;
    -moz-transition: box-shadow 0.3s;
    transition: box-shadow 0.3s;
	zoom: 1;
	filter: progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=0, Direction=0),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=5, Direction=90),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=5, Direction=180),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=0, Direction=270);

	';
}
else {
    $frontHtml.= '
	-moz-box-shadow: 0 0 0 #000000;
	-webkit-box-shadow: 0 0 0 #000000;
	box-shadow: 0 0 0 #000000;';
}
$frontHtml.='
}';
$my_vertical_padding_12345=5;
if($settings['shadow'] == 'on-hover') {
    $my_vertical_padding_12345=30;
    $my_vertical_padding_12345_bottom=52;

}else if($settings['shadow'] != 'hide'){
    //$my_add_Class_12345=10;
    $my_vertical_padding_12345=10;

}
/**
 * Vertical styles appe3nd to timliene
 */

    $frontHtml.='#vtl'.$id.'.myVerticalTimneline .myVerticalRow:nth-child(2n+1){
		margin-top:'.$settings['my-vertical-margin-top'].'px !important
		}';
    $frontHtml.='#vtl'.$id.'.myVerticalTimneline .myVerticalRow:nth-child(2n) .item{
			margin-top:'.$settings['my-vertical-second-margin'].'px !important;
			}';
    $frontHtml.='#vtl'.$id.' .myVerticalLine{
			border-color:'.$settings['my-vertical-line-color'].' !important;
			}';
    $frontHtml.='#vtl'.$id.' .myVerticalBorder{
			border-color:'.$settings['my-vertical-line-color'].' !important;
			}';

    $frontHtml.='#vtl'.$id.' .myVerticalRightBorder{
			border-color:'.$settings['my-vertical-line-color'].' !important;
			}';
    $my_top1234=$settings['my-vertical-line-position']+$my_vertical_padding_12345;
    $frontHtml.='#vtl'.$id.'.myVerticalTimneline .myVerticalBorder{
			top:'.$my_top1234.'px !important;
			}';
    $my_top1234=$settings['my-vertical-line-position']+$settings['my-vertical-second-margin']+$my_vertical_padding_12345;
    $frontHtml.='#vtl'.$id.'.myVerticalTimneline .myVerticalRow:nth-child(2n) .myVerticalBorder{
			top:'.$my_top1234.'px !important;
			}';
    $frontHtml.='#vtl'.$id.'.myVerticalTimneline .myVerticalRow:nth-child(2n+1){
			margin-top:'.$settings['my-vertical-margin-top'].'px !important;
		}';
    $my_margintop1234=abs($settings['my-vertical-margin-top']);
    $frontHtml.='#vtl'.$id.'.myVerticalSmall  .myVerticalRow:nth-child(2n+1){
			margin-top:'.$my_margintop1234.'px !important;
			}';

    $frontHtml.='#vtl'.$id.'.myVerticalSmall  .myVerticalRow{
		margin-top:'.$my_margintop1234.'px !important;
		}';

    $frontHtml.='#vtl'.$id.'.myVerticalSmall .myVerticalRow:nth-child(2n) .item{
	margin-top:0px !important;
			}';
    $my_vertical_top1234=$settings['my-vertical-line-position']+$my_vertical_padding_12345;

    $frontHtml.='#vtl'.$id.'.myVerticalSmall .myVerticalRow:nth-child(2n) .myVerticalBorder{
			top:'.($my_vertical_top1234).'px !important;
		}';
    $frontHtml.='#vtl'.$id.'.myVerticalSmall .myVerticalRow:nth-child(2n+1) .myVerticalBorder{
			top:'.($my_vertical_top1234).'px !important;
		}';
    $frontHtml.='#vtl'.$id.'.myVerticalSmall .myVerticalRow{
			height:'.$settings['item-height'].'px !important
		}';

/*if(!empty($settings['vertical'])){
	$myh_12345=$settings['item-height'];//+20;
	 $frontHtml.="#vtl".$id." .myVerticalRow {
	height:".$myh_12345."px !important;
	}";
}*/
if($settings['shadow'] == 'on-hover') {
    $frontHtml.='#vtl'.$id.' .vertical_timeline_items{
		/*padding-top:20px !important;*/
		padding-bottom:52px !important;
	}';
    $frontHtml.= '
#vtl'. $id . ' .item:hover,
#content #vtl'. $id . ' .item:hover {
	 box-shadow: rgba(0, 0, 0, 0.247059) 0px 14px 45px, rgba(0, 0, 0, 0.219608) 0px 10px 18px;
    -webkit-box-shadow: rgba(0, 0, 0, 0.247059) 0px 14px 45px, rgba(0, 0, 0, 0.219608) 0px 10px 18px;
   -moz-box-shadow: rgba(0, 0, 0, 0.247059) 0px 14px 45px, rgba(0, 0, 0, 0.219608) 0px 10px 18px;
   -webkit-transition: box-shadow 0.3s;
   -moz-transition: box-shadow 0.3s;
   transition: box-shadow 0.3s;
	zoom: 1;
	filter: progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=0, Direction=0),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=5, Direction=90),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=5, Direction=180),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=0, Direction=270);


}';
    /*
    if(!empty($settings['vertical'])){
        $frontHtml.="#vtl".$id." .vertical_timeline_items{
                margin-left:30px !important;
                margin-right:30px !important;

                }";
        $frontHtml.="#vtl".$id.".myVerticalSmall .vertical_timeline_items{
                margin-left:0px !important;
                margin-right:0px !important;

                }";
    }
    }else {
        $frontHtml.="#vtl".$id.".myVerticalSmall .vertical_timeline_items{
                margin-left:0px !important;
                margin-right:0px !important;

                }";
        $frontHtml.="#vtl".$id." .vertical_timeline_items{
                margin-left:10px !important;
                margin-right:10px !important;

            }";
    }*/
        $myh_12345=$settings['item-height']+15+$my_vertical_padding_12345_bottom;
        /*$frontHtml.="#vtl".$id." .myVerticalRow {
            height:".$myh_12345."px !important;
        }";*/
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow {
			height:".$myh_12345."px !important;
		}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n+1) .myVerticalBorder{
				margin-left:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-right:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-left:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-right:0px !important;
			}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n+1){
			padding-top:15px !important;
			padding-bottom:".$my_vertical_padding_12345_bottom."px !important;

			padding-left:".$my_vertical_padding_12345."px !important;
			/*margin-right:30px !important;*/

			}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n){
			/*margin-left:0px !important;*/
			padding-top:15px !important;
			padding-bottom:".$my_vertical_padding_12345_bottom."px !important;
			padding-right:".$my_vertical_padding_12345."px !important;

			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n+1){
			padding-left:".$my_vertical_padding_12345."px !important;
			padding-bottom:".$my_vertical_padding_12345."px !important;
			/*margin-right:30px !important;*/

			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n){
			padding-left:".$my_vertical_padding_12345."px !important;
			padding-right:0px !important;
			padding-bottom:".$my_vertical_padding_12345."px !important;
			}";

}else {
    if($settings['shadow'] != 'hide'){
        $myh_12345=$settings['item-height']+2*$my_vertical_padding_12345;
        /*$frontHtml.="#vtl".$id." .myVerticalRow {
            height:".$myh_12345."px !important;
        }";*/
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n+1) .myVerticalBorder{
				margin-left:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-right:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-left:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-right:".$my_vertical_padding_12345."px !important;
			}";

        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow {
			height:".$myh_12345."px !important;
		}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n+1){
			padding-left:".$my_vertical_padding_12345."px !important;
			padding-top:".$my_vertical_padding_12345."px !important;
			padding-bottom:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n){

			padding-right:".$my_vertical_padding_12345."px !important;
			padding-left:0px !important;
			padding-top:".$my_vertical_padding_12345."px !important;
			padding-bottom:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n+1){
			padding-left:".$my_vertical_padding_12345."px !important;

			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n){
			padding-left:".$my_vertical_padding_12345."px !important;
			padding-right:0px !important;
		}";
    }else {
        $myh_12345=$settings['item-height']+2*$my_vertical_padding_12345;
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow {
			height:".$myh_12345."px !important;
		}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n+1) .myVerticalBorder{
				margin-left:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-right:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-left:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n) .myVerticalBorder{
				margin-right:0px !important;
			}";

        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n+1){
			padding-left:".$my_vertical_padding_12345."px !important;
			padding-top:".$my_vertical_padding_12345."px !important;
			padding-bottom:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id." .myVerticalRow:nth-child(2n){

			padding-right:".$my_vertical_padding_12345."px !important;
			padding-left:0px !important;
			padding-top:".$my_vertical_padding_12345."px !important;
			padding-bottom:".$my_vertical_padding_12345."px !important;
			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n+1){
			padding-left:".$my_vertical_padding_12345."px !important;

			}";
        $frontHtml.="#vtl".$id.".myVerticalSmall .myVerticalRow:nth-child(2n){
			padding-left:".$my_vertical_padding_12345."px !important;
			padding-right:0px !important;
		}";

    }
}

if(isset($my_is_dark)){

        $frontHtml.='#vtl'. $id.' .t_left{
			background:rgba(34,34,34,0.5) url("'.$this->url.'/css/images/timeline/clean/wht-arrow-up.png") no-repeat center center !important;

		}';

    $frontHtml.='#vtl'. $id.' .t_left:hover{
			background-color:rgba(34,34,34,0.7) !important;

		}';

        $frontHtml.='#vtl'. $id.' .t_right{
			background:rgba(34,34,34,0.5) url("'.$this->url.'/css/images/timeline/clean/wht-arrow-bottom.png") no-repeat center center !important;
		}';

    $frontHtml.='#vtl'. $id.' .t_right:hover{
			background-color:rgba(34,34,34,0.7) !important;
	}';
}
$frontHtml.= '


#vtl'. $id.' .item_open h2,
#content #vtl'. $id.' .item_open h2 {
	font-size:'.$settings['item-open-header-font-size'].'px;
	color:'.$settings['item-open-header-font-color'].';
	line-height:'.$settings['item-open-header-line-height'].'px;';

switch($settings['item-open-header-font-type']) {
    case 'regular' : $frontHtml .= '
	font-weight:normal;
	font-style:normal;'; break;

    case 'thick' : $frontHtml .= '
	font-weight:100;
	font-style:normal;'; break;

    case 'bold' : $frontHtml .= '
	font-weight:bold;
	font-style:normal;'; break;

    case 'bold-italic' : $frontHtml .= '
	font-weight:bold;
	font-style:italic;'; break;

    case 'italic' : $frontHtml .= '
	font-weight:normal;
	font-style:italic;'; break;
}
$frontHtml .= '
}

#vtl'. $id .' .item_open,
#content #vtl'. $id .' .item_open{
 	width: '. $settings['item-open-width'].'px;
	height: '. $settings['item-height'].'px;';
$frontHtml.='background:'. $settings['item-open-back-color'].' url('. $settings['item-open-background'].') repeat;';
$frontHtml.='
	font-size:'.$settings['item-open-text-font-size'].'px;
	color:'.$settings['item-open-text-font-color'].';
	line-height:'.$settings['item-open-text-line-height'].'px;';

switch($settings['item-open-text-font-type']) {
    case 'regular' : $frontHtml .= '
	font-weight:normal;
	font-style:normal;'; break;

    case 'thick' : $frontHtml .= '
	font-weight:100;
	font-style:normal;'; break;

    case 'bold' : $frontHtml .= '
	font-weight:bold;
	font-style:normal;'; break;

    case 'bold-italic' : $frontHtml .= '
	font-weight:bold;
	font-style:italic;'; break;

    case 'italic' : $frontHtml .= '
	font-weight:normal;
	font-style:italic;'; break;
}


if($settings['shadow'] == 'show' || $settings['shadow'] == 'on-hover') {
    $frontHtml.= '
	-moz-box-shadow: 0px 0px 6px rgba(0,0,0,0.5);
	-webkit-box-shadow: 0px 0px 6px rgba(0,0,0,0.5);
	box-shadow: 0px 0px 6px rgba(0,0,0,0.5);

	zoom: 1;
	filter: progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=0, Direction=0),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=5, Direction=90),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=5, Direction=180),
		progid:DXImageTransform.Microsoft.Shadow(Color=#888888, Strength=0, Direction=270);

	';
}
else {
    $frontHtml.= '
	-moz-box-shadow: 0 0 0 #000000;
	-webkit-box-shadow: 0 0 0 #000000;
	box-shadow: 0 0 0 #000000;';
}
$frontHtml.= '
 }';

$frontHtml.='
#vtl'. $id.' .item .vertical_con_borderImage,
#content #vtl'. $id.' .item .vertical_con_borderImage {
 	border:0px;
 	border-bottom: '. $settings['item-image-border-width'].'px solid '. $settings['item-image-border-color'].' ;';
if(in_array($settings['style'], array('style_1','style_2'))){

    $frontHtml.='height: '.(int)$settings['item-height'] .'px';
    //}
}else {
    $frontHtml.='height: '.$settings['item-image-height'] .'px;';

}
$frontHtml.='}';
$frontHtml.='
#vtl'. $id.' .item .post_date,
#content #vtl'. $id.' .item .post_date {
 	border:0px;';
if(in_array($settings['style'], array('style_1','style_2'))){
    $frontHtml.='background:transparent';
}else {
    $frontHtml.='background: '. $settings['item-image-border-color'];
}
$frontHtml.='}';
$frontHtml.='
#vtl'. $id.' .item_open .vertical_con_borderImage,
#content #vtl'. $id.' .item_open .vertical_con_borderImage {
 	border-bottom: '. $settings['item-open-image-border-width'].'px solid '. $settings['item-open-image-border-color'].' ;
}';
//if(!empty($settings['vertical'])){
    if(wp_is_mobile()){
        $frontHtml.='#vtl'.$id." .t_left ,".'#vtl'.$id." .t_right {
		display:none !important;
	}";
    }

    $frontHtml.='
#vtl'. $id.' .item_open_cwrapper,
#vtl'. $id.' .item_open .vertical_con_borderImage,
#content #vtl'. $id.' .item_open_cwrapper,
#content #vtl'. $id.' .item_open .vertical_con_borderImage {
 	width: '. $settings['item-width'].'px;
}
#vtl'. $id.' .item_open .vertical_con_borderImage{
		height:'.$settings['item-open-image-height'].'px !important;
	}
';

/*}else {
    $frontHtml.='
#vtl'. $id.' .item_open_cwrapper,
#vtl'. $id.' .item_open .vertical_con_borderImage,
#content #vtl'. $id.' .item_open_cwrapper,
#content #vtl'. $id.' .item_open .vertical_con_borderImage {
 	width: '. $settings['item-open-width'].'px;
}
#vtl'. $id.' .item_open .vertical_con_borderImage{
		height:'.$settings['item-open-image-height'].'px;
	}
';
}*/
/**
 * Include font styles for read more for other than style 3
 *
 */
if(!in_array($settings['style'],array('style_3','style_4','style_1'))){
    $frontHtml.='.vertical_timeline.flatButton .item .read_more , #content .vertical_timeline.flatButton .item .read_more{font-size:12px !important;}';
    $frontHtml.='.vertical_timeline.flatButton .item .read_more,
.vertical_timeline.flatWideButton .item .read_more,
#content .vertical_timeline.flatButton .item .read_more,
#content .vertical_timeline.flatWideButton .item .read_more{
	font-size:12px !important;
	line-height:12px !important;
}';
    $frontHtml.='.vertical_timeline .item .read_more,
#content .vertical_timeline .item .read_more {

	font-size:20px !important;
	line-height:20px !important;

}';
}
if(in_array($settings['style'],array('style_1','style_2','style_3','style_4'))){
    $frontHtml.='#vtl'.$id.' .my_icon_1:hover{
			color:'.$settings['button-color'].' !important;
		}';
    $my_width=$settings['item-width']-2*$settings['item-content-padding'];
    $frontHtml.='#vtl'.$id.' .item .my_category , #vtl'.$id.' .my_post_date, #vtl'.$id.' .my_share_items i, #vtl'.$id.' .my_share_items span{
		text-align:'.$settings['item-text-align'].';
		font-size:'.$settings['item-text-font-size'].'px;
		line-height:'.$settings['item-text-line-height'].'px;
	}';
    $my_f_12=14;//$settings['item-text-font-size']*1.3;

    if(in_array($settings['style'],array('style_2','style_4'))){
        /*$frontHtml.='#vtl'.$id.' .my_share_items .my_post_date , #vtl'.$id.' .my_share_items span  {
                line-height:'.$my_f_12.'px !important;
                height:'.$my_f_12.'px !imporant;

        }';*/
    }

    $frontHtml.='#vtl'.$id.' .icon-bubble , #vtl'.$id.' .icon-bubble {
			color:'.$settings['item-text-font-color'].';
				}';
    if(in_array($settings['style'],array('style_3'))){
        $frontHtml.='#vtl'.$id.' .item .my_read_more_1{
			color:'.$settings['item-header-font-color'].' !important;
			text-align: '. $settings['item-text-align'].' !important;
			line-height:'.$settings['item-header-line-height'].'px !important;

	}';
        $frontHtml.='#vtl'.$id.' .item .my_post_date , #vtl'.$id.' .item .my_post_date span{
				font-size:30px !important;
				font-weight:300 !important;
		}';


    }
    if(in_array($settings['style'],array('style_2'))){
        $frontHtml.='#vtl'.$id.' .item .my_read_more{
			color:'.$settings['item-header-font-color'].' !important;
			text-align: '. $settings['item-text-align'].' !important;
			line-height:'.$settings['item-header-line-height'].'px !important;
			}';
        $frontHtml.='#vtl'.$id.' .item .my_read_more:hover {
				color:'.$settings['button-hover-color'].' !important;
				}';
    }
    if(in_array($settings['style'],array('style_4'))){
        $frontHtml.='#vtl'.$id.' .item h2 {
			padding-left:'.$settings['item-content-padding'].'px;
			padding-right:'.$settings['item-content-padding'].'px;
			}';
    }
    if(in_array($settings['style'],array('style_2','style_4'))){
        $frontHtml.='#vtl'.$id.' .my_icon, #vtl'.$id.' .my_share_items span, #vtl'.$id.' .my_post_date  {
				font-size:'.$my_f_12.'px !important;
			}';
        $frontHtml.='#vtl'.$id.' .my_icon{
				display:inline-block !important;
				margin-right:3px !important;
			}';
        /*$frontHtml.='#vtl'.$id.' .my_icon  ,#vtl'.$id.' .my_share_items span{
                color:'.$settings['item-text-font-color'].'
            }';*/

    }
    $frontHtml.='#vtl'.$id.' .item .my_category , #vtl'.$id.' .my_post_date, #vtl'.$id.' .my_share_items span, #vtl'.$id.' .my_icon_1{
		color:'.$settings['item-text-font-color'].';
	}';

    $frontHtml.='#vtl'.$id.' .my_vertical_timeline_content{
			bottom:'.$settings['item-content-padding'].'px;
					}';

    $frontHtml.='#vtl'.$id.' .item h2, #content #vtl'.$id.' .item h2, #vtl'.$id.' .item .read_more , #vtl'.$id.' .my_post_date{
				margin-left:0px !important;
				margin-right:0px !important;
			}';
    $frontHtml.='#vtl'.$id.' .item span, #content #vtl'.$id.' .item span{
				margin-left:0px !important;
				margin-right:0px !important;

	}';
    /*if(in_array($settings['style'],array('style_2','style_4'))){
        $frontHtml.='#vtl'.$id.' .item .my_share_item span{
                margin-left:3px !important;
                margin-right:0px !important;

    }';
    }*/
    $frontHtml.='#vtl'. $id.' .my_vertical_timeline_content{
			width:'.$my_width.'px;
			margin-left:'.$settings['item-content-padding'].'px;
			margin-right:'.$settings['item-content-padding'].'px;

			}';
    $frontHtml.='#vtl'. $id.' .my_share_items{
			padding-top:  '.$settings['item-content-padding'].'px
	}';
    $frontHtml.='#vtl'. $id.' .my_post_date{
			color:'.$settings['item-text-font-color'].';
			line-height:'.$settings['item-text-line-height'].'px;
			font-size:'.($settings['item-text-font-size']+2).'px;
			text-align:left;';

    if(in_array($settings['style'],array('style_1'))){
        $frontHtml.='margin-left: '. $settings['item-content-padding'].'px;
 			margin-right: '. $settings['item-content-padding'].'px';
    };
    $frontHtml.='
	}';
    if(in_array($settings['style'],array('style_3','style_4','style_1'))){

        if(in_array($settings['style'],array('style_4'))){
            $frontHtml.='#vtl'. $id.' .my_share_items {
				padding-bottom	:'.$settings['item-content-padding'].'px;
			}';
            $frontHtml.='#vtl'. $id.' .my_post_date {

				padding-bottom	:'.$settings['item-content-padding'].'px;
			}';


        }
        $frontHtml.='#vtl'. $id.' .my_post_date span{
			border-color:'.$settings['button-color'].';
			padding-bottom:'.$settings['item-content-padding'].'px;
			color:'.$settings['button-color'].';

	}';
        $frontHtml.='#vtl'. $id.' .my_post_date{
			text-align:'.$settings['item-text-align'].';

		}';
        $frontHtml.='#vtl'. $id.' .item .read_more{
			text-align:'.$settings['item-text-align'].';
		}';
        if(in_array($settings['style'], array('style_4'))){
            $frontHtml.='#vtl'. $id.' .item .read_more{
				text-transform:uppercase;
				}';
        }
        if(in_array($settings['style'],array('style_3'))){
            $frontHtml.='#vtl'. $id.' .item .read_more{
				text-transform:uppercase;
				font-size:'.($settings['item-text-font-size']+2).'px !important;
			}';
            $frontHtml.='#vtl'. $id.' .item .my_read_more_1{
				margin-bottom:'.(2*$settings['item-content-padding']).'px
			}';
            /*$frontHtml.='#vtl'. $id.' .read_more {
                margin:0 !important;
            }';*/
            $frontHtml.='#vtl'. $id.' .my_post_date span{
					margin-bottom:0px !important;
					}';

        }
        if(in_array($settings['style'],array('style_3','style_4','style_1'))){
            $frontHtml.='#vtl'. $id.' .item .read_more{

			   font-size:14px !important;
			}';

        }

    }

    $frontHtml.='
#vtl'. $id.' .item_open .t_close:hover,
#content #vtl'. $id.' .item_open .t_close:hover{
	background:'. $settings['button-hover-color'].';
}
#vtl'. $id.'.flatButton .item .read_more,
#vtl'. $id.'.flatWideButton .item .read_more,
#content #vtl'. $id.'.flatButton .item .read_more,
#content #vtl'. $id.'.flatWideButton .item .read_more {
	background:transparent;
	color:'. $settings['button-color'].' !important;
	margin:'.$settings['item-content-padding'].'px;
}

#vtl'. $id.'.flatButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
#vtl'. $id.'.flatWideButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
#content #vtl'. $id.'.flatButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
#content #vtl'. $id.'.flatWideButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {

	color:'. $settings['button-color'].' !important;
}

#vtl'. $id.' .item .read_more:hover,
#content #vtl'. $id.' .item .read_more:hover{
	color:'. $settings['button-hover-color'].' !important;
}';
    if($settings['style']=='style_3'){

    }
}else {
    $frontHtml.='
#vtl'. $id.' .item_open .t_close:hover,
#content #vtl'. $id.' .item_open .t_close:hover{
	background:'. $settings['button-hover-color'].';
}
#vtl'. $id.'.flatButton .item .read_more,
#vtl'. $id.'.flatWideButton .item .read_more,
#content #vtl'. $id.'.flatButton .item .read_more,
#content #vtl'. $id.'.flatWideButton .item .read_more {
	background:'. $settings['button-color'].';
	margin:'.$settings['item-content-padding'].'px;
}

#vtl'. $id.'.flatButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
#vtl'. $id.'.flatWideButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
#content #vtl'. $id.'.flatButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,
#content #vtl'. $id.'.flatWideButton .mCS-light-thin > .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
	background:'. $settings['button-color'].';
}

#vtl'. $id.' .item .read_more:hover,
#content #vtl'. $id.' .item .read_more:hover{
	background:'. $settings['button-hover-color'].';
}';
};
$frontHtml.='
#vtl'. $id.'.flatButton .item_open.item_open_noImg .t_close,
#vtl'. $id.'.flatWideButton .item_open.item_open_noImg .t_close,
#content #vtl'. $id.'.flatButton .item_open.item_open_noImg .t_close,
#content #vtl'. $id.'.flatWideButton .item_open.item_open_noImg .t_close {
	color:'. $settings['button-color'].' !important;
}

#vtl'. $id.'.flatButton .item_open.item_open_noImg .t_close:hover,
#vtl'. $id.'.flatWideButton .item_open.item_open_noImg .t_close:hover,
#content #vtl'. $id.'.flatButton .item_open.item_open_noImg .t_close:hover,
#content #vtl'. $id.'.flatWideButton .item_open.item_open_noImg .t_close:hover {
	color:'. $settings['button-hover-color'].' !important;
}

#vtl'. $id.' .item .read_more,
#content #vtl'. $id.' .item .read_more,
#vtl'. $id.' .item_open .t_close,
#content #vtl'. $id.' .item_open .t_close {

	/* transparent background */
	filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=\'#44000000\', endColorstr=\'#44000000\');
}

#vtl'. $id.' .vertical_t_node_desc,
#content #vtl'. $id.' .vertical_t_node_desc {

	/* IE transparent background */
	filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=\'#cc1a86ac\', endColorstr=\'#cc1a86ac\');
}



#vtl'. $id.' .vertical_timeline_open_content,
#content #vtl'. $id.' .vertical_timeline_open_content {
	padding:'. $settings['item-open-content-padding'].'px;
}
'.$append_style;
if(wp_is_mobile()&&in_array($settings['style'],array('style_2','style_1'))){
    $frontHtml.="#vtl".$id.' .item::after{
		display:none !important;
	}';


    //$my_is_mobile=1;
}
/**
 * Node colors
 */
if($settings['style']!='default'&&$settings['style']!=='orange'){
    $frontHtml.='#vtl'.$id.' .vertical_t_line_holder{
		background:url("") !important;
	}';
    if(in_array($settings['style'],array('style_1'))){
        $frontHtml.='.vertical_timeline .item {
			text-align:left !important;
			display:inline-block;
		}';
    }

    $frontHtml.='#vtl'.$id.' .vertical_t_line_wrapper::after{
		content:"";
		position:absolute;
		top:49px;
		left:0px;
		width:100%;
		border-bottom:1px solid '.$settings['node-line-color'].';
		z-index:0;
		}';
    $frontHtml.='#vtl'.$id.' #vertical_t_line_left, #vtl'.$id.' #vertical_t_line_right {
	color:'.$settings['node-arrows-color'].' !important;
	}';
    $frontHtml.='#vtl'.$id.' .vertical_t_line_node::after{
	background:'.$settings['node-dot-color'].' !important;
	}';
    $frontHtml.='#vtl'.$id.' .vertical_t_line_m.right{
	border-left-color:'.$settings['node-line-color'].' !important;
	}';
    $frontHtml.='.vertical_timeline.flatLine .vertical_t_line_m, #content .vertical_timeline.flatLine .vertical_t_line_m{
			border-right:1px solid transparent;
		}';
}
$frontHtml.='#vtl'.$id.' .mCSB_dragger_bar{
		background:'.$settings['item-open-scroll-color'].' !important;
		}';
/**
 * izmenio
 */

$responsive_years = isset( $settings['responsive-years'] ) && intval( $settings['responsive-years'] ) === 1 ? true : false;
if ( $responsive_years && wp_is_mobile() ) {
    $frontHtml.='.vertical_timeline.flatLine a.vertical_t_line_node, #content .vertical_timeline.flatLine a.vertical_t_line_node {
    text-indent: -9999px !important;
    }
    .entry-content a, .entry-summary a, .taxonomy-description a, .logged-in-as a, .comment-content a, .pingback .comment-body > a, .textwidget a, .entry-footer a:hover, .site-info a:hover {
        box-shadow: 0 0px 0 0 currentColor;
        }
';
}
$disable_pretty_photo = isset( $settings['disable_pretty_photo'] ) && intval( $settings['disable_pretty_photo'] ) === 1 ? true : false;
if ( $disable_pretty_photo) {
    $frontHtml.='#vtl'.$id.' .item_open .vertical_con_borderImage, #content #vtl'.$id.' .item_open .vertical_con_borderImage {
    pointer-events: none !important;
}
.vertical_timeline .item_open .scrollable-content, #content .vertical_timeline .item_open .scrollable-content {
 pointer-events: auto !important;
}
';
}



$activate_search = isset( $settings['activate-search'] ) && intval( $settings['activate-search'] ) === 1 ? true : false;
if(!$activate_search){
    $frontHtml.='.vertical_timeline .vertical_search_bar_holder {
    display:none !important;
    }';
    if($settings['hide-show-search'] == 'hidden'){
        $frontHtml.='.vertical_timeline #vertical_search_timeline_bar_icon, #content .vertical_timeline #vertical_search_timeline_bar_icon {
    display: none !important;
    }
    .vertical_timeline .vertical_vertical_timeline_items_wrapper, #content .vertical_timeline .vertical_vertical_timeline_items_wrapper {
        transform: translate(0, 0px);
        margin-bottom: 50px;
        }
    ';
    }

}
else {
    if($settings['search-bar-position'] == 'top') {
        $frontHtml .= '.vertical_timeline .vertical_timeline_line, #content .vertical_timeline .vertical_timeline_line {
    	transform: translate(0, 50px);
    	}';
    }
    if ($settings['hide-show-search'] == 'hidden') {
        if($settings['search-bar-position'] == 'top') {
            $frontHtml.='.vertical_timeline .vertical_vertical_timeline_items_wrapper, #content .vertical_timeline .vertical_vertical_timeline_items_wrapper {
        transform: translate(0, 40px);
        margin-bottom: 50px;
        }';
        }
        $frontHtml.='.vertical_timeline #vertical_search_timeline_bar_icon, #content .vertical_timeline #vertical_search_timeline_bar_icon{
    display:block !important;
    }
    .vertical_timeline .vertical_search_bar_holder {
    display:none;
    }
';
    }

}


$fast_forward_backward = isset( $settings['fast-forward-backward'] ) && intval( $settings['fast-forward-backward'] ) === 1 ? true : false;
if ( $fast_forward_backward) {
    $frontHtml.='.vertical_timeline.flatLine #vertical_t_line_backward,
		#content .vertical_timeline.flatLine #vertical_t_line_backward{
    display: block !important;
}
.vertical_timeline.flatLine #vertical_t_line_forward,
#content .vertical_timeline.flatLine #vertical_t_line_forward {
 display: block !important;
}
';
}
/*echo '<test>';
var_dump(wp_is_mobile());*/
/**
 * izmenio
 */
$frontHtml.='


</style>
';
/**
For new styles dont add line class
 */
$lineclass = '';
$navclass = '';
if(in_array($settings['style'],array('default','orange'))){
    if($settings['line-style'] == 'flat') $lineclass = ' flatLine';
    else if($settings['line-style'] == 'dark') $lineclass = ' darkLine';


    if($settings['nav-style'] == 'flat') $navclass = ' flatNav';
    else if($settings['nav-style'] == 'dark') $lineclass = ' darkNav';
}else {
    $lineclass = ' flatLine';
    $navclass = ' flatNav';
}
$buttonclass = '';
if($settings['button-type'] == 'flat') $buttonclass = ' flatButton';
else if($settings['button-type'] == 'flat-wide') $buttonclass = ' flatWideButton';

$my_class_timeline='';
if($settings['style']!='default'){
    $my_class_timeline=' my_style_'.$settings['style'];
}
$myIsYearsClass='';
if($settings['cat-type']=='years'){
    $myIsYearsClass==' my_is_years_class ';
}
$myisVerticalClass='';
$myIsVertical=false;
//if(!empty($settings['vertical'])){
    $myIsVertical=true;
    $myisVerticalClass=' myVerticalTimneline';

//}

$frontHtml .='

<!-- BEGIN TIMELINE -->
<div id="vtl'. $id.'" class="vertical_timeline'.$lineclass.$navclass.$buttonclass.$my_class_timeline.$myIsYearsClass.$myisVerticalClass.'">';

if(isset($itemsArray) && is_array($itemsArray)) {
    $my_auto_add_posts=false;
    if(!empty($my_cats_timeline)&&(!empty($settings['load-post-dynamic']))){
        $file=$this->path.'/tmp/updating_'.$id.'.tmp';
        if(!file_exists($file)){

            //echo 'Update timeline posts '.$id.'<br/>';
            $fp=fopen($file,'w');
            fwrite($fp,'1');
            fclose($fp);
            $my_do=false;
            global $wp_my_timeline_load_timeout;
            $time=time()-$wp_my_timeline_load_timeout;
            $file_1=$this->path.'/tmp/update_'.$id.'.tmp';

            if(!file_exists($file_1))$my_do=true;
            else {
                $t=file_get_contents($file_1);
                if($t<$time){
                    $my_do=true;
                }else {
                    //	echo 'Time last update '.date('Y/m/d H:i:s',$t).' update after '.date('Y/m/d H:i:s',$time);
                }
            }
            if($my_do){
                $c_fp=fopen($file_1,'c');
                if(flock($c_fp, LOCK_EX)){
                    $my_auto_add_posts=true;
                    $my_set_latest_post_12=false;
                    if(!empty($settings['latest-post-start-item'])){
                        $my_set_latest_post_12=true;

                    }
                    $my_sort_id_last_12=wp_v_my_timeline_get_last_item_key($itemsArray)+1;
                    $new_items=wp_v_my_timeline_add_new_posts($id,$my_cats_timeline,$itemsArray,$my_set_latest_post_12,$my_sort_id_last_12);
                    if(!empty($new_items)){
                        $my_sort_id_123=$my_sort_id_last_12;
                        foreach ($new_items as $key=>$val){
                            $itemsArray['sort'.$my_sort_id_123]=$val;
                            $my_sort_id_123++;
                        }

                    }
                    $str=time();
                    fwrite($c_fp,$str);
                    fflush($c_fp);
                    flock($c_fp, LOCK_UN);

                    fclose($c_fp);
                    unlink($file);
                }
            }else {
                unlink($file);
            }

        }
    }
    if($settings['cat-type']=='years'){
        $my_timeline_by_years=1;
        $settings['cat-type']='categories';
        $cats=",categories:['timeline'],numberOfSegments:30";
        /*$cc='timeline';
        array_push ($catArray,$cc);
        array_push ($ccNumbers, 0);
        $catNumber++;
        */
        wp_v_my_timeline_cat_years($itemsArray);
        ?>
        <?php /*
		<pre>
		<?php print_r($itemsArray);?>
		</pre>
		*/ ?>
        <?php
    }
    if(!empty($settings['switch-direction'])){
        $itemsArray=array_reverse($itemsArray);
    }

    $iteration = -1;

        $myc11=count($itemsArray);
        $myIsLast=0;
        if(($myc11%2)==1){
            $myIsLast=1;
        }
        $myarrayKeys = array_keys($itemsArray);
        // Fetch last array key
        $mylastArrayKey = array_pop($myarrayKeys);
        //echo 'myislast '.$myIsLast.' '.$mylastArrayKey.'<br/>';
    foreach ($itemsArray as $key => $arr) {

        $num = substr($key,4);
        $iteration++;

        if($settings['cat-type'] == 'categories') {
            if(isset($my_timeline_by_years)){
                //$arr['dataid']=$arr['node-name'].'/timeline';

            }else {
                $index = array_search($arr['categoryid'],$catArray);
                $ccNumbers[$index]++;
                $arr['dataid'] = ($ccNumbers[$index] < 10 ? '0'.$ccNumbers[$index] : $ccNumbers[$index]).'/'.$arr['categoryid'];
            }
        }
        if(array_key_exists('start-item', $arr)) {
            $start_item = $arr['dataid'];

        }
        $image = '';
        $image_other = '';
        $imageElementSrc = '';
        $imageElementImg = '';
        $prettyPhotoContainer = '';
        $imageid = '';
        if(in_array($settings['style'], array('style_1','style_2'))){
            if($arr['item-image'] != '') {
                $imgw = (int)$settings['item-width'];
                $imgh = (int)$settings['item-height'];

                $image = vbro_images::get_image($arr['item-image'], $imgw, $imgh);
                $image = '<img src="'. $image .'" alt=""/>';
            }
        }else {
            if($arr['item-image'] != '') {
                $imgw = (int)$settings['item-width'];
                $imgh = (int)$settings['item-image-height'];
                $image = vbro_images::get_image($arr['item-image'], $imgw, $imgh);
                $image = '<img src="'. $image .'" alt=""/>';

                $imageid = $arr['dataid'];
                if($arr['item-image-photos'] != '') {
                    $imagePrettyPhotoIDs = explode(',', $arr['item-image-photos']);
                    $prettyPhotoContainer .= '<div class="pretty-photo-images" style="display:none">';
                    foreach ($imagePrettyPhotoIDs as $value) {
                        $imageElementImg = wp_get_attachment_image($value, add_image_size(false));
                        $imageElementSrc = wp_get_attachment_image_url($value, add_image_size(false));

                        $prettyPhotoContainer .= '<a href="';
                        $prettyPhotoContainer .= $imageElementSrc;
                        $prettyPhotoContainer .= '" rel="prettyPhoto['.$imageid.']">';
                        $prettyPhotoContainer .= $imageElementImg;
                        $prettyPhotoContainer .= '</a>';
                    }
                    $prettyPhotoContainer .= '</div>';

                }

            }

        }


        $image = (($image != '') ? '<a class="vertical_timeline_rollover_bottom vertical_con_borderImage" href="'.(($arr['item-prettyPhoto'] != '') ? $arr['item-prettyPhoto'] : $arr['item-image']).'" rel="prettyPhoto['.$imageid.']">'.$image.'</a>'.$prettyPhotoContainer.'':'<a style="display:block;" class="vertical_con_borderImage">'.$image.'</a>');

        $readMore = '';
        if($settings['read-more'] == 'button') {
            if($my_post_link_val==1) {
                if(isset($arr['item-link']) && $arr['item-link'] != '') {
                    $readMore = '<a class="read_more" target="_blank" href="'.$arr['item-link'].'">'.$settings['more-text'].'</a>';
                }
                else if(!empty($arr['my-post-id'])) {
                    $my_link_12_1234=get_permalink($arr['my-post-id']);
                    $readMore = '<a class="read_more" target="_blank" href="'.$my_link_12_1234.'">'.$settings['more-text'].'</a>';
                }
                else {
                    $readMore = '<div class="read_more" data-id="'.$arr['dataid'].'">'.$settings['more-text'].'</div>';
                }

            }
            else {
                if(isset($arr['item-link']) && $arr['item-link'] != '') {
                    $readMore = '<a class="read_more" target="_blank" href="'.$arr['item-link'].'">'.$settings['more-text'].'</a>';
                }
                else {
                    $readMore = '<div class="read_more" data-id="'.$arr['dataid'].'">'.$settings['more-text'].'</div>';
                }
            }

        }


        $search_bar_position = 0;

        if($settings['search-bar-position'] == 'top') {
            $search_bar_position = 0;
        }
        else if($settings['search-bar-position'] == 'center') {
            $search_bar_position = 1;
        }
        else {
            $search_bar_position = 2;
        }

        $alignment = 1;

        if($settings['align-start-item'] == 'center') {
            $alignment = 1;
        }
        else if($settings['align-start-item'] == 'left') {
            $alignment = 0;
        }
        else {
            $alignment = 2;
        }

        $blogDate = '';
        $myCatsTrim = ','.substr($myCats, 1,-2);

        $translatedMonthsArray=explode(',', $myCatsTrim);
        if($settings['show-date']) {
            if(in_array($settings['style'],array('style_1','style_2','style_3','style_4'))){
                $my_date=$arr['dataid'];

                $my_arr=explode("/",$my_date);
                $month=$my_arr[1];
                $monthIndex=substr($month, -1);
                $day=$my_arr[0];
                $year=$my_arr[2];
                $my_date=$month.'/'.$day.'/'.$year;
                $my_timestamp=strtotime($my_date);
                if($settings['style']=='style_1'){
                    $my_date=trim($translatedMonthsArray[$monthIndex], "'");
                    $my_date_str=$my_date.date(' j',$my_timestamp);
                }else if($settings['style']=='style_2')
                {
                    $my_date=trim($translatedMonthsArray[$monthIndex], "'");
                    $my_date_str=date("j ",$my_timestamp);
                    $my_date_str.=$my_date.','.date(" Y",$my_timestamp);
                }
                if($settings['style']=='style_4'){
                    $my_date=trim($translatedMonthsArray[$monthIndex], "'");
                    $my_date_str=date("j ",$my_timestamp);
                    $my_date_str.=$my_date.','.date(" Y",$my_timestamp);
                }
                else if($settings['style']=='style_3')$my_date_str='<span>'.$day.'/'.$month.'</span>';
                if($settings['style']=='style_2'){
                    if(!isset($arr['my-post-id'])){
                        $blogDate='<div class="my_post_date my_no_share">'.$my_date_str.'</div>';
                    }
                    else {
                        $blogDate='<div class="my_post_date">'.$my_date_str.'</div>';
                    }
                }
                else $blogDate='<div class="my_post_date">'.$my_date_str.'</div>';
            }
            else if($settings['style']=='orange'){
                $blogDay = substr($arr['dataid'], 0, 2);
                $wholeDate=$arr['dataid'];
                $wholeDateStriped=explode('/', $wholeDate);
                $month=$wholeDateStriped[1];
                $monthIndex=substr($month, -1);
                $blogMonth = strtoupper(substr(trim($translatedMonthsArray[$monthIndex], "'"), 0, 3));

                $monArray = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
                $blogDate = '<div class="post_date">'.$blogDay.'<span>'.$blogMonth.'</span></div>';
            }
            else if(strlen($arr['dataid']) == 10) {
                $blogDay = substr($arr['dataid'], 0, 2);
                $wholeDate=$arr['dataid'];
                $wholeDateStriped=explode('/', $wholeDate);
                $month=$wholeDateStriped[1];
                $monthIndex=substr($month, -1);
                $blogMonth = strtoupper(substr(trim($translatedMonthsArray[$monthIndex], "'"), 0, 3));

                $monArray = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
                $blogDate = '<div class="post_date">'.$blogDay.'<span>'.$blogMonth.'</span></div>';
            }
        }
            $my_add_Class_12345='';
            /*if($key=$mylastArrayKey&&$myIsLast){
                $my_add_Class_12345=' myVerticalRightBorder';
            }*/
            if(!in_array($settings['style'],array('default','orange'))){

                $file=$this->path.'/pages/tmpl/'.$settings['style'].'.php';
                if(file_exists($file)){
                    ob_start();
                    require $file;
                    $html=ob_get_clean();
                    $frontHtml.='<div class="myVerticalRow '.$my_add_Class_12345.'"><div class="myVerticalBorder"></div>'.$html.'</div>';
                    //$frontHtml.=ob_get_clean();

                }else {
                    //echo $file.' <br/> dont exists';
                }
            }else {
                $frontHtml .='<div class="myVerticalRow '.$my_add_Class_12345.'"><div class="myVerticalBorder"></div>

		<div class="item" data-id="'. $arr['dataid'].'"'.(($arr['node-name'] && $arr['node-name'] != '') ? ' data-name="'.$arr['node-name'].'"': '').' data-description="'. mb_substr($arr['item-title'],0,30).'">
			'.$image.$blogDate.'
			<h2>'.$arr['item-title'].'</h2>
			<span>'.$arr['item-content'].'</span>
			'.$readMore.'



		<div class="item_open'.($arr['item-image'] == '' ? ' item_open_noImg' : '').'" data-id="'.$arr['dataid'].'" '.(!isset($tpreview) ? 'data-access="'.admin_url( 'admin-ajax.php' ).'?action=vctimeline_frontend_get&vtimeline='.$id.'&id='.$key.'"': '').'>
			<div class="item_open_content">';
                if(!isset($tpreview)) {
                    $frontHtml.='
	 			<img class="ajaxloader" src="'. $this->url .'images/loadingAnimation.gif" alt="" />';
                    $frontHtml.='
		</div>
		</div>
		</div>
		</div>';
                }
                else {
                    if ($arr['item-open-image'] != '') {
                        $frontHtml .= '
			<a class="vertical_timeline_rollover_bottom vertical_con_borderImage" href="'.(($arr['item-open-prettyPhoto'] != '')? $arr['item-open-prettyPhoto'] : $arr['item-open-image']).'" rel="prettyPhoto[timeline]">';
                        $image = '';
                        if($arr['item-image'] != '') {
                            $imgw = (int)$settings['item-open-width'];
                            $imgh = (int)$settings['item-open-image-height'];
                            $image = vbro_images::get_image($arr['item-open-image'], $imgw, $imgh);
                            $image = '<img src="'. $image .'" alt=""/>';
                        }
                        $frontHtml .= '
			'.$image. '</a>
			<div class="vertical_timeline_open_content" style="height: '. $open_content_height.'px">';

                    }
                    else {
                        $frontHtml .= '
			<div class="vertical_timeline_open_content" style="height: '. (intval($settings['item-height']) - 2*intval($settings['item-open-content-padding'])).'px">';
                    }

                    if ($arr['item-open-title'] != '') {
                        $frontHtml .= '
				<h2>'.$arr['item-open-title'].'</h2>';
                    }
                    $frontHtml .= '
				<span'.(!isset($arr['desable-scroll']) || !$arr['desable-scroll'] ? ' class="scrollable-content"' : '').'>
				' .stripslashes($arr['item-open-content']).'
				</span>
			</div>';
                    $frontHtml.='
			</div>
		</div>
		</div>
		</div>
				';}

            }
    }

    $frontHtml .= '
</div> <!-- END TIMELINE -->
';
}
