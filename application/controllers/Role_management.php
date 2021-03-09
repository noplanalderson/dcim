<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_management extends MY_App
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
		$this->load->model('userman_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$this->access_control->check_role();

		$data['user_groups'] = $this->userman_m->get_user_groups();
		$data['menus'] 		 = $this->role_m->get_menus();
		$data['btn_add']	 	= $this->role_m->get_button('role-management/add');
		$data['btn_edit']	 	= $this->role_m->get_button('role-management/edit');
		$data['btn_delete'] 	= $this->role_m->get_button('role-management/delete');

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('user_group', 'User Group', 'trim|required|regex_match[/^[a-zA-Z ]+$/]|max_length[50]');
			$this->form_validation->set_rules('roles[]', 'Roles', 'trim|required');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->role_m->check_user_group($this->_form_data['user_group']) == 0)
				{
					if($this->role_m->add_user_group($this->_form_data) == true)
					{
						$this->_form_msg = 'User Group Added.';
						$this->_form_msg('success', $this->_form_msg);
					}
					else
					{
						$this->_form_msg[] = 'Failed to Add User Group.';
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					$this->_form_msg[] = 'Failed to Add User Group. User Group Exist.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('role-management','refresh');
		}

		$view = array(
			'roleman/header',
			'_templates/sidebar',
			'_templates/topbar',
			'roleman/index',
			'roleman/footer'
		);

		MY_App::view($view, $data);
	}

	public function get_role()
	{
		$this->access_control->check_button();

		$post = $this->input->post(null, TRUE);
		
		if( ! isset($post['id'])) :
			return false;
		else :
			$token 	= array('token' => $this->security->get_csrf_hash());
			$data 	= $this->role_m->get_group_by_id($post['id']);
			$array 	= array_merge($token, $data);
			echo json_encode($array);
		endif;
	}

	public function edit()
	{
		$this->access_control->check_button();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('id', 'ID', 'required|regex_match[/[a-f0-9\-]+$/]');
			$this->form_validation->set_rules('user_group', 'User Group', 'trim|required|regex_match[/^[a-zA-Z ]+$/]|max_length[50]');
			$this->form_validation->set_rules('roles[]', 'Roles', 'trim|required');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->role_m->check_user_group($this->_form_data['user_group'], $this->_form_data['id']) == 0)
				{
					if($this->role_m->edit_user_group($this->_form_data) == true)
					{
						$this->_form_msg = 'User Group Edited.';
						$this->_form_msg('success', $this->_form_msg);
					}
					else
					{
						$this->_form_msg[] = 'Failed to Edit User Group.';
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					$this->_form_msg[] = 'Failed to Edit User Group. User Group Exist.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('role-management');
		}
	}

	public function delete($id = NULL)
	{
		$this->access_control->check_button();

		if(!decrypt($id)) show_404();

		if($this->role_m->delete_group($id))
		{
			$this->_form_msg = 'User Group Deleted.';
			$this->_form_msg('success', $this->_form_msg);
		}
		else
		{
			$this->_form_msg[] = 'Failed to Delete User Group. User Group Used by User.';
			$this->_form_msg('form_error', $this->_form_msg);
		}

		redirect('role-management');
	}
}

/* End of file role_management.php */
/* Location: ./application/controllers/role_management.php */