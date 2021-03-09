<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_App
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('search_term_m');
		$this->load->model('service_m');

		$this->access_control->check_login();
	}

	public function index()
	{
		if(isset($_POST['type']) && isset($_POST['q']))
		{
			$this->_rules();

			if ($this->form_validation->run() == TRUE) 
			{
				$type = $this->input->post('type', TRUE);
				$query= $this->input->post('q', TRUE);
				
				if($type == 'apps') 
				{
					if( ! filter_var($query, FILTER_VALIDATE_IP))
					{
						$url = parse_url($query);
						$query = $url['host'];
					}
				}
				elseif($type == 'network')
				{
					$ip = explode('/', $query);
					$query = $ip[0];
				}

				redirect('search/term/'.$type.'/'.rawurlencode($query), 'location', 303);
			}
			else
			{
				redirect('search/term/error', 'location', 303);
			}
		}
		else
		{
			redirect('search/term');
		}
	}

	private function _rules()
	{
		$config = array(
			array(
				'field' => 'type',
			  	'label' => 'Type',
				'rules' => 'trim|required|alpha',
				'errors'=> array('required' => 'Please choose {field} of search', 'alpha' => '{field} should alphabet')
			),
			array(
				'field' => 'q',
				'label' => 'Query Search',
				'rules' => 'trim|required|regex_match[/^[a-zA-Z0-9 ._:@\/\-]+$/]|max_length[255]',
				'errors'=> array(
					'required' => '{field} is required', 
					'regex_match' => 'Permitted characters for {field} are [a-zA-Z0-9 ._:@\/\-]',
					'max_length' => '{field} maximum {param} characters'
				)
			)
		);

		$this->form_validation->set_rules($config);
	}

	public function term($type = NULL, $query = NULL)
	{
		$this->access_control->check_button();

		$data['search'] = rawurldecode($query);

		switch ($type) 
		{
			case 'hardware':
				$data['hardwares'] = $this->search_term_m->get_hw_by_term($data['search']);
				$content = 'search/hardware';
				break;
			
			case 'device':
				$data['devices'] = $this->search_term_m->get_device_by_term($data['search']);
				$content = 'search/device';
				break;

			case 'apps':
				$data['apps'] = $this->search_term_m->get_apps_by_term($data['search']);
				$content = 'search/apps';
				break;

			case 'wifi':
				$data['wifis'] = $this->search_term_m->get_wifi_by_term($data['search']);
				$content = 'search/wifi';
				break;

			case 'network':
				$data['networks'] = $this->search_term_m->get_net_by_term($data['search']);
				$content = 'search/network';
				break;
				
			default:
				$data['search']  = 'Result not Found';
				$data['heading'] = 'Result not Found!';
				$data['message'] = 'The item you are looking for was not found. Try other keywords to find the item you are looking for.';
				$content = 'search/error';
				break;
		}

		$view = array(
			'search/header',
			'_templates/sidebar',
			'_templates/topbar',
			$content,
			'search/footer'
		);
		MY_App::view($view, $data);
	}

	public function data_json()
	{
		$array = array_merge($this->search_term_m->get_dev_code(), 
								$this->search_term_m->get_dev_manufacture(),
								$this->search_term_m->get_hostname(),
								$this->search_term_m->get_hw_manufacture(),
								$this->search_term_m->get_hw_code(),
								$this->search_term_m->get_apps(),
								$this->search_term_m->get_wifi(),
								$this->search_term_m->get_networks(),
								$this->search_term_m->get_network_desc()
							);
		echo json_encode($array);
	}

}

/* End of file search.php */
/* Location: ./application/controllers/search.php */