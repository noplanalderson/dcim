<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_sla extends MY_App
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
		$this->load->model('add_sla_m');

		$this->access_control->check_login();
	}

	public function datetime_regex($str)
	{
		$match = preg_match('/^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$/', $str) ? true : false;

		if($match == false)
		{
			$this->form_validation->set_message('datetime_regex', 'The {field} field should a valid datetime format.');
		}
	}

	public function index()
	{
		$this->access_control->check_role();

		if(isset($_POST['submit']))
		{
			$this->_form_data = $this->input->post(null, TRUE);
			
			$this->form_validation->set_rules('isp', 'ISP Name', 'trim|required|integer');
			$this->form_validation->set_rules('downtime', 'Downtime', 'trim|callback_datetime_regex');
			$this->form_validation->set_rules('uptime', 'Uptime', 'trim|callback_datetime_regex');
			$this->form_validation->set_rules('reason', 'Reason', 'trim|required|regex_match[/^[a-zA-Z0-9 _,.&@!:\/\-]+$/]|max_length[512]');
			$this->form_validation->set_rules('solution', 'Solution', 'trim|regex_match[/^[a-zA-Z0-9 _,.&@!:\/\-]+$/]|max_length[512]');

			if ($this->form_validation->run() == TRUE) 
			{
				if($this->add_sla_m->add_sla($this->_form_data) == true)
				{
					$this->_form_msg = 'SLA Added';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to add SLA';
					$this->_form_msg('form_error', $this->_form_msg);
				}
				// var_dump($this->_form_data);
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			// redirect('add-sla','refresh');
		}

		$data['isps'] = $this->add_sla_m->get_isp();

		$view = array(
			'add-sla/header',
			'_templates/sidebar',
			'_templates/topbar',
			'add-sla/index',
			'add-sla/footer'
		);

		MY_App::view($view, $data);
	}

}

/* End of file add_sla.php */
/* Location: ./application/controllers/add_sla.php */