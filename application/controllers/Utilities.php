<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilities extends MY_App
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
		$this->load->model('utilities_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$this->access_control->check_role();

		$data['title'] 			= 'Utilities';
		$data['dev_groups']		= $this->utilities_m->get_dev_groups();
		$data['manufactures']	= $this->utilities_m->get_dev_manufactures();
		$data['dev_models']		= $this->utilities_m->get_dev_models();
		$data['hw_manufactures']= $this->utilities_m->get_hw_manufactures();
		$data['hw_groups']		= $this->utilities_m->get_hw_groups();

		$data['btn_add']	 	= $this->role_m->get_button('utilities/add');
		$data['btn_edit']	 	= $this->role_m->get_button('utilities/edit');
		$data['btn_delete'] 	= $this->role_m->get_button('utilities/delete');

		$view = array(
			'utility/header',
			'_templates/sidebar',
			'_templates/topbar',
			'utility/index',
			'utility/footer'
		);

		MY_App::view($view, $data);
	}

	public function add()
	{
		$this->access_control->check_role();

		$data['title'] 			= 'Add Utilities';
		$data['dev_groups']		= $this->utilities_m->get_dev_groups();
		$data['manufactures']	= $this->utilities_m->get_dev_manufactures();
		$data['dev_models']		= $this->utilities_m->get_dev_models();
		$data['hw_manufactures']= $this->utilities_m->get_hw_manufactures();
		$data['hw_groups']		= $this->utilities_m->get_hw_groups();

		$view = array(
			'utility/header',
			'_templates/sidebar',
			'_templates/topbar',
			'utility/input',
			'utility/footer-add'
		);

		MY_App::view($view, $data);
	}

	public function submit($item = NULL)
	{
		if( ! preg_match('/(manufacture|dev-model|dev-group|hw-manufacture|hw-group)$/', $item)) show_404();

		switch ($item) 
		{
			case 'manufacture':
				if(isset($_POST['add']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('manufacture_name', 'Manufacture', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('device_group', 'Device Group', 'required|integer|max_length[11]');

					if($this->form_validation->run() == TRUE) 
					{
						$comparison = array(
							'dev_manufacture' => $this->_form_data['manufacture_name'], 
							'group_id' => $this->_form_data['device_group']
						);

						if($this->utilities_m->check_utils('tb_dev_manufacture', $comparison) == 0)
						{
							$result = $this->utilities_m->add_manufacture($this->_form_data);

							if($result == true)
							{
								$this->_form_msg = 'Device Manufacture Added.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Add Device Manufacture.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Add Device Manufacture. Manufacture Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					redirect('utilities/add');
				}
			break;
			
			case 'dev-model':
				if(isset($_POST['add']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('model', 'Device Model', 'trim|required|regex_match[/[a-zA-Z0-9 \/\-]+$/]|max_length[100]');
					$this->form_validation->set_rules('manufacture', 'Device Manufacture', 'required|integer|max_length[11]');

					if($this->form_validation->run() == TRUE) 
					{
						$comparison = array(
							'dev_model' => $this->_form_data['model'], 
							'dev_manufacture_id' => $this->_form_data['manufacture']
						);
						
						if($this->utilities_m->check_utils('tb_dev_model', $comparison) == 0)
						{
							$result = $this->utilities_m->add_dev_model($this->_form_data);

							if($result == true)
							{
								$this->_form_msg = 'Device Model Added.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Add Device Model.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Add Device Model. Device Model Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					redirect('utilities/add');
				}
			break;

			case 'dev-group':
				if(isset($_POST['add']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('group_code', 'Group Code', 'trim|required|regex_match[/[A-Z]+$/]|max_length[3]');
					$this->form_validation->set_rules('dev_group', 'Device Group', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('dev_icon', 'Device Icon', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]');

					if($this->form_validation->run() == TRUE) 
					{
						$comparison = array(
							'group_code' => $this->_form_data['group_code']
						);
						
						$or_comparison = array(
							'group_label' => $this->_form_data['dev_group']
						);

						if($this->utilities_m->check_utils('tb_dev_group', $comparison, $or_comparison) == 0)
						{
							$result = $this->utilities_m->add_dev_group($this->_form_data);

							if($result == true)
							{
								$this->_form_msg = 'Device Group Added.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Add Device Group.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Add Device Group. Device Group Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					redirect('utilities/add');
				}
			break;

			case 'hw-manufacture':
				if(isset($_POST['add']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('hw_manufacture', 'Hardware Manufacture', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('hw_group', 'Hardware Group', 'required|integer|max_length[11]');

					if($this->form_validation->run() == TRUE) 
					{
						$comparison = array(
							'hw_manufacture' => $this->_form_data['hw_manufacture'], 
							'hw_category_id' => $this->_form_data['hw_group']
						);

						if($this->utilities_m->check_utils('tb_hw_manufacture', $comparison) == 0)
						{
							$result = $this->utilities_m->add_hw_manufacture($this->_form_data);

							if($result == true)
							{
								$this->_form_msg = 'Hardware Manufacture Added.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Add Hardware Manufacture.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Add Hardware Manufacture. Manufacture Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					redirect('utilities/add');
				}
			break;

			case 'hw-group':
				if(isset($_POST['add']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('hw_code', 'Group Code', 'trim|required|regex_match[/[A-Z]+$/]|max_length[3]');
					$this->form_validation->set_rules('hw_group_name', 'Hardware Group', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('hw_icon', 'Hardware Icon', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]');

					if($this->form_validation->run() == TRUE) 
					{
						$comparison = array(
							'hw_code' => $this->_form_data['hw_code']
						);
						
						$or_comparison = array(
							'hw_category' => $this->_form_data['hw_group_name']
						);

						if($this->utilities_m->check_utils('tb_hw_category', $comparison, $or_comparison) == 0)
						{
							$result = $this->utilities_m->add_hw_group($this->_form_data);

							if($result == true)
							{
								$this->_form_msg = 'Hardware Group Added.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Add Hardware Group.';
								$this->_form_msg('form_error', $this->_form_msg);
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Add Hardware Group. Hardware Group Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					redirect('utilities/add');
				}
			break;

			default:
				show_404();
			break;
		}

		$this->_form_value($this->_form_data);
		redirect('utilities/add');
	}

	public function delete($item = NULL, $id = NULL)
	{
		if( ! preg_match('/(manufacture|dev-model|dev-group|hw-manufacture|hw-group)$/', $item)) show_404();

		$this->access_control->check_button();

		switch ($item) 
		{
			case 'manufacture':
				$result = $this->utilities_m->delete_manufacture($id);
				$msg_success = 'Device Manufacture Deleted.';
				$msg_error = 'Failed to Delete Device Manufacture.';
				break;
			
			case 'dev-model':
				$result = $this->utilities_m->delete_model($id);
				$msg_success = 'Device Model Deleted.';
				$msg_error = 'Failed to Delete Device Model.';
				break;

			case 'dev-group':
				$result = $this->utilities_m->delete_group($id);
				$msg_success = 'Device Group Deleted.';
				$msg_error = 'Failed to Delete Device Group.';
				break;

			case 'hw-manufacture':
				$result = $this->utilities_m->delete_hw_manufacture($id);
				$msg_success = 'Hardware Manufacture Deleted.';
				$msg_error = 'Failed to Delete Hardware Manufacture.';
				break;

			case 'hw-group':
				$result = $this->utilities_m->delete_hw_group($id);
				$msg_success = 'Hardware Group Deleted.';
				$msg_error = 'Failed to Delete Hardware Group.';
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

		redirect('utilities');
	}

	public function edit($type = NULL, $id = NULL)
	{
		if(empty($id) && ! preg_match('/(manufacture|dev-model|dev-group|hw-manufacture|hw-group)$/', $type)) show_404();

		$this->access_control->check_button();

		$data['title'] 			= 'Edit Utilities';
		$data['dev_groups']		= $this->utilities_m->get_dev_groups();
		$data['manufactures']	= $this->utilities_m->get_dev_manufactures();
		$data['dev_models']		= $this->utilities_m->get_dev_models();
		$data['hw_manufactures']= $this->utilities_m->get_hw_manufactures();
		$data['hw_groups']		= $this->utilities_m->get_hw_groups();


		switch ($type) {
			case 'manufacture':
				if(isset($_POST['edit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('manufacture_name', 'Manufacture', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('device_group', 'Device Group', 'required|integer|max_length[11]');

					if($this->form_validation->run() == TRUE) 
					{
						$data = array(
							'dev_manufacture' => $this->_form_data['manufacture_name'], 
							'group_id' => $this->_form_data['device_group']
						);

						if($this->utilities_m->check_utils('tb_dev_manufacture', $data, [], array('dev_manufacture_id' => decrypt($id))) == 0)
						{
							$result = $this->utilities_m->edit_manufacture($data, $id);

							if($result == true)
							{
								$this->_form_msg = 'Device Manufacture Edited.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Device Manufacture.';
								$this->_form_msg('form_error', $this->_form_msg);
								redirect('utilities/edit/manufacture/'.$id,'refresh');
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Edit Device Manufacture. Manufacture Exist.'.$this->utilities_m->check_utils('tb_dev_manufacture', $data, [], array('dev_manufacture_id', decrypt($id)));
							$this->_form_msg('form_error', $this->_form_msg);
							redirect('utilities/edit/manufacture/'.$id,'refresh');
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				$data['utils'] = $this->utilities_m->getDataByID('tb_dev_manufacture', 'dev_manufacture_id', $id);
				$data['form'] = $this->load->view('utility/edit_dev_manufacture', $data, TRUE);
				break;
			
			case 'dev-model':
				if(isset($_POST['edit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('model', 'Device Model', 'trim|required|regex_match[/[a-zA-Z0-9 \/\-]+$/]|max_length[100]');
					$this->form_validation->set_rules('manufacture', 'Device Manufacture', 'required|integer|max_length[11]');

					if($this->form_validation->run() == TRUE) 
					{
						$data = array(
							'dev_model' => $this->_form_data['model'], 
							'dev_manufacture_id' => $this->_form_data['manufacture']
						);
						
						if($this->utilities_m->check_utils('tb_dev_model', $data, array(), array('dev_model_id' => decrypt($id))) == 0)
						{
							$result = $this->utilities_m->edit_dev_model($data, $id);

							if($result == true)
							{
								$this->_form_msg = 'Device Model Edited.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Device Model.';
								$this->_form_msg('form_error', $this->_form_msg);
								redirect('utilities/edit/dev-model/'.$id,'refresh');
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Edit Device Model. Device Model Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
							redirect('utilities/edit/dev-model/'.$id,'refresh');
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				$data['utils'] = $this->utilities_m->getDataByID('tb_dev_model', 'dev_model_id', $id);
				$data['form'] = $this->load->view('utility/edit_dev_model', $data, TRUE);
				break;

			case 'dev-group':
				if(isset($_POST['edit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('group_code', 'Group Code', 'trim|required|regex_match[/[A-Z]+$/]|max_length[3]');
					$this->form_validation->set_rules('dev_group', 'Device Group', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('dev_icon', 'Device Icon', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]');

					if($this->form_validation->run() == TRUE) 
					{
						$comparison = array(
							'group_code' => $this->_form_data['group_code']
						);
						
						$or_comparison = array(
							'group_label' => $this->_form_data['dev_group']
						);

						$not_comparison = array(
							'group_id' => decrypt($id)
						);

						$data = array_merge($comparison, $or_comparison, array('group_icon' => $this->_form_data['dev_icon']));
						if($this->utilities_m->check_utils('tb_dev_group', $comparison, $or_comparison, $not_comparison) == 0)
						{
							$result = $this->utilities_m->edit_dev_group($data, $id);

							if($result == true)
							{
								$this->_form_msg = 'Device Group Edited.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Device Group.';
								$this->_form_msg('form_error', $this->_form_msg);
								redirect('utilities/edit/dev-group/'.$id,'refresh');
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Edit Device Group. Device Group Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
							redirect('utilities/edit/dev-group/'.$id,'refresh');
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				$data['utils'] = $this->utilities_m->getDataByID('tb_dev_group', 'group_id', $id);
				$data['form'] = $this->load->view('utility/edit_dev_group', $data, TRUE);
				break;

			case 'hw-manufacture':
				if(isset($_POST['edit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('hw_manufacture', 'Hardware Manufacture', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('hw_group', 'Hardware Group', 'required|integer|max_length[11]');

					if($this->form_validation->run() == TRUE) 
					{
						$data = array(
							'hw_manufacture' => $this->_form_data['hw_manufacture'], 
							'hw_category_id' => $this->_form_data['hw_group']
						);

						if($this->utilities_m->check_utils('tb_hw_manufacture', $data, [], array('hw_manufacture_id' => decrypt($id))) == 0)
						{
							$result = $this->utilities_m->edit_hw_manufacture($data, $id);

							if($result == true)
							{
								$this->_form_msg = 'Hardware Manufacture Edited.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Hardware Manufacture.';
								$this->_form_msg('form_error', $this->_form_msg);
								redirect('utilities/edit/hw-manufacture/'.$id,'refresh');
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Edit Hardware Manufacture. Manufacture Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
							redirect('utilities/edit/hw-manufacture/'.$id,'refresh');
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				$data['utils'] = $this->utilities_m->getDataByID('tb_hw_manufacture', 'hw_manufacture_id', $id);
				$data['form'] = $this->load->view('utility/edit_hw_manufacture', $data, TRUE);
				break;

			case 'hw-group':
				if(isset($_POST['edit']))
				{
					$this->_form_data = $this->input->post(null, TRUE);

					$this->form_validation->set_rules('hw_code', 'Group Code', 'trim|required|regex_match[/[A-Z]+$/]|max_length[3]');
					$this->form_validation->set_rules('hw_group_name', 'Hardware Group', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
					$this->form_validation->set_rules('hw_icon', 'Hardware Icon', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]');

					if($this->form_validation->run() == TRUE) 
					{
						$comparison = array(
							'hw_code' => $this->_form_data['hw_code']
						);
						
						$or_comparison = array(
							'hw_category' => $this->_form_data['hw_group_name']
						);

						$not_comparison = array(
							'hw_category_id' => decrypt($id)
						);

						$data = array_merge($comparison, $or_comparison, array('hw_icon' => $this->_form_data['hw_icon']));

						if($this->utilities_m->check_utils('tb_hw_category', $comparison, $or_comparison, $not_comparison) == 0)
						{
							$result = $this->utilities_m->edit_hw_group($data, $id);

							if($result == true)
							{
								$this->_form_msg = 'Hardware Group Edited.';
								$this->_form_msg('success', $this->_form_msg);
								redirect('utilities');
							}
							else
							{
								$this->_form_msg[] = 'Failed to Edit Hardware Group.';
								$this->_form_msg('form_error', $this->_form_msg);
								redirect('utilities/edit/hw-group/'.$id,'refresh');
							}
						}
						else
						{
							$this->_form_msg[] = 'Failed to Edit Hardware Group. Hardware Group Exist.';
							$this->_form_msg('form_error', $this->_form_msg);
							redirect('utilities/edit/hw-group/'.$id,'refresh');
						}
					} 
					else 
					{
						$this->_form_msg[] = validation_errors();
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				$data['utils'] = $this->utilities_m->getDataByID('tb_hw_category', 'hw_category_id', $id);
				$data['form'] = $this->load->view('utility/edit_hw_group', $data, TRUE);
				break;

			default:
				show_404();
				break;
		}

		$view = array(
			'utility/header',
			'_templates/sidebar',
			'_templates/topbar',
			'utility/edit',
			'utility/footer-add'
		);

		MY_App::view($view, $data);
	}
}

/* End of file utilities.php */
/* Location: ./application/controllers/utilities.php */
