<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends MY_App
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
		$this->load->model('userman_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$this->access_control->check_role();

		$data['users'] 		= $this->userman_m->get_users();
		$data['questions'] 	= $this->userman_m->get_questions();
		$data['user_groups']	= $this->userman_m->get_user_groups();
		$data['btn_add']	= $this->role_m->get_button('user-management/add');
		$data['btn_edit']	= $this->role_m->get_button('user-management/edit');
		$data['btn_delete'] 	= $this->role_m->get_button('user-management/delete');

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('username', 'Username', 'trim|required|regex_match[/^[a-z0-9_]+$/]|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]');
			$this->form_validation->set_rules('question', 'Security Question', 'required|integer');
			$this->form_validation->set_rules('answer', 'Security Answer', 'trim|required|regex_match[/^[a-zA-Z0-9 ,.!&%$#@\-]+$/]|max_length[255]');
			$this->form_validation->set_rules('user_group', 'User Group', 'required|integer');
			$this->form_validation->set_rules('status', 'User Status', 'required|regex_match[/(0|1)$/]');
			$this->form_validation->set_rules('old_picture', 'Old Picture', 'trim|required|regex_match[/^[a-zA-Z0-9._\/\-]+$/]|max_length[255]');

			if ($this->form_validation->run() == TRUE) 
			{
				$config['upload_path'] = './assets/wp-content/image/user/'.encrypt($this->_form_data['username']).'/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '5200';
				$config['file_ext_tolower'] = true;
				$config['detect_mime'] = true;
				$config['file_name'] = $this->_form_data['username'].'_'.random_string('alnum', 5).'_dyh_'.random_string('nozero', '5').'_mrn_'.date('Ymdhis');
				
				if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 755, true);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if ( ! $this->upload->do_upload('picture'))
				{
					$this->_form_msg[] = $this->upload->display_errors();
					$picture = $this->_form_data['old_picture'];
				}
				else
				{
					$picture = encrypt($this->_form_data['username']).'/'.$this->upload->data('file_name');
				}

				if($this->userman_m->check_username($this->_form_data['username']) == 0)
				{
					if($this->userman_m->add_user($this->_form_data, $picture) == true)
					{
						$this->_form_msg = 'User Added.';
						$this->_form_msg('success', $this->_form_msg);
					}
					else
					{
						$this->_form_msg[] = 'Failed to Add User.';
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					$this->_form_msg[] = 'Failed to Add User. Username Exist.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('user-management','refresh');
		}

		$view = array(
			'userman/header',
			'_templates/sidebar',
			'_templates/topbar',
			'userman/index',
			'userman/footer'
		);

		MY_App::view($view, $data);
	}

	public function get_user()
	{
		$this->access_control->check_button();

		$post = $this->input->post(null, TRUE);
		
		if( ! isset($post['id'])) :
			return false;
		else :
			$token 	= array('token' => $this->security->get_csrf_hash());
			$data 	= $this->userman_m->get_user_by_id($post['id']);
			$array 	= array_merge($token, $data);
			echo json_encode($array);
		endif;
	}

	public function edit()
	{
		$this->access_control->check_button();

		$this->_form_data = $this->input->post(null, TRUE);
		
		$this->form_validation->set_rules('user_id', 'ID User', 'required|regex_match[/[a-f0-9\-]+$/]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|regex_match[/^[a-z0-9_]+$/]|max_length[50]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]');
		$this->form_validation->set_rules('question', 'Security Question', 'required|integer');
		$this->form_validation->set_rules('answer', 'Security Answer', 'trim|required|regex_match[/^[a-zA-Z0-9 ,.!&%$#@\-]+$/]|max_length[255]');
		$this->form_validation->set_rules('user_group', 'User Group', 'required|integer');
		$this->form_validation->set_rules('status', 'User Status', 'required|regex_match[/(0|1)$/]');
		$this->form_validation->set_rules('old_picture', 'Old Picture', 'trim|required|regex_match[/^[a-zA-Z0-9._\/\-]+$/]|max_length[255]');

		if ($this->form_validation->run() == TRUE) 
		{
			$config['upload_path'] = './assets/wp-content/image/user/'.encrypt($this->_form_data['username']).'/';
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max_size']  = '5200';
			$config['file_ext_tolower'] = true;
			$config['detect_mime'] = true;
			$config['file_name'] = $this->_form_data['username'].'_'.random_string('alnum', 5).'_dyh_'.random_string('nozero', '5').'_mrn_'.date('Ymdhis');
			
			if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 755, true);

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			
			if ( ! $this->upload->do_upload('picture'))
			{
				$this->_form_msg[] = $this->upload->display_errors();
				$picture = $this->_form_data['old_picture'];
			}
			else
			{
				$picture = encrypt($this->_form_data['username']).'/'.$this->upload->data('file_name');
			}

			if($this->userman_m->check_username($this->_form_data['username'], $this->_form_data['user_id']) == 0)
			{
				if($this->userman_m->edit_user($this->_form_data, $picture) == true)
				{
					$this->_form_msg = 'User Edited.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to Edit User.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			}
			else
			{
				$this->_form_msg[] = 'Failed to Edit User. Username Exist.';
				$this->_form_msg('form_error', $this->_form_msg);
			}
		} 
		else 
		{
			$this->_form_msg[] = validation_errors();
			$this->_form_msg('form_error', $this->_form_msg);
		}

		$this->_form_value($this->_form_data);
		redirect('user-management');
	}

	public function delete($id = NULL)
	{
		$this->access_control->check_button();

		if(!decrypt($id)) show_404();

		if($this->userman_m->delete_user($id) == true)
		{
			$this->_form_msg = 'User Deleted.';
			$this->_form_msg('success', $this->_form_msg);
		}
		else
		{
			$this->_form_msg[] = 'Failed to Delete User.';
			$this->_form_msg('form_error', $this->_form_msg);
		}
		
		redirect('user-management');
	}
}

/* End of file user_management.php */
/* Location: ./application/controllers/user_management.php */