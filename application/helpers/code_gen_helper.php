<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function dev_code_gen(array $data = array())
{
	$manufacture= sprintf("%03d", $data['manufacture']);
	$model		= sprintf("%03d", $data['model']);
	$procurement= substr($data['procurement'], 2);

	return $data['device_number'] . '.' . $manufacture . '.' . $procurement;
}

function hw_code_gen(array $data = array())
{
	$manufacture= sprintf("%03d", $data['manufacture']);
	$procurement= substr($data['procurement'], 2);

	return $data['hw_number'] . '.' . $manufacture . '.' . $procurement;
}

function image_filename_gen($group = 'UC', $device_code = '')
{
	$CI =& get_instance();
	$device_code = str_replace('.', '', $device_code);

	$filename = $group.$device_code . '_mrn' . random_string('alnum',8) . 'd1y4h' . random_string('nozero',4) . '_'. $CI->session->userdata('uid') . '_' . date('Ymdhis') . '_' . random_string('numeric',9).random_string('alpha',6);
	return $filename;
}

function generate_number($table, $column, $code)
{
	$CI =& get_instance();
	$CI->db->select($column);
	$CI->db->where($column, $code);
	return $CI->db->get($table)->num_rows() + 1;
}