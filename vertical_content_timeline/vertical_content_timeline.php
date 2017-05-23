<?php   
/*
Plugin Name: Vertical Content Timeline
Plugin URI:
Description: Vertical Content Timeline is a responsive, jQuery powered, wordpress plugin. It's ideal for showcasing your work. It has independent content, that can be imported from posts, pages or even whole categories. With intuitive user interface you can create multiple timelines categorized by date, or some other custom criteria. It is flexible, customizable and easy to use.
Author: Shindiri Studio
Version: 1.0
Author URI: http://www.shindiristudio.com/
*/

if (!class_exists("verticalContentTimelineAdmin")) {
	ini_set('memory_limit','100M');
	require_once dirname( __FILE__ ) . '/vertical_content_timeline_class.php';
	global $my_vctimeline_object;
	$vctimeline = new VerticalContentTimelineAdmin (__FILE__);
	$my_vctimeline_object=$vctimeline;
}