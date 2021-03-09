<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices extends MY_App
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
		$this->load->model('devices_m');
		$this->load->model('add_device_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$this->access_control->check_role();

		if(isset($_POST['group']))
		{
			$group = $this->input->post('group', TRUE);
			redirect('devices/group/'.$group, 'location', 303);
		}

		$data['dev_group'] 		= 'All Devices';
		$data['devices'] 		= $this->devices_m->get_devices();
		$data['groups']			= $this->devices_m->get_groups();
		$data['countdev']		= count($data['devices']);
		$data['btn_add'] 		= $this->role_m->get_button('add-device');
		$data['btn_edit'] 		= $this->role_m->get_button('devices/edit');
		$data['btn_delete'] 	= $this->role_m->get_button('devices/delete');
		$data['btn_timeline'] 	= $this->role_m->get_button('devices/timeline');

		$view = array(
			'devices/header',
			'_templates/sidebar',
			'_templates/topbar',
			'devices/index',
			'devices/footer'
		);

		MY_App::view($view, $data);
	}

	public function group($group = NULL)
	{
		$this->access_control->check_button();

		if(isset($_POST['group']))
		{
			$group = $this->input->post('group', TRUE);
			redirect('devices/group/'.$group, 'location', 303);
		}

		$data['dev_group'] 		= preg_replace("/[^a-zA-Z0-9\s]/", " ", $group);
		$data['devices'] 		= $this->devices_m->get_devices(ucwords($data['dev_group']));
		$data['groups']			= $this->devices_m->get_groups();
		$data['countdev']		= count($data['devices']);
		$data['btn_add'] 		= $this->role_m->get_button('add-device');
		$data['btn_edit'] 		= $this->role_m->get_button('devices/edit');
		$data['btn_delete'] 	= $this->role_m->get_button('devices/delete');
		$data['btn_timeline'] 	= $this->role_m->get_button('devices/timeline');

		$view = array(
			'devices/header',
			'_templates/sidebar',
			'_templates/topbar',
			'devices/index',
			'devices/footer'
		);

		MY_App::view($view, $data);
	}

	public function edit($id = NULL)
	{
		$this->access_control->check_button();

		if(empty($id) OR !decrypt($id)) show_404();

		if(isset($_POST['submit']))
		{
			$post = $this->input->post(null, TRUE);
			$this->_form_data = $post;
			
			$this->_rules();

			if ($this->form_validation->run() == TRUE) 
			{
				$device_code = dev_code_gen($post);

				$config['upload_path'] = './assets/wp-content/image/'.$post['device_group'].'/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '5200';
				$config['file_name'] = image_filename_gen($post['device_group'], $device_code);
				$config['detect_mime'] = TRUE;
				
				if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 755, true);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('device_image'))
				{
					$this->_form_msg[] = strip_tags($this->upload->display_errors());
					$filename = $post['old_device_image'];
				}
				else
				{
					$data = $this->upload->data();
					$filename = $post['device_group'].'/'.$data['file_name'];
				}

				$device = array(
					'device_code' => $device_code,
					'group_code' => $post['device_group'],
					'dev_manufacture_id' => $post['manufacture'],
					'dev_model_id' => $post['model'],
					'processor_type' => $post['processor_type'],
					'cores' => $post['cores'],
					'memory_model' => $post['memory_model'],
					'memory_cap' => $post['mem_cap'],
					'hdd_model' => $post['hdd_model'],
					'hdd_cap' => $post['hdd_cap'],
					'eth_port' => $post['eth_port'],
					'console_port' => $post['console_port'],
					'usb_port' => $post['usb_port']
				);

				$identity = array(
					'device_code' => $device_code,
					'serial_number' => strtoupper($post['serial_number']),
					'hostname' => empty($post['hostname']) ? 'localhost' : $post['hostname'],
					'operating_system' => $post['operating_system'],
					'os_architecture' => $post['os_arch'],
					'procurement' => $post['procurement'],
					'device_location' => $post['location'],
					'rack_number' => $post['rack'],
					'device_owner' => strtoupper($post['owner']),
					'device_status' => $post['status'],
					'device_picture' => $filename
				);

				if($this->devices_m->check_device($post['device_group'], $post['device_number'], $post['id']) == 0)
				{
					if($this->devices_m->edit_device($device, $identity, $post['id']) == true)
					{
						$this->_form_msg('success', 'Device Edited');
						redirect('devices');
					}
					else
					{
						$this->_form_msg[] = 'Failed to Edit Device';
					}
				}
				else
				{
					$this->_form_msg[] = 'Device Exist.';
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
			}

			$this->_form_value($this->_form_data);
			$this->_form_msg('form_error', $this->_form_msg);
			redirect('devices/edit/'.$post['id'], 'refresh');
		}

		$data['device']			= $this->devices_m->get_device_by_id($id);
		$data['dev_groups']		= $this->add_device_m->get_dev_groups();
		$data['manufactures'] 	= $this->add_device_m->get_manufactures();

		if(empty($data['device'])) show_404();

		$view = array(
			'devices/header-edit',
			'_templates/sidebar',
			'_templates/topbar',
			'devices/edit',
			'devices/footer-edit'
		);

		MY_App::view($view, $data);
	}

	public function detail($id = NULL)
	{
		$this->access_control->check_button();

		if(empty($id) OR !decrypt($id)) show_404();

		$data['device']	= $this->devices_m->get_device_by_id($id);

		if(empty($data['device'])) show_404();

		$view = array(
			'devices/header-detail',
			'_templates/sidebar',
			'_templates/topbar',
			'devices/detail',
			'devices/footer-detail'
		);

		MY_App::view($view, $data);
	}

	public function timeline($id = NULL)
	{
		$this->access_control->check_button();

		if(empty($id) OR !decrypt($id)) show_404();

		$data['device']		= $this->devices_m->get_device_by_id($id);
		$data['timelines']	= $this->devices_m->get_timeline($id);

		if(empty($data['device'])) show_404();

		$view = array(
			'timeline/header',
			'_templates/sidebar',
			'_templates/topbar',
			'timeline/index',
			'timeline/footer'
		);

		MY_App::view($view, $data);
	}

	public function delete($id = NULL)
	{
		$this->access_control->check_button();

		if(empty($id) OR !decrypt($id)) show_404();

		$image = $this->devices_m->get_image($id);
		$image_location = FCPATH.'/assets/wp-content/image/'.$image->device_picture;
		
		if(file_exists($image_location))
		{
			if($image->device_picture !== 'noimage.png') unlink($image_location);

			$config = array(
				'log_type' => 'device',
				'item' => $image->device_code,
				'pic' => $this->user['user_name'],
				'action' => 'deleted',
				'obj_link' => '#'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			if($this->devices_m->delete_device($id) == true)
			{
				$this->_form_msg('success', 'Device Deleted.');	
			}
			else
			{
				$this->_form_msg[] = 'Failed to Delete Device.';
			}
		}
		else
		{
			$this->_form_msg[] = 'Failed to Delete Device Image.';
		}

		$this->_form_msg('form_error', $this->_form_msg);
		redirect('devices');
	}

	private function _rules()
	{
		$config = array(
			array(
				'field' => 'id',
				'label' => 'ID',
				'rules' => 'trim|required|regex_match[/^[a-z0-9\-]+$/]',
				'errors'=> array(
					'required' => '{field} is required.',
					'regex_match' => '{field} not valid.'
				)
			),
			array(
				'field' => 'device_group',
				'label' => 'Device Group',
				'rules' => 'trim|required|alpha|min_length[1]|max_length[3]',
				'errors'=> array(
					'required' => '{field} is required.',
					'alpha' => '{field} should alphabet.',
					'min_length' => '{field} minimum lenght {param} character.',
					'max_length' => '{field} maximum lenght {param} characters.'
				)
			),
			array(
				'field' => 'device_number',
				'label' => 'Device Number',
				'rules' => 'trim|required|integer|max_length[3]',
				'errors'=> array(
					'required' => '{field} is required.',
					'integer' => '{field} should integer.',
					'max_length' => '{field} maximum length {param} characters.'
				)
			),
			array(
				'field' => 'manufacture',
				'label' => 'Manufacture',
				'rules' => 'required|integer',
				'errors'=> array('required' => '{field} is required.', 'integer' => '{field} should integer.')
			),
			array(
				'field' => 'model',
				'label' => 'Model',
				'rules' => 'required|integer',
				'errors'=> array('required' => '{field} is required.', 'integer' => '{field} should integer.')
			),
			array(
				'field' => 'processor_type',
				'label' => 'Processor Type',
				'rules' => 'trim|max_length[150]|regex_match[/^[a-zA-Z0-9 .@()\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [/^[a-zA-Z0-9 .@()\-]+$/].'
				)
			),
			array(
				'field' => 'cores',
				'label' => 'Cores',
				'rules' => 'numeric|max_length[3]',
				'errors'=> array(
					'numeric' => '{field} should numeric',
					'max_length' => '{field} maximum length is {param} characters.'
				)
			),
			array(
				'field' => 'memory_model',
				'label' => 'Memory Model',
				'rules' => 'max_length[100]|regex_match[/^[a-zA-Z0-9 .,\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9 .,\-]'
				)
			),
			array(
				'field' => 'mem_cap',
				'label' => 'Memory Capacity',
				'rules' => 'max_length[100]|regex_match[/^[0-9,]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [0-9,]'
				)
			),
			array(
				'field' => 'hdd_model',
				'label' => 'HDD Model',
				'rules' => 'max_length[100]|regex_match[/^[a-zA-Z0-9 .,\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9 .,\-]'
				)
			),
			array(
				'field' => 'hdd_cap',
				'label' => 'HDD Capacity',
				'rules' => 'max_length[100]|regex_match[/^[0-9,]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [0-9,]'
				)
			),
			array(
				'field' => 'eth_port',
				'label' => 'Ethernet',
				'rules' => 'numeric|max_length[3]',
				'errors'=> array(
					'numeric' => '{field} should numeric.',
					'max_length' => '{field} maximum length is {param} characters.'
				)
			),
			array(
				'field' => 'console_port',
				'label' => 'Console',
				'rules' => 'numeric|max_length[2]',
				'errors'=> array(
					'numeric' => '{field} should numeric.',
					'max_length' => '{field} maximum length is {param} characters.'
				)
			),
			array(
				'field' => 'usb_port',
				'label' => 'USB Port',
				'rules' => 'numeric|max_length[2]',
				'errors'=> array(
					'numeric' => '{field} should numeric.',
					'max_length' => '{field} maximum length is {param} characters.'
				)
			),
			array(
				'field' => 'hostname',
				'label' => 'Hostname',
				'rules' => 'trim|max_length[255]|regex_match[/^[a-zA-Z0-9_@\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9_@\-]'
				)
			),
			array(
				'field' => 'serial_number',
				'label' => 'Serial Number',
				'rules' => 'required|max_length[50]|regex_match[/^[a-zA-Z0-9:\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-ZA-Z0-9:\-]'
				)
			),
			array(
				'field' => 'operating_system',
				'label' => 'Operating System',
				'rules' => 'max_length[255]|regex_match[/^[a-zA-Z0-9 .()\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9 .()\-]'
				)
			),
			array(
				'field' => 'os_arch',
				'label' => 'OS Architecture',
				'rules' => 'max_length[255]|regex_match[/^[a-zA-Z0-9 .()\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9 .()\-]'
				)
			),
			array(
				'field' => 'procurement',
				'label' => 'Procurement',
				'rules' => 'required|max_length[4]|numeric',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'numeric'=> '{field} should numeric.'
				)
			),
			array(
				'field' => 'location',
				'label' => 'Device Location',
				'rules' => 'max_length[255]|regex_match[/^[a-zA-Z0-9 .\/()\-]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9 .\/()\-]'
				)
			),
			array(
				'field' => 'rack',
				'label' => 'Rack Number',
				'rules' => 'max_length[11]|numeric',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'numeric'=> '{field} should numeric.'
				)
			),
			array(
				'field' => 'owner',
				'label' => 'Device Owner',
				'rules' => 'max_length[255]|regex_match[/^[a-zA-Z0-9 ]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9 ]'
				)
			),
			array(
				'field' => 'status',
				'label' => 'Device Status',
				'rules' => 'regex_match[/^(active|broken|vacant)$/]',
				'errors'=> array(
					'regex_match'=> '{field} options should active|broken|vacant'
				)
			),
			array(
				'field' => 'old_device_image',
				'label' => 'Device Image',
				'rules' => 'max_length[255]|regex_match[/^[a-zA-Z0-9.\/\-_]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9.\/\-_]'
				)
			),
		);
		$this->form_validation->set_rules($config);
	}
}

/* End of file devices.php */
/* Location: ./application/controllers/devices.php */