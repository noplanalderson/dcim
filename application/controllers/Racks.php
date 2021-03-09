<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Racks extends MY_App
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('devices_m');

		$this->access_control->check_login();
	}

	private function get_rack($rack = NULL)
	{
		if(empty($rack)){ 
			$rack = NULL;
		}elseif(!empty($rack) && $rack == 'OUTSIDE-RACK'){
			$rack = 0;
		}else{
			$rack = $rack;
		}

		return $rack;
	}

	private function get_rack_title($rack = NULL)
	{
		if(empty($rack)){ 
			$rack = 'ALL RACKS';
		}elseif(!empty($rack) && $rack == 'OUTSIDE-RACK'){
			$rack = 'OUTSIDE RACK';
		}else{
			$rack = 'Rack '.$rack;
		}

		return $rack;
	}

	public function index($rack = NULL)
	{
		$this->access_control->check_role();

		if(isset($_POST['rack']))
		{
			$rack = $this->input->post('rack', TRUE);
			redirect('racks/number/'.$rack, 'location', 303);
		}

		$data['rack_title'] = $this->get_rack_title($rack);
		$data['rack'] 		= $this->get_rack($rack);
		$data['devices'] 	= $this->devices_m->get_devices_by_rack($data['rack']);
		$data['racks'] 		= $this->devices_m->get_racks();
		$data['count']		= count($data['devices']);
		$data['btn_timeline'] 	= $this->role_m->get_button('devices/timeline');

		$view = array(
			'racks/header',
			'_templates/sidebar',
			'_templates/topbar',
			'racks/index',
			'racks/footer'
		);

		MY_App::view($view, $data);
	}

	public function number($rack = NULL)
	{
		$this->access_control->check_button();

		if(isset($_POST['rack']))
		{
			$rack = $this->input->post('rack', TRUE);
			redirect('racks/number/'.$rack, 'location', 303);
		}

		$data['rack_title'] = $this->get_rack_title($rack);
		$data['rack'] 		= $this->get_rack($rack);
		$data['devices'] 	= $this->devices_m->get_devices_by_rack($data['rack']);
		$data['racks'] 		= $this->devices_m->get_racks();
		$data['count']		= count($data['devices']);
		$data['btn_timeline'] 	= $this->role_m->get_button('devices/timeline');

		$view = array(
			'racks/header',
			'_templates/sidebar',
			'_templates/topbar',
			'racks/index',
			'racks/footer'
		);

		MY_App::view($view, $data);
	}
}