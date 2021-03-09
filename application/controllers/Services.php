<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends MY_App
{
	/**
	 * [$_form_data submited data]
	 * @var array
	 */
	private $_form_data = array();

	/**
	 * [$form_msg form message]
	 * @var array
	 */
	private $_form_msg = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('role_m');
		$this->load->model('subnet_m');
		$this->load->model('services_m');
		$this->load->model('add_service_m');

		$this->access_control->check_login();
	}

	public function index($service = NULL, $param_1 = NULL, $param_2 = NULL)
	{
		if($service == 'subnet'){
			$this->access_control->check_button();
		}else{
			$this->access_control->check_role();
		}

		if( ! preg_match('/(apps|networks|wifi|subnet|vms)$/', $service)) show_404();

		$data['btn_edit'] 	= $this->role_m->get_button('services/edit');
		$data['btn_delete'] = $this->role_m->get_button('services/delete');

		switch ($service) {
			case 'apps':
				
				$data['title']	= 'Applications';
				$data['apps'] 	= $this->services_m->get_apps();				
				$data['btn_add']= $this->role_m->get_button('add-service/app');

				$prefix_view 	= 'app_';
				break;
			
			case 'networks':
				
				$data['title']		= 'Networks';
				$data['networks'] 	= $this->services_m->get_networks();
				$data['btn_add'] 	= $this->role_m->get_button('add-service/network');
				$data['btn_subnet'] = $this->role_m->get_button('add-service/subnet');
				$data['btn_read'] 	= $this->role_m->get_button('services/subnet');

				$prefix_view 		= 'network_';
				
				break;

			case 'wifi':
				
				$data['title']	= 'Wifi';
				$data['wifis'] 	= $this->services_m->get_wifis();
				$data['btn_add']= $this->role_m->get_button('add-service/wifi');

				$prefix_view 	= 'wifi_';
				
				break;

			case 'vms':
				
				$data['title']	= 'VMs';
				$data['vms'] 	= $this->services_m->get_vms();
				$data['btn_add']= $this->role_m->get_button('add-service/vm');

				$prefix_view 	= 'vm_';
				
				break;

			case 'subnet':
				
				if( ! empty($param_1) && ! empty($param_2))
				{
					if( ! preg_match('/(PRIVATE|PUBLIC)$/', $param_1)) show_404();
					if( ! decrypt($param_2)) show_404();
				}

				$data['title']		= 'Subnet';
				$data['net_type']	= $param_1;
				$data['network_id'] = $param_2;
				$data['subnets'] 	= $this->services_m->get_ips($param_1, $param_2);
				$data['devices'] 	= $this->add_service_m->get_devices();
				$data['wifis'] 		= $this->subnet_m->get_wifis();
				$data['apps'] 		= $this->subnet_m->get_apps();
				$data['vms'] 		= $this->services_m->get_vms();
				$data['btn_add'] 	= $this->role_m->get_button('add-service/subnet');
				$data['btn_action'] = $this->role_m->get_button('services/action');

				$prefix_view 		= 'subnet_';
				
				break;

			default:
				show_404();
				break;
		}

		$view = array(
			'services/header',
			'_templates/sidebar',
			'_templates/topbar',
			'services/'.$prefix_view.'index',
			'services/footer',
			'services/'.$prefix_view.'js'
		);

		MY_App::view($view, $data);
	}

	public function edit($service = NULL, $param = NULL)
	{
		$this->access_control->check_button();

		if( ! preg_match('/(app|network|wifi|subnet|vm)$/', $service)) show_404();
		if( ! decrypt($param)) show_404();

		switch ($service) {
			case 'app':
				
				if(isset($_POST['submit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('url', 'App Address', 'trim|required|valid_url');
					$this->form_validation->set_rules('notes', 'Notes', 'trim|required|regex_match[/^[a-zA-Z0-9 _,.&@!:\/\-]+$/]|max_length[512]');

					if ($this->form_validation->run() == TRUE) 
					{
						if($this->services_m->check_item('tb_application', 'app_address', 'app_id',  $this->_form_data['url'], $param) == 0)
						{
							if($this->services_m->edit_app($param, $this->_form_data) == true)
							{
								$this->_form_msg = 'Web/Apps Edited.';
								$this->_form_msg('success', $this->_form_msg);
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Web/Apps.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Web/Apps Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}

					$this->_form_value($this->_form_data);
					redirect('services/apps');
				}

				$data['title']	= 'Edit Apps';
				$data['app'] 	= $this->services_m->get_apps_by_id($param);
				$prefix_view 	= 'app_';
				if(empty($data['app'])) show_404();
			break;
			
			case 'network':
				
				if(isset($_POST['submit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);
					
					$this->form_validation->set_rules('network_type', 'Net. Type', 'required|regex_match[/^(PRIVATE|PUBLIC)$/]');
					$this->form_validation->set_rules('mask', 'Netmask', 'required|integer|greater_than_equal_to[24]|less_than_equal_to[30]');
					$this->form_validation->set_rules('submask', 'Submask', 'required|integer|greater_than_equal_to[24]|less_than_equal_to[30]');
					$this->form_validation->set_rules('a', 'Block A', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('b', 'Block B', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('c', 'Block C', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('d', 'Block D', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('network_label', 'Network Label', 'trim|regex_match[/^[a-zA-Z0-9 _.,+=&!@#?\/\-]+$/]|max_length[100]');

					if ($this->form_validation->run() == TRUE) 
					{
						$network = $this->_form_data['a'].'.'.$this->_form_data['b'].'.'.$this->_form_data['c'].'.'.$this->_form_data['d'].'/'.$this->_form_data['mask'];

						if($this->services_m->check_item('tb_network', 'network_block', 'network_id',  $network, $param) == 0)
						{
							$this->services_m->check_network_change($param, $network);

							if($this->services_m->edit_network($param, $network, $this->_form_data) == true)
							{
								$this->_form_msg = 'Network Edited.';
								$this->_form_msg('success', $this->_form_msg);
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Network.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Network Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}

					$this->_form_value($this->_form_data);
					redirect('services/networks');
				}

				$data['title']		= 'Edit Network';
				$data['network'] 	= $this->services_m->get_network_by_id($param);
				$data['net'] 		= explode('.', $data['network']['network_block']);
				$data['host'] 		= explode('/', $data['net'][3]);
				$prefix_view 		= 'network_';
				if(empty($data['network'])) show_404();
				
			break;

			case 'wifi':

				if(isset($_POST['submit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);
					
					$this->form_validation->set_rules('wifi_ssid', 'Wifi SSID', 'trim|required|regex_match[/^[a-zA-Z0-9 _,.@\-]+$/]');
					$this->form_validation->set_rules('wifi_user', 'Wifi User', 'trim|regex_match[/^[a-zA-Z0-9 _!@]+$/]|max_length[100]');
					$this->form_validation->set_rules('wifi_password', 'Wifi Password', 'trim|regex_match[/^[a-zA-Z0-9 _.,+=&!@#?\/\-]+$/]|max_length[100]');

					if ($this->form_validation->run() == TRUE) 
					{
						if($this->services_m->check_item('tb_wifi', 'wifi_ssid', 'wifi_id',  $this->_form_data['wifi_ssid'], $param) == 0)
						{
							if($this->services_m->edit_wifi($param, $this->_form_data) == true)
							{
								$this->_form_msg = 'Wifi Edited.';
								$this->_form_msg('success', $this->_form_msg);
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Wifi.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Wifi Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}

					$this->_form_value($this->_form_data);
					redirect('services/wifi');
				}

				$data['title']	= 'Wifi';
				$data['wifi'] 	= $this->services_m->get_wifi_by_id($param);
				$prefix_view 	= 'wifi_';
				if(empty($data['wifi'])) show_404();
				
			break;

			case 'vm':
				if(isset($_POST['submit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);
					
					$this->form_validation->set_rules('device', 'Device', 'required|regex_match[/^[A-Z0-9.]+$/]');
					$this->form_validation->set_rules('hostname', 'Hostname', 'trim|max_length[255]|regex_match[/^[a-zA-Z0-9_@\-]+$/]');
					$this->form_validation->set_rules('operating_system', 'Operating System', 'max_length[255]|regex_match[/^[a-zA-Z0-9 .()\-]+$/]');
					$this->form_validation->set_rules('os_arch', 'OS Architecture', 'max_length[255]|regex_match[/^[a-zA-Z0-9 .()\-_]+$/]');
					$this->form_validation->set_rules('cores', 'Cores', 'numeric|max_length[3]');
					$this->form_validation->set_rules('mem_cap', 'Memory Capacity', 'numeric|max_length[4]');
					$this->form_validation->set_rules('hdd_cap', 'Storage Capacity', 'numeric|max_length[5]');
					$this->form_validation->set_rules('notes', 'Notes', 'trim|regex_match[/^[a-zA-Z0-9 _.,+=&!@#?\/\-]+$/]|max_length[255]');


					if ($this->form_validation->run() == TRUE) 
					{
						if($this->services_m->check_item('tb_vm', 'hostname', 'vm_id',  $this->_form_data['hostname'], $param) == 0)
						{
							if($this->services_m->edit_vm($param, $this->_form_data) == true)
							{
								$this->_form_msg = 'VM Edited.';
								$this->_form_msg('success', $this->_form_msg);
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit VM.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'VM Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}

					$this->_form_value($this->_form_data);
					redirect('services/vms');
				}

				$data['title']	= 'Edit VM';
				$data['devices']= $this->add_service_m->get_devices();
				$data['vm'] 	= $this->services_m->get_vm_by_id($param);
				$prefix_view 	= 'vm_';
				if(empty($data['vm'])) show_404();
				
			break;

			case 'subnet':

				if(isset($_POST['submit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);
					
					$this->form_validation->set_rules('id', 'ID Network', 'required|integer');
					$this->form_validation->set_rules('subnet_id', 'ID Subnet', 'required|integer');
					$this->form_validation->set_rules('type', 'Network Type', 'required|regex_match[/(PRIVATE|PUBLIC)$/]');
					$this->form_validation->set_rules('netmask', 'Netmask', 'required|integer|greater_than_equal_to[24]|less_than_equal_to[30]');
					$this->form_validation->set_rules('a', 'Block A', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('b', 'Block B', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('c', 'Block C', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('d', 'Block D', 'required|integer|less_than_equal_to[254]');
					$this->form_validation->set_rules('vlan', 'VLAN ID', 'required|integer|max_length[4]');
					$this->form_validation->set_rules('label', 'Subnet Label', 'trim|regex_match[/^[a-zA-Z0-9 _.,+=&!@#?\/\-]+$/]|max_length[100]');


					if ($this->form_validation->run() == TRUE) 
					{
						$subnetwork = $this->_form_data['a'].'.'.$this->_form_data['b'].'.'.$this->_form_data['c'].'.'.$this->_form_data['d'].'/'.$this->_form_data['netmask'];

						if($this->services_m->check_item('tb_subnet', 'ip_subnet', 'subnet_id',  $subnetwork, $param) == 0)
						{
							if($this->services_m->edit_subnet($param, $subnetwork, $this->_form_data) == true)
							{
								$this->_form_msg = 'Sub Network Edited.';
								$this->_form_msg('success', $this->_form_msg);
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Sub Network.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Sub Network Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}

					$this->_form_value($this->_form_data);
					redirect('services/subnet/'.$this->_form_data['type'].'/'.encrypt($this->_form_data['id']));
				}

				$data['network']	= $this->services_m->get_network_by_subnet($param);
				$data['title']		= 'Subnet';
				$data['subnet'] 	= $this->services_m->get_subnet($param);
				$explode_subnet 	= explode('.', $data['subnet']['ip_subnet']);
				$data['host'] 		= explode('/', $explode_subnet[3]);
				$prefix_view 		= 'subnet_';
		
				if(empty($data['network'])) show_404();

				$data['exp_network']= explode('.', $data['network']['network_block']);
				
			break;

			default:
				show_404();
			break;
		}

		$view = array(
			'services/header',
			'_templates/sidebar',
			'_templates/topbar',
			'services/'.$prefix_view.'update',
			'services/'.$prefix_view.'update_footer'
		);

		MY_App::view($view, $data);
	}

	public function action($action = NULL, $type = NULL, $id = NULL)
	{
		switch ($action) 
		{
			case 'add':
				$this->form_validation->set_rules('network_type', 'Network Type', 'required|regex_match[/(PRIVATE|PUBLIC)$/]');
				$this->form_validation->set_rules('device_code', 'Device', 'regex_match[/^[A-Z0-9.]+$/]');
				$this->form_validation->set_rules('id_ip', 'ID IP', 'required|regex_match[/^[a-zA-Z0-9\/\-]+$/]');
				$this->form_validation->set_rules('network_id', 'ID Network', 'required|regex_match[/^[a-z0-9\-]+$/]');

				$this->_form_data = $this->input->post(null, TRUE);
				
				if ($this->form_validation->run() == TRUE)
				{
					if($this->services_m->use_ip($this->_form_data) == true)
					{
						$this->_form_msg = 'IP Address Used.';
						$this->_form_msg('success', $this->_form_msg);
					}
					else
					{
						$this->_form_msg[] = 'Failed to using IP Address.';
						$this->_form_msg('form_error', $this->_form_msg);
					}

				} else {
					$this->_form_msg[] = 'Failed to using IP Address.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
				
				redirect('services/subnet/'.$this->_form_data['network_type'].'/'.$this->_form_data['network_id']);
			break;

			case 'block':
				if(!empty($type) && !preg_match('/(PRIVATE|PUBLIC)$/', $type)) show_404();
				if(!empty($id) && !decrypt($id)) show_404();

				if($this->services_m->block_ip($type, $id) == true)
				{
					$this->_form_msg = 'IP Address Blocked.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to blocking IP Address.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
				
				$id_network = $this->services_m->get_network_by_ip($type, $id);
				redirect('services/subnet/'.$type.'/'.encrypt($id_network));
			break;
			
			case 'allow':
				if(!empty($type) && !preg_match('/(PRIVATE|PUBLIC)$/', $type)) show_404();
				if(!empty($id) && !decrypt($id)) show_404();

				if($this->services_m->allow_ip($type, $id) == true)
				{
					$this->_form_msg = 'IP Address Allowed.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to allowing IP Address.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
				
				$id_network = $this->services_m->get_network_by_ip($type, $id);
				redirect('services/subnet/'.$type.'/'.encrypt($id_network));
			break;

			default:
				show_404();
				break;
		}
	}

	public function delete($type = NULL, $id = NULL)
	{
		$this->access_control->check_button();

		switch ($type) 
		{
			case 'app':
				$result = $this->services_m->delete_app($id);
				$msg_success = 'Application Deleted.';
				$msg_error = 'Failed to Delete Application.';
				$redirect = 'services/apps';
				break;
			
			case 'wifi':
				$result = $this->services_m->delete_wifi($id);
				$msg_success = 'Wifi Deleted.';
				$msg_error = 'Failed to Delete Wifi.';
				$redirect = 'services/wifi';
				break;

			case 'network':
				$result = $this->services_m->delete_network($id);
				$msg_success = 'Network Deleted.';
				$msg_error = 'Failed to Delete Network.';
				$redirect = 'services/networks';
				break;

			case 'subnet':
				$subnet = $this->services_m->delete_subnet($id);
				$result = $subnet['result'];
				$msg_success = 'Subnet Deleted.';
				$msg_error = 'Failed to Delete Subnet.';
				$redirect = 'services/subnet/'.$subnet['type'].'/'.encrypt($subnet['network_id']);
				break;

			case 'vm':
				$result = $this->services_m->delete_vm($id);
				$msg_success = 'VM Deleted.';
				$msg_error = 'Failed to Delete VM.';
				$redirect = 'services/vms';
				break;
			default:
				show_404();
				break;
		}

		if($result == true)
		{
			$this->_form_msg = $msg_success;
			$this->_form_msg('success', $this->_form_msg);
		}
		else
		{
			$this->_form_msg[] = $msg_error;
			$this->_form_msg('form_error', $this->_form_msg);
		}

		redirect($redirect);
	}
}

/* End of file service.php */
/* Location: ./application/controllers/service.php */