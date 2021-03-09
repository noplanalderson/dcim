<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Isp_setting extends MY_App
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
		$this->load->model('isp_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		$this->access_control->check_role();

		$data['isps'] 		= $this->isp_m->get_isp();
		$data['btn_add'] 	= $this->role_m->get_button('isp-setting/add');
		$data['btn_edit'] 	= $this->role_m->get_button('isp-setting/edit');
		$data['btn_delete'] = $this->role_m->get_button('isp-setting/delete');

		$view = array(
			'isp/header',
			'_templates/sidebar',
			'_templates/topbar',
			'isp/index',
			'isp/footer'
		);

		MY_App::view($view, $data);
	}

	public function get_isp()
	{
		$this->access_control->check_button();

		$post = $this->input->post(null, TRUE);
		
		if( ! isset($post['id'])) :
			return false;
		else :
			$token 	= array('token' => $this->security->get_csrf_hash());
			$data 	= $this->isp_m->get_isp_by_id($post['id']);
			$array 	= array_merge($token, $data);
			echo json_encode($array);
		endif;
	}

	public function add()
	{
		$this->access_control->check_button();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('isp_name', 'ISP Name', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
			$this->form_validation->set_rules('sla_standard', 'SLA Standard', 'required|numeric');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->isp_m->add_isp($this->_form_data))
				{
					$this->_form_msg = 'ISP Added.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to Add ISP.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('isp-setting');
		}
		else
		{
			redirect('isp-setting');
		}
	}

	public function edit()
	{
		$this->access_control->check_button();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('isp_id', 'ISP ID', 'trim|required|regex_match[/[a-f0-9\-]+$/]|exact_length[36]');
			$this->form_validation->set_rules('isp_name', 'ISP Name', 'trim|required|regex_match[/[a-zA-Z0-9 \-]+$/]|max_length[100]');
			$this->form_validation->set_rules('sla_standard', 'SLA Standard', 'required|numeric');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->isp_m->edit_isp($this->_form_data))
				{
					$this->_form_msg = 'ISP Edited.';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to Edit ISP.';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('isp-setting');
		}
		else
		{
			redirect('isp-setting');
		}
	}

	public function delete($id = NULL)
	{
		$this->access_control->check_button();

		if(!decrypt($id)) show_404();

		if($this->isp_m->delete_isp($id) == true)
		{
			$this->_form_msg = 'ISP Deleted.';
			$this->_form_msg('success', $this->_form_msg);
		}
		else
		{
			$this->_form_msg[] = 'Failed to Delete ISP.';
			$this->_form_msg('form_error', $this->_form_msg);
		}

		redirect('isp-setting');
	}
}

/* End of file isp_setting.php */
/* Location: ./application/controllers/isp_setting.php */