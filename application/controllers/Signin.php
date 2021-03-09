<?php
/**
 * Signin Controller 
 *
 * Project App Data Center Inventory Management v3
 * Dinas Komunikasi dan Informatika Kota Tangerang
 *
 * This project was created to meet the needs of 
 * data center infrastructure governance and inventory management. 
 * May be distributed and developed while still including my name.
 * 
 * @package DCIM v3
 * @author M. Ridwan Na'im, MTCNA
 * @copyright @__debu_semesta
 * @since 3.0.0
 * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends MY_App 
{
	/**
	 * [$_u_data get from tabel]
	 * @var [void]
	 */
	private $_u_data;

	/**
	 * [$_form_data submited data]
	 * @var array
	 */
	private $_form_data = array('username' => '', 'password' => '');

	/**
	 * [$form_msg form message]
	 * @var array
	 */
	private $_form_msg = array();

	/**
	 * Login Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('signin_m');

		$config['uid'] = $this->session->userdata('uid');
		$config['gid'] = $this->session->userdata('gid');
		$this->load->library('access_control', $config);

		$this->access_control->is_login();
	}

	public function index()
	{
		$data['questions'] = $this->signin_m->get_questions();

		$view = array(
			'_templates/head_login.php', 
			'login/index.php', 
			'_templates/footer_login.php'
		);
		
		MY_App::view($view, $data);
	}

	private function _is_submited()
	{
		if( ! isset($_POST['submit'])) {
			$this->_form_msg[] = 'Please Fill the Form.';
			$this->_form_msg('form_error', $this->_form_error);
		}
	}

	private function _verify()
	{
		if($this->_u_data->num_rows() > 0)
		{
			$data = $this->_u_data->row();

			if(password_verify($this->_form_data['password'], $data->user_password))
			{
				$now = new DateTime();
				$now->setTimezone(new DateTimeZone('Asia/Jakarta'));

				$sess_id = array(
					'uid' => $data->user_id,
					'gid' => $data->user_group_id,
					'time' => strtotime($now->format('Y-m-d H:i:s'))
				);
				
				$this->session->set_userdata($sess_id);
				redirect(site_url('dashboard'));
			}
			else
			{
				$this->_form_msg[] = 'Wrong Password.';
			}
		}
		else
		{
			$this->_form_msg[] = 'Username or Email not Found.';
		}

		return $this->_form_msg;
	}

	public function auth()
	{
		$this->_is_submited();

		$this->_form_data = array(
			'username' => $this->input->post('u_name', TRUE),
			'password' => $this->input->post('u_pass', TRUE)
		);

		$this->_form_value($this->_form_data);
		
		$this->_rules();

		if($this->form_validation->run() == FALSE) 
		{
			$this->_form_msg[] = validation_errors();
		} 
		else 
		{
			$this->_u_data = $this->signin_m->check_user($this->_form_data);
			$this->_verify();
		}
		
		$this->_form_msg('form_error', $this->_form_msg);
		redirect('signin');
	}

	private function _rules()
	{
		$config = array(
			array('field' => 'u_name',
				  'label' => 'Username',
				  'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9.-_@]+$/]|min_length[4]|max_length[80]',
				  'errors'=> array(
		  				'required' => 'Please input {field} or Email.',
		  				'regex_match' => '{field} should alphanumeric, underscore, [dot] and @.',
		  				'min_length' => '{field} minimun {param} characters.',
		  				'max_length' => '{field} maximum {param} characters.'
		  			)
			),
			array('field' => 'u_pass',
				  'label' => 'Password',
				  'rules' => 'required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/]',
				  'errors'=> array(
				  		'required' => 'Please input {field} or Email.',
				  		'regex_match' => '{field} should Uppercase, Lowercase, Numeric, and Symbols 8-16 Characters.'
				  	)
			)
		);

		$this->form_validation->set_rules($config);
	}

	public function reset_password()
	{
		$this->_is_submited();

		$this->form_validation->set_rules('user_name', 'Username', 'trim|required|regex_match[/^[a-zA-Z0-9.@_]+$/]');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|regex_match[/^[a-zA-Z0-9.@_]+$/]');
		$this->form_validation->set_rules('sec_question', 'Security Question', 'required|integer');
		$this->form_validation->set_rules('sec_answer', 'Security Answer', 'trim|required|max_length[200]');

		$this->_form_data = $this->input->post(null, TRUE);

		$this->_form_value($this->_form_data);

		if($this->form_validation->run() == FALSE) 
		{
			$this->_form_msg[] = validation_errors();
		} 
		else 
		{
			if($this->signin_m->check_data($this->_form_data) > 0)
			{
				$this->_form_msg = 'Data Found. Set Your New Password!';
				$this->_form_msg('success', $this->_form_msg);

				$view = array(
					'_templates/head_login.php', 
					'login/reset.php', 
					'_templates/footer_login.php'
				);
				
				MY_App::view($view, $this->_form_data);
			}
			else
			{
				$this->_form_msg[] = 'Data not Found or Data Combination not Match.';
				$this->_form_msg('form_error', $this->_form_msg);
			}
		}

		$this->_form_msg('form_error', $this->_form_msg);
		redirect('signin#reset');
	}

	public function reset()
	{
		$this->_is_submited();

		$post = $this->input->post(null, TRUE);

		$this->form_validation->set_rules('user_name', 'Username', 'trim|required|regex_match[/^[a-zA-Z0-9.@_]+$/]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/]');
		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|matches[password]');

		if ($this->form_validation->run() == TRUE) 
		{
			if($this->signin_m->reset_password($post) == true)
			{
				$this->_form_msg = 'Reset Password Success!';
				$this->_form_msg('success', $this->_form_msg);
				redirect('signin');
			}
			else
			{
				$this->_form_msg[] = 'Failed to Reset Password.';
				$this->_form_msg('form_error', $this->_form_msg);
				redirect('signin#reset');
			}
		} 
		else 
		{
			$this->_form_msg[] = validation_errors();
			$this->_form_msg('form_error', $this->_form_msg);
			redirect('signin#reset');
		}
	}
}
