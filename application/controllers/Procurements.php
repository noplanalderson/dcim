<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurements extends MY_App
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('devices_m');
		$this->load->model('hardwares_m');

		$this->access_control->check_login();
	}

	public function devices($year = NULL)
	{
		$this->access_control->check_role();

		if(isset($_POST['year']))
		{
			$year = $this->input->post('year', TRUE);
			redirect('procurements/devices/'.$year, 'location', 303);
		}

		$data['year'] 		= empty($year) ? 'All Year' : $year;
		$data['devices'] 	= $this->devices_m->get_devices_by_year($year);
		$data['years'] 		= $this->devices_m->get_years();
		$data['count']		= count($data['devices']);
		$data['btn_timeline'] 	= $this->role_m->get_button('devices/timeline');

		$view = array(
			'procurements/header',
			'_templates/sidebar',
			'_templates/topbar',
			'procurements/device',
			'procurements/footer-device'
		);

		MY_App::view($view, $data);
	}

	public function hardwares($year = NULL)
	{
		$this->access_control->check_role();

		if(isset($_POST['year']))
		{
			$year = $this->input->post('year', TRUE);
			redirect('procurements/hardwares/'.$year, 'location', 303);
		}

		$data['year'] 		= empty($year) ? 'All Year' : $year;
		$data['hardwares'] 	= $this->hardwares_m->get_hardwares_by_year($year);
		$data['years'] 		= $this->hardwares_m->get_years();
		$data['count']		= count($data['hardwares']);


		$view = array(
			'procurements/header',
			'_templates/sidebar',
			'_templates/topbar',
			'procurements/hardware',
			'procurements/footer-hardware'
		);

		MY_App::view($view, $data);
	}
}