<?php

function btn_edit ($uri)
{
	return anchor(base_url().$uri, '<i class="icon-edit"></i>',array("id"=>"edit"));
}

function btn_delete ($uri)
{
	return anchor(base_url().$uri, '<i class="icon-trash" style="color:white"></i>', array(
		'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');",'id'=>"remove"
		));
}
function btn_upload ($uri)
{
	return anchor(base_url().$uri, '<i class="icon-cloud-upload"></i>', array('id'=>"upload"));
}
function e($string){
	return htmlentities($string);
}
function get_footer ($array, $child = FALSE)
{
	$CI =& get_instance();
	$str = '';

	if (count($array)) {
		$str .='<ul >' . PHP_EOL;
		$j=1;
		foreach ($array as $item) {
			$str .='<li>';
			$str .= '<a href="' .  base_url().$item['slug'].'">' . e($item['title']) . '</a>';
			if(count($array)!=$j)
			$str.='<span class="sep">|</span>';
			$str .='</li>';
			$j=$j+1;
		}
		$str .= '</ul>' . PHP_EOL;
	}

	return $str;
}
function get_menu ($array,$children_parent_slug=FALSE, $child = FALSE)
{
	$CI =& get_instance();
	$str = '';

	if (count($array)) {
		$str .= $child == FALSE ? '<ul id="nav">' . PHP_EOL : '<ul >' . PHP_EOL;
		foreach ($array as $item) {
			$url="";
			if($item['slug']=="home")
			{
				$url= base_url();
			}
			else
			{
				$url= base_url().$item['slug'];
			}
			$active = $CI->uri->segment(1) == $item['slug'] ? TRUE : FALSE;
			if (isset($item['children']) && count($item['children'])) {
				$str .= $active ? '<li class="current"  >' : '<li >';
				$str .= '<a   href="' .  $url . '">' . e($item['title']);
				$str .= '</a>' . PHP_EOL;
				$str .= get_menu($item['children'],$item['children_parent_slug'], TRUE);
			}
			else {
				if($children_parent_slug!=FALSE)
				{
					$url= base_url().ucfirst(strtolower($children_parent_slug))."/".$item['slug'];
				}
				$str .= $active ? '<li class="current" >' : '<li >';
				$str .= '<a href="' . $url.'">' . e($item['title']) . '</a>';
			}
			$str .= '</li>' . PHP_EOL;
		}

		$str .= '</ul>' . PHP_EOL;
	}

	return $str;
}

function get_inner_menu ($array,$children_parent_slug=FALSE, $child = FALSE)
{

	$CI =& get_instance();
	$str = '';

	if (count($array)) {

		$str .= $child == FALSE ? '<ul id="nav" >' . PHP_EOL : '<ul  style="text-align:center">' . PHP_EOL;

		foreach ($array as $item) {
			$url="";
			if($item['slug']=="home")
			{
				$url= base_url();
			}
			else
			{
				$url= base_url().$item['slug'];
			}

			$active = $CI->uri->segment(1) == $item['slug'] ? TRUE : FALSE;
			if (isset($item['children']) && count($item['children'])) {

				$str .= $active ? '<li class="current"  >' : '<li  >';
				$str .= '<a   href="' . $url . '">' . e($item['title']);//removed on 2jul class="dropdown-toggle" data-toggle="dropdown"
				$str .= '</a>' . PHP_EOL;
				$str .= get_inner_menu($item['children'],$item['children_parent_slug'], TRUE);
			}
			else {
				if($children_parent_slug!=FALSE)
				{
					$CI->uri->segment(1) ? $url= base_url().  ucfirst(strtolower($children_parent_slug))."/".$item['slug']:$url= base_url().$item['slug'];
				}
				$str .= $active ? '<li class="current" >' : '<li >';
				$str .= '<a href="' . $url. '">' . e($item['title']) . '</a>';
			}
			$str .= '</li>' . PHP_EOL;
		}

		$str .= '</ul>' . PHP_EOL;
	}

	return $str;
}
function get_sidebar_links($sidebarpages){
	$string = '<ul class="bullet">';
	foreach ($sidebarpages as $item) {
		$string .= '<li >';
		$string .= '<a href="' .base_url() ."Projects/".  $item['parent']."/".$item['slug'] . '">' . e($item['title']) .  ' ›</a>';
		$string .= '</li>';
	}
	$string .= '</ul>';
	return $string;
}
/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
	function dump ($var, $label = 'Dump', $echo = TRUE)
	{
		// Store dump in variable
		ob_start();
		var_dump($var);
		$output = ob_get_clean();

		// Add formatting
		$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
		$output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

		// Output
		if ($echo == TRUE) {
			echo $output;
		}
		else {
			return $output;
		}
	}
}
if (!function_exists('dump_exit')) {
	function dump_exit($var, $label = 'Dump', $echo = TRUE) {
		dump ($var, $label, $echo);
		exit;
	}
}
?>