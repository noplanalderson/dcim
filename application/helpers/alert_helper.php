<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function alert($type, $msg)
{
	echo '<div class="alert alert-'. $type .' fadeIn" role="alert">
				'. $msg .'
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
			</div>';
}

function show_alert()
{
	$CI =& get_instance();
	$success = $CI->session->flashdata('success');
	$errors = $CI->session->flashdata('form_error');

	// switch ($type)
	// {
	// 	case 'success':
	if(!empty($success)) alert('success', $success);
		// break;
		
		// default:
	if( ! empty($errors))
	{
		foreach ($errors as $error) {
			alert('danger', $error);
		}
	}
	// 	break;
	// }
}

function show_value($name)
{
	$CI =& get_instance();
	return $CI->session->flashdata($name);
}