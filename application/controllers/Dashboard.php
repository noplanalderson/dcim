<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_App 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('signin_m');
		$this->load->model('dashboard_m');
		$this->load->model('isp_m');

		$this->access_control->check_login();
		$this->access_control->check_role();
	}

	public function index()
	{
		$data['total_dev'] 	= $this->dashboard_m->count_device();
		$data['app'] 		= $this->dashboard_m->count_apps();
		$data['wifi'] 		= $this->dashboard_m->count_wifi();
		$data['net'] 		= $this->dashboard_m->count_network();
		$data['vm'] 		= $this->dashboard_m->count_vm();
		$data['hardware'] 	= $this->dashboard_m->count_hardware();
		$data['log_device'] = $this->dashboard_m->get_log_device();
		$data['log_sla'] 	= $this->dashboard_m->get_log_sla();
		$data['isp_list']	= $this->isp_m->get_isp();
		$data['periods']	= $this->dashboard_m->get_period();

		// Badges Privilege
		$data['device_bg']	= $this->role_m->get_button('devices/group');
		$data['hardware_bg']	= $this->role_m->get_button('hardwares/group');
		$data['app_bg']		= $this->role_m->get_button('services/apps');
		$data['wifi_bg']	= $this->role_m->get_button('services/wifis');
		$data['vm_bg']		= $this->role_m->get_button('services/vms');
		$data['network_bg']	= $this->role_m->get_button('services/networks');

 		$view = array(
			'dashboard/header',
			'_templates/sidebar',
			'_templates/topbar',
			'dashboard/index',
			'dashboard/footer'
		);

		MY_App::view($view, $data);
	}

	// public function network()
	// {
	// 	$subnet = $this->dashboard_m->get_subnet();
	// 	foreach ($subnet as $sub) 
	// 	{
	// 		$netmask = explode('/', $sub['ip_subnet']);
	// 		echo '<p>'.$sub['network_type'].' | '. $sub['subnet_id'] .' | '.$sub['ip_subnet'].' | '. $sub['minip'].'<p>';
	// 		$ip_count = 1 << (32 - $netmask[1]);

	// 			$start = ip2long($sub['minip']);
					
	// 			for ($i = 1; $i < ($ip_count - 1); $i++)
	// 			{
	// 				$ip = long2ip($start + $i);
	// 				$this->dashboard_m->add_ips($sub['network_type'], $sub['subnet_id'], $ip);
	// 			}
	// 	}
	// }
}
