<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sla_summary extends MY_App
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
		$this->load->model('sla_summary_m');

		$this->access_control->check_login();
	}

	public function period($period = NULL, $isp = NULL)
	{
		$this->access_control->check_button();

		if(isset($_POST['isp']))
		{
			$this->form_validation->set_rules($this->isp_filter());

			if ($this->form_validation->run() == TRUE) :

				$mth = $this->input->post('month', TRUE);
				$year= $this->input->post('year', TRUE);
	 			$isp = $this->input->post('isp', TRUE);
	 			
	 			$period = strtotime(date($year.'-'.$mth));
			else :
				show_404();
			endif;
		}

		$data['isp'] 		= $this->sla_summary_m->get_isp_by_slug($isp);
		$data['monthly']	= $this->sla_summary_m->get_monthly($isp, $period);
		$data['chart']		= $this->sla_summary_m->chart($isp, $period);
		$data['isp_list']	= $this->sla_summary_m->get_isp();
		$data['title'] 		= $data['isp']['isp_name'];
		$data['slug'] 		= $data['isp']['slug'];
		$data['month'] 		= date('F Y', $period);
		$data['period'] 	= $period;
		
		$view = array(
			'sla-summary/header',
			'_templates/sidebar',
			'_templates/topbar',
			'sla-summary/monthly',
			'sla-summary/footer-monthly'
		);

		MY_App::view($view, $data);
	}

	public function index()
	{
		$this->access_control->check_role();

		if(isset($_POST['isp']))
		{
			$this->form_validation->set_rules($this->isp_filter());

			if ($this->form_validation->run() == TRUE) :

				$mth = $this->input->post('month', TRUE);
				$year= $this->input->post('year', TRUE);
	 			$isp = $this->input->post('isp', TRUE);
	 			
				redirect('sla-summary/period/'.strtotime(date($year.'-'.$mth)).'/'.$isp, 'location', 303);
			else :
				show_404();
			endif;
		}

		$data['title'] = 'Choose ISP';
		$data['isps']  = $this->sla_summary_m->get_isp();

		$view = array(
			'sla-summary/header-isp',
			'_templates/sidebar',
			'_templates/topbar',
			'sla-summary/isp',
			'sla-summary/footer-isp'
		);

		MY_App::view($view, $data);
	}

	public function get_sla()
	{
		$this->access_control->check_button();

		$post = $this->input->post(null, TRUE);
		
		if( ! isset($post['id'])) :
			return false;
		else :
			$token 	= array('token' => $this->security->get_csrf_hash());
			$data 	= $this->sla_summary_m->get_sla_by_id($post['id']);
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
			
			$this->form_validation->set_rules('sla_id', 'SLA ID', 'trim|required|regex_match[/[a-f0-9\-]+$/]|exact_length[36]');
			$this->form_validation->set_rules('isp_id', 'ISP Name', 'trim|required|integer');
			$this->form_validation->set_rules('downtime', 'Downtime', 'trim|callback_datetime_regex');
			$this->form_validation->set_rules('uptime', 'Uptime', 'trim|callback_datetime_regex');
			$this->form_validation->set_rules('cause', 'Cause', 'trim|required|regex_match[/^[a-zA-Z0-9 _,.&@!:\/\-]+$/]|max_length[512]');
			$this->form_validation->set_rules('solution', 'Solution', 'trim|regex_match[/^[a-zA-Z0-9 _,.&@!:\/\-]+$/]|max_length[512]');

			if ($this->form_validation->run() == TRUE) 
			{
				$update = $this->sla_summary_m->edit_sla($this->_form_data);
				if($update['status'] == true)
				{
					$this->_form_msg = 'SLA Edited';
					$this->_form_msg('success', $this->_form_msg);
				}
				else
				{
					$this->_form_msg[] = 'Failed to edit SLA';
					$this->_form_msg('form_error', $this->_form_msg);
				}
			} 
			else 
			{
				$this->_form_msg[] = validation_errors();
				$this->_form_msg('form_error', $this->_form_msg);
			}

			$this->_form_value($this->_form_data);
			redirect('sla-summary/period/'.$update['period'].'/'.$update['isp']);
		}
		else
		{
			redirect('sla-summary/isp');
		}
	}

	public function delete($id = NULL)
	{
		$this->access_control->check_button();

		if(!decrypt($id)) show_404();

		if($this->sla_summary_m->delete_sla($id) == true)
		{
			$this->_form_msg('success', 'SLA Record Deleted.');	
		}
		else
		{
			$this->_form_msg[] = 'Failed to Delete SLA Record.';
		}
		
		$this->_form_msg('form_error', $this->_form_msg);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function datetime_regex($str)
	{
		$match = preg_match('/^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$/', $str) ? true : false;

		if($match == false)
		{
			$this->form_validation->set_message('datetime_regex', 'The {field} field should a valid datetime format.');
		}
	}

	private function isp_filter()
	{
		$config = array(
			array(
				'field' => 'month',
				'label' => 'Month',
				'rules' => 'required|integer|exact_length[2]',
				'errors'=> array(
					'required' => '{field} is required.',
					'integer' => '{field} should integer.',
					'exact_length' => '{field} lenght must {param} character.'
				)
			),
			array(
				'field' => 'year',
				'label' => 'Year',
				'rules' => 'required|integer|exact_length[4]',
				'errors'=> array(
					'required' => '{field} is required.',
					'integer' => '{field} should integer.',
					'exact_length' => '{field} lenght must {param} character.'
				)
			),
			array(
				'field' => 'isp',
				'label' => 'ISP Name',
				'rules' => 'trim|required|regex_match[/[a-zA-Z0-9\-]+$/]',
				'errors'=> array(
					'required' => '{field} is required.',
					'regex_match' => '{field} should [a-zA-Z0-9\-].',
				)
			),
		);

		return $config;
	}
}