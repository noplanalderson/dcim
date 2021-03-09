<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_hardware extends MY_App
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
		$this->load->model('add_hardware_m');

		$this->access_control->check_login();
	}

	private function _is_submited()
	{
		if( ! isset($_POST['submit'])) {
			$this->_form_msg[] = 'Please Fill the Form.';
			$this->_form_msg('form_error', $this->_form_msg);
			redirect('add-hardware');
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
			$hw_code = hw_code_gen($post);

			$config['upload_path'] = './assets/wp-content/image/'.$post['category'].'/';
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max_size']  = '5200';
			$config['file_name'] = image_filename_gen($post['category'], $hw_code);
			$config['detect_mime'] = TRUE;
			
			if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 755, true);

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('hw_picture'))
			{
				$this->_form_msg[] = strip_tags($this->upload->display_errors());
				$filename = 'noimage.png';
			}
			else
			{
				$data = $this->upload->data();
				$filename = $post['category'].'/'.$data['file_name'];
			}

			$hardware = array(
				'hw_code' => $hw_code,
				'category_code' => $post['category'],
				'hw_manufacture_id' => $post['manufacture'],
				'hw_model' => $post['model'],
				'capacity' => $post['capacity'],
				'capacity_unit' => $post['capacity_unit'],
				'hw_quantity' => $post['quantity'],
				'procurement' => $post['procurement'],
				'notes' => $post['notes'],
				'hw_status' => $post['status'],
				'hw_picture' => $filename
			);
			
			if($this->add_hardware_m->check_hw($post['category'], $post['hw_number']) == 0)
			{
				if($this->add_hardware_m->add_hardware($hardware) == true)
				{
					$this->_form_msg('success', 'Hardware Added');
				}
				else
				{
					$this->_form_msg[] = 'Failed to Add Hardware';
				}
			}
			else
			{
				$this->_form_msg[] = 'Hardware Exist.';
			}
			// var_dump(array_merge($device, $identity));
		}
		else
		{
			$this->_form_msg[] = validation_errors();
		}

		$this->_form_value($this->_form_data);
		$this->_form_msg('form_error', $this->_form_msg);
		redirect('add-hardware');
	}

	public function index()
	{
		$this->access_control->check_role();

		$data['categories'] 	= $this->add_hardware_m->get_hw_categories();
		$data['manufactures'] 	= $this->add_hardware_m->get_hw_manufactures();
		$data['models'] 		= $this->add_hardware_m->get_hw_models();

		$view = array(
			'add-hardware/header',
			'_templates/sidebar',
			'_templates/topbar',
			'add-hardware/index',
			'add-hardware/footer'
		);

		MY_App::view($view, $data);
	}

	private function _rules()
	{
		$config = array(
			array(
				'field' => 'category',
				'label' => 'Category',
				'rules' => 'required|alpha|max_length[3]',
				'errors'=> array(
					'required' => '{field} is required.',
					'alpha' => '{field} should alphabet',
					'max_length' => 'Maximum characters of {field} should {param} characters.'
				)
			),
			array(
				'field' => 'hw_number',
				'label' => 'Hw. Number',
				'rules' => 'required|integer|max_length[4]',
				'errors'=> array(
					'required' => '{field} is required.',
					'integer' => '{field} should integer',
					'max_length' => 'Maximum characters of {field} should {param} characters.'
				)
			),
			array(
				'field' => 'manufacture',
				'label' => 'Manufacture',
				'rules' => 'required|integer',
				'errors'=> array(
					'required' => '{field} is required.',
					'integer' => '{field} should integer.'
				)
			),
			array(
				'field' => 'model',
				'label' => 'Model',
				'rules' => 'regex_match[/^[a-zA-Z0-9 _.,@\/\-]+$/]',
				'errors'=> array('regex_match' => 'Permitted character for {field} are [a-zA-Z0-9 _.,@\/\-]')
			),
			array(
				'field' => 'capacity',
				'label' => 'Capacity',
				'rules' => 'required|numeric',
				'errors'=> array(
					'required' => '{field} is required.',
					'numeric' => '{field} should numeric.'
				)
			),
			array(
				'field' => 'capacity_unit',
				'label' => 'Capacity Unit',
				'rules' => 'required|regex_match[/^(MB|GB|TB|Ghz|Mhz|Watt|Volt|Ampere)$/]',
				'errors'=> array(
					'required' => '{field} is required.', 
					'regex_match' => '{field} value should MB|GB|TB|Ghz|Mhz|Watt|Volt|Ampere'
				)
			),
			array(
				'field' => 'quantity',
				'label' => 'Quantity',
				'rules' => 'required|integer',
				'errors'=> array(
					'required' => '{field} is required.',
					'integer' => '{field} should integer.'
				)
			),
			array(
				'field' => 'procurement',
				'label' => 'Procurement',
				'rules' => 'required|integer|max_length[4]',
				'errors'=> array(
					'required' => '{field} is required.',
					'integer' => '{field} should integer',
					'max_length' => 'Maximum characters of {field} should {param} characters.'
				)
			),
			array(
				'field' => 'notes',
				'label' => 'Notes',
				'rules' => 'regex_match[/^[a-zA-Z0-9 _.,()&@\/\-]+$/]|max_length[255]',
				'errors'=> array(
					'regex_match' => 'Permitted characters for {field} are [a-zA-Z0-9 _.,()&@\/\-].',
					'max_length' => 'Maximum characters for {field} should {param} characters.'
				)
			),
			array(
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'regex_match[/^(active|broken|vacant)$/]',
				'errors'=> array('regex_match'=> '{field} options should active|broken|vacant.')
			)
		);
		
		$this->form_validation->set_rules($config);
	}
}

/* End of file add_hardware.php */
/* Location: ./application/controllers/add_hardware.php */