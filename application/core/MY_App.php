<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_App extends CI_Controller
{
	protected $alert;

	public $app = array();

	public $menu_group = array();

	public $menus = array();

	public $notif = array();

	public $count_notif = 0;

	public $user = array();

	public function __construct()
	{
		parent::__construct();
		$CI =& get_instance();

		$CI->load->model('app_m');
		$CI->load->model('signin_m');
		$CI->load->model('notification_m');
		$CI->load->model('sidebar_m');

		$config['uid'] = $this->session->userdata('uid');
		$config['gid'] = $this->session->userdata('gid');
		$config['menu']= $this->uri->segment(1);
		$config['submenu'] = $this->uri->segment(2);
		$config['param'] = $this->uri->segment(3);
		$this->load->library('access_control', $config);

		$this->app = $this->app_m->get_settings();
		$this->user= $this->signin_m->user_info();
		$this->notif = $this->notification_m->get_notifications(6);
		$this->count_notif = $this->notification_m->count();
		$this->menu_group = $this->sidebar_m->menu_group();
	}

	protected static function view($view = [], $data = [])
	{
		$CI =& get_instance();
		$data['searchable'] = $CI->role_m->check_button('search/term');

		for ($i = 0; $i < count($view); $i++) 
		{
			$CI->load->view($view[$i], $data);
		}
	}

	protected function _form_msg($index, $msg)
	{
		$this->session->set_flashdata($index, $msg);
	}

	protected function _form_value($form_value = array())
	{
		foreach ($form_value as $key => $value) 
		{
			$this->session->set_flashdata($key, $value);
		}
	}
}

/* End of file my_Frontend.php */
/* Location: ./application/core/my_Frontend.php */