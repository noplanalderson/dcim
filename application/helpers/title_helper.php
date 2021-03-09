<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_title_by_uri()
{
	$CI =& get_instance();

	if(!empty($CI->uri->segment(3)) && $CI->uri->segment(3) !== '')
	{
		$title = $CI->uri->segment(3);
	}
	elseif(!empty($CI->uri->segment(2)) && empty($CI->uri->segment(3)))
	{
		$title = $CI->uri->segment(2);
	}
	else
	{
		$title = $CI->uri->segment(1);
	}

	$title = preg_replace("/[^\da-z]/i", " ", $title);
	return ucwords($title);
}