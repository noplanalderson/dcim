<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function button($button = [], $mode = 'a', $link = '#', $class = NULL, $attr = NULL, $titled = false)
{
	if(!empty($button))
	{
		if($titled)
		{
			return '<'.$mode.' '.$class.' '.$attr.' href="'.$link.'"><i class="'.$button['menu_icon'].'"></i> '.$button['menu_label'].'</'.$mode.'>';
		}
		else
		{
			return '<'.$mode.' '.$class.' '.$attr.' href="'.$link.'"><i class="'.$button['menu_icon'].'"></i></'.$mode.'>';
		}
	}
	else
	{
		return false;
	}
}