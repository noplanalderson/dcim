<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signout extends MY_App 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('signout_m');
	}

	public function index()
	{
		$this->signout_m->signout();
		$params = array('uid', 'gid', 'time');
		$this->session->unset_userdata($params);
		redirect('signin');
	}

}

/* End of file logout.php */
/* Location: ./application/controllers/logout.php */