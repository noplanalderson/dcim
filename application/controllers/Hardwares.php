<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hardwares extends MY_App 
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
		$this->load->model('hardwares_m');
		$this->load->model('add_hardware_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$this->access_control->check_role();

		if(isset($_POST['group']))
		{
			$group = $this->input->post('group', TRUE);
			redirect('hardwares/group/'.$group, 'location', 303);
		}

		$data['title'] 			= 'All Hardwares';
		$data['hw_group'] 		= 'All Hardwares';
		$data['hardwares'] 		= $this->hardwares_m->get_hardwares();
		$data['groups']			= $this->hardwares_m->get_groups();
		$data['counthw']		= count($data['hardwares']);
		$data['btn_add'] 		= $this->role_m->get_button('add-hardware');
		$data['btn_edit'] 		= $this->role_m->get_button('hardwares/edit');
		$data['btn_delete'] 	= $this->role_m->get_button('hardwares/delete');

		$view = array(
			'hardwares/header',
			'_templates/sidebar',
			'_templates/topbar',
			'hardwares/index',
			'hardwares/footer'
		);

		MY_App::view($view, $data);
	}

	public function group($group = NULL)
	{
		$this->access_control->check_button();

		if(isset($_POST['group']))
		{
			$group = $this->input->post('group', TRUE);
			redirect('hardwares/group/'.$group, 'location', 303);
		}

		$data['title'] 			= ucwords(str_replace('-', ' ', $group));
		$data['hw_group'] 		= preg_replace("/[^a-zA-Z0-9\s]/", " ", $group);
		$data['hardwares'] 		= $this->hardwares_m->get_hardwares(ucwords($data['hw_group']));
		$data['groups']			= $this->hardwares_m->get_groups();
		$data['counthw']		= count($data['hardwares']);
		$data['btn_add'] 		= $this->role_m->get_button('add-hardware');
		$data['btn_edit'] 		= $this->role_m->get_button('hardwares/edit');
		$data['btn_delete'] 	= $this->role_m->get_button('hardwares/delete');

		$view = array(
			'hardwares/header',
			'_templates/sidebar',
			'_templates/topbar',
			'hardwares/index',
			'hardwares/footer'
		);

		MY_App::view($view, $data);
	}

	public function detail($id = NULL)
	{
		$this->access_control->check_button();

		if(empty($id) OR !decrypt($id)) show_404();

		$data['hardware'] = $this->hardwares_m->get_hw_by_id($id);

		if(empty($data['hardware'])) show_404();

		$view = array(
			'hardwares/header-detail',
			'_templates/sidebar',
			'_templates/topbar',
			'hardwares/detail',
			'hardwares/footer-detail'
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
				$hw_code = hw_code_gen($post);

				$config['upload_path'] = './assets/wp-content/image/'.$post['category'].'/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '5200';
				$config['file_name'] = image_filename_gen($hw_code);
				$config['detect_mime'] = TRUE;
				
				if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 755, true);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('hw_picture'))
				{
					$this->_form_msg[] = strip_tags($this->upload->display_errors());
					$filename = $post['old_hw_picture'];
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
				
				if($this->hardwares_m->check_hw($post['category'], $post['hw_number'], $id) == 0)
				{
					if($this->hardwares_m->edit_hardware($hardware, $id) == true)
					{
						$this->_form_msg('success', 'Hardware Edited');
					}
					else
					{
						$this->_form_msg[] = 'Failed to Edit Hardware';
					}
				}
				else
				{
					$this->_form_msg[] = 'Hardware Exist.';
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
			}

			$this->_form_value($this->_form_data);
			$this->_form_msg('form_error', $this->_form_msg);
			redirect('hardwares');
		}

		$data['title'] 			= 'Edit Hardware';
		$data['hardware']		= $this->hardwares_m->get_hw_by_id($id);
		$data['categories'] 	= $this->add_hardware_m->get_hw_categories();
		$data['manufactures'] 	= $this->add_hardware_m->get_hw_manufactures();
		$data['models'] 		= $this->add_hardware_m->get_hw_models();

		if(empty($data['hardware'])) show_404();

		$view = array(
			'hardwares/header',
			'_templates/sidebar',
			'_templates/topbar',
			'hardwares/edit',
			'hardwares/footer-edit'
		);

		MY_App::view($view, $data);
	}

	public function delete($id = NULL)
	{
		$this->access_control->check_button();

		if(empty($id) OR !decrypt($id)) show_404();

		$image = $this->hardwares_m->get_image($id);
		$image_location = FCPATH.'/assets/wp-content/image/'.$image->hw_picture;
		
		if(file_exists($image_location))
		{
			if($image->hw_picture !== 'noimage.png') unlink($image_location);

			$config = array(
				'log_type' => 'hardware',
				'item' => $image->hw_code,
				'pic' => $this->user['user_name'],
				'action' => 'deleted',
				'obj_link' => '#'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			if($this->hardwares_m->delete_hardware($id) == true)
			{
				$this->_form_msg('success', 'Hardware Deleted.');	
			}
			else
			{
				$this->_form_msg[] = 'Failed to Delete Hardware.';
			}
		}
		else
		{
			$this->_form_msg[] = 'Failed to Delete Hardware\'s Image.';
		}

		$this->_form_msg('form_error', $this->_form_msg);
		redirect('hardwares');
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
			),
			array(
				'field' => 'old_hw_picture',
				'label' => 'Hardware Image',
				'rules' => 'max_length[255]|regex_match[/^[a-zA-Z0-9.\/\-_]+$/]',
				'errors'=> array(
					'max_length' => '{field} maximum length is {param} characters.',
					'regex_match'=> 'Allowed character for {field} is [a-zA-Z0-9.\/\-_]'
				)
			)
		);
		
		$this->form_validation->set_rules($config);
	}
}

/* End of file hardwares.php */
/* Location: ./application/controllers/hardwares.php */