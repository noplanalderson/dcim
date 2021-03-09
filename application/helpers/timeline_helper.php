<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function timeline($data = array())
{
	$CI =& get_instance();
	$CI->db->insert('tb_timeline', $data);
}