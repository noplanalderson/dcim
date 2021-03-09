<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_device extends MY_App
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
		$this->load->model('add_device_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$this->access_control->check_role();

		$data['dev_groups'] 	= $this->add_device_m->get_dev_groups();
		$data['manufactures'] 	= $this->add_device_m->get_manufactures();

		$view = array(
			'add-device/header',
			'_templates/sidebar',
			'_templates/topbar',
			'add-device/index',
			'add-device/footer' 
		);

		MY_App::view($view, $data);
	}

	private function _is_submited()
	{
		if( ! isset($_POST['submit'])) {
			$this->_form_msg[] = 'Please Fill the Form.';
			$this->_form_msg('form_error', $this->_form_msg);
			redirect('add-device');
		}
	}

	public function add()
	{
		$this->_is_submited();

		$this->_rules();

		$post = $this->input->post(null, TRUE);
		$this->_form_data = $post;
		
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
				$filename = 'noimage.png';
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

			if($this->add_device_m->check_device($post['device_group'], $post['device_number']) == 0)
			{
				if($this->add_device_m->add_device($device, $identity) == true)
				{
					$this->_form_msg('success', 'Device Added');
					redirect('devices');
				}
				else
				{
					$this->_form_msg[] = 'Failed to Add Device';
				}
			}
			else
			{
				$this->_form_msg[] = 'Device Exist.';
			}
			// var_dump(array_merge($device, $identity));
		}
		else
		{
			$this->_form_msg[] = validation_errors();
		}

		$this->_form_value($this->_form_data);
		$this->_form_msg('form_error', $this->_form_msg);
		redirect('add-device');
	}

	private function _rules()
	{
		$config = array(
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
			)
		);
		$this->form_validation->set_rules($config);
	}
}

/* End of file add_device.php */
/* Location: ./application/controllers/add_device.php */