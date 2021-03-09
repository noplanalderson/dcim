<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_service extends MY_App
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
		$this->load->model('subnet_m');
		$this->load->model('add_service_m');

		$this->access_control->check_login();
	}

	public function private_ip()
	{
		echo json_encode($this->add_service_m->get_ip_private());
	}

	public function public_ip()
	{
		echo json_encode($this->add_service_m->get_ip_public());
	}
	
	public function app()
	{
		$this->access_control->check_role();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('url', 'App Address', 'trim|required|valid_url|is_unique[tb_application.app_address]');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|required|regex_match[/^[a-zA-Z0-9 _,.&@!:\/\-]+$/]|max_length[512]');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->add_service_m->add_apps($this->_form_data) == true)
				{
					$this->_form_msg = 'Web/Apps Added';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to add Web/Apps';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('add-service/app','refresh');
		}

		$view = array(
			'add-apps/header',
			'_templates/sidebar',
			'_templates/topbar',
			'add-apps/index',
			'add-apps/footer'
		);

		MY_App::view($view);
	}

	public function wifi()
	{
		$this->access_control->check_role();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('wifi_ssid', 'Wifi SSID', 'trim|required|regex_match[/^[a-zA-Z0-9 _,.@\-]+$/]');
			$this->form_validation->set_rules('wifi_user', 'Wifi User', 'trim|regex_match[/^[a-zA-Z0-9 _!@]+$/]|max_length[100]');
			$this->form_validation->set_rules('wifi_password', 'Wifi Password', 'trim|regex_match[/^[a-zA-Z0-9 _.,+=&!@#?\/\-]+$/]|max_length[100]');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->add_service_m->add_wifi($this->_form_data) == true)
				{
					$this->_form_msg = 'Wifi Added';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to add Wifi';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('add-service/wifi','refresh');
		}

		$view = array(
			'add-wifi/header',
			'_templates/sidebar',
			'_templates/topbar',
			'add-wifi/index',
			'add-wifi/footer'
		);

		MY_App::view($view);
	}

	public function network()
	{
		$this->access_control->check_role();

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
				if($this->add_service_m->add_network($this->_form_data) == true)
				{
					$this->_form_msg = 'Network Added.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to add Network or Network Exist.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('add-service/network','refresh');
		}

		$view = array(
			'add-network/header',
			'_templates/sidebar',
			'_templates/topbar',
			'add-network/index',
			'add-network/footer'
		);

		MY_App::view($view);
	}

	public function vm()
	{
		$this->access_control->check_role();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('device', 'Device', 'required|regex_match[/^[A-Z0-9.]+$/]');
			$this->form_validation->set_rules('hostname', 'Hostname', 'trim|max_length[255]|regex_match[/^[a-zA-Z0-9_@\-]+$/]');
			$this->form_validation->set_rules('operating_system', 'Operating System', 'max_length[255]|regex_match[/^[a-zA-Z0-9 .()\-]+$/]');
			$this->form_validation->set_rules('os_arch', 'OS Architecture', 'max_length[255]|regex_match[/^[a-zA-Z0-9 .()\-]+$/]');
			$this->form_validation->set_rules('cores', 'Cores', 'numeric|max_length[3]');
			$this->form_validation->set_rules('mem_cap', 'Memory Capacity', 'numeric|max_length[4]');
			$this->form_validation->set_rules('hdd_cap', 'Storage Capacity', 'numeric|max_length[5]');
			$this->form_validation->set_rules('notes', 'Notes', 'trim|regex_match[/^[a-zA-Z0-9 _.,+=&!@#?\/\-]+$/]|max_length[255]');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->add_service_m->add_vm($this->_form_data) == true)
				{
					$this->_form_msg = 'VM Added.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to add VM or VM Exist.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('add-service/vm','refresh');
		}

		$data['devices'] = $this->add_service_m->get_devices();

		$view = array(
			'add-vm/header',
			'_templates/sidebar',
			'_templates/topbar',
			'add-vm/index',
			'add-vm/footer'
		);

		MY_App::view($view, $data);
	}

	public function subnet($network_id = NULL)
	{
		$this->access_control->check_button();

		if( ! decrypt($network_id)) show_404();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);

			$this->form_validation->set_rules('id', 'ID Network', 'required|integer');
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
				if($this->add_service_m->add_subnet($this->_form_data) == true)
				{
					$this->_form_msg = 'Subnet Added.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to add Subnet or Subnet Exist.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('add-service/subnet/'.$network_id, 'refresh');
		}

		$data['title'] 		= 'Add Subnet';
		$data['network']	= $this->add_service_m->get_network_by_id($network_id);
		
		if(empty($data['network'])) show_404();

		$data['exp_network']= explode('.', $data['network']['network_block']);

		$view = array(
			'services/header',
			'_templates/sidebar',
			'_templates/topbar',
			'services/subnet_tambah',
			'services/footer',
			'services/subnet_js'
		);

		MY_App::view($view, $data);
	}

	public function use()
	{
		$post = $this->input->post(null, TRUE);
		
		if( ! isset($post['id'])) :
			return false;
		else :
			$explode= explode('/', $post['id']);
			$data 	= $this->subnet_m->get_svc_by_id($explode[0], $explode[1]);
			echo json_encode($data);
		endif;
	}
}

/* End of file add_service.php */
/* Location: ./application/controllers/add_service.php */