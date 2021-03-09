<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_App
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('notification_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$data['all'] = $this->notification_m->get_notifications();
		$this->notification_m->fetch();
		
		$view = array(
			'notification/header',
			'_templates/sidebar',
			'_templates/topbar',
			'notification/index',
			'notification/footer'
		);
		
		MY_App::view($view, $data);
	}

	public function fetch()
	{
		if(isset($_POST['see'])) 
		{
			$this->notification_m->fetch(6);
			$count = $this->notification_m->count();

			echo json_encode(array('result' => 1, 'count' => $count));
		}
		else
		{
			echo json_encode(array('result' => 0, 'count' => $this->count_notif));
		}
	}
}

/* End of file notification.php */
/* Location: ./application/controllers/notification.php */