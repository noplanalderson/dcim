<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_setting extends MY_App
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
		$this->load->model('account_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$data['account'] 	= $this->account_m->get_user_data();
		$data['questions'] 	= $this->account_m->get_questions();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('username', 'Username', 'trim|required|regex_match[/^[a-z0-9_]+$/]|max_length[50]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/]');
			$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|matches[password]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]');
			$this->form_validation->set_rules('question', 'Security Question', 'required|integer');
			$this->form_validation->set_rules('answer', 'Security Answer', 'trim|required|regex_match[/^[a-zA-Z0-9 ,.!&%$#@\-]+$/]|max_length[255]');
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

				if($this->account_m->check_username($this->_form_data['username']) == 0)
				{
					if($this->account_m->account_setting($this->_form_data, $picture) == true)
					{
						$this->_form_msg = 'Account Updated.';
						$this->_form_msg('success', $this->_form_msg);
					}
					else
					{
						$this->_form_msg[] = 'Failed to Update Account.';
						$this->_form_msg('form_error', $this->_form_msg);
					}
				}
				else
				{
					$this->_form_msg[] = 'Failed to Update Account. Username Exist.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('account-setting','refresh');
		}

		$view = array(
			'account/header',
			'_templates/sidebar',
			'_templates/topbar',
			'account/index',
			'account/footer'
		);

		MY_App::view($view, $data);
	}
}

/* End of file account_setting.php */
/* Location: ./application/controllers/account_setting.php */