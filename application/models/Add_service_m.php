<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_service_m extends CI_Model
{
	public function get_ip_public()
	{
		$this->db->select('INET6_NTOA(ip_address) ip');
		$this->db->where('is_active', 'Y');
		return $this->db->get('tb_public_ip')->result_array();
	}
	
	public function get_ip_private()
	{
		$this->db->select('INET6_NTOA(ip_address) ip');
		$this->db->where('is_active', 'Y');
		return $this->db->get('tb_private_ip')->result_array();
	}

	public function get_devices()
	{
		$this->db->select('device_code, hostname');
		return $this->db->get('tb_dev_identity')->result_array();
	}

	public function get_network_by_id($network_id = NULL)
	{
		$this->db->where('md5(network_id)', decrypt($network_id));
		return $this->db->get('tb_network')->row_array();
	}

	public function add_apps($post = array())
	{
		$apps = array(
			'app_address' => $post['url'],
			'notes' => $post['notes']
		);

		$insert = $this->db->insert('tb_application', $apps) ? true : false;

		if($insert)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'web/app '.$post['url'],
				'pic' => $this->user['user_name'],
				'action' => 'added'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function add_wifi($post = array())
	{
		$wifi = array(
			'wifi_ssid' => $post['wifi_ssid'],
			'wifi_user' => $post['wifi_user'],
			'wifi_password' => $post['wifi_password']
		);

		$insert = $this->db->insert('tb_wifi', $wifi) ? true : false;

		if($insert)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'wifi '.$post['wifi_ssid'],
				'pic' => $this->user['user_name'],
				'action' => 'added'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	private function _check_network($table = NULL, $column = NULL, $network = NULL)
	{
		$this->db->select($column);
		$this->db->where($column, $network);
		return $this->db->get($table)->num_rows();
	}

	public function add_network($post = array())
	{
		$network = array(
			'network_label' => $post['network_label'],
			'network_type' => $post['network_type'],
			'network_block' => $post['a'].'.'.$post['b'].'.'.$post['c'].'.'.$post['d'].'/'.$post['mask'],
			'submask' => $post['submask']
		);

		if($this->_check_network('tb_network', 'network_block', $network['network_block']) == 0)
		{
			$insert = $this->db->insert('tb_network', $network) ? true : false;
			
			if($insert)
			{
				$config = array(
					'log_type' => 'service',
					'item' => 'network '.$network['network_block'],
					'pic' => $this->user['user_name'],
					'action' => 'added'
				);
				$this->load->library('logging');
				$this->logging->initialize($config);
				$this->logging->add_log();

				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	private function _check_vm($device_code, $hostname)
	{
		$this->db->select('vm_id');
		$this->db->where('device_code', $device_code);
		$this->db->where('hostname', $hostname);
		return $this->db->get('tb_vm')->num_rows();
	}

	public function add_vm($post = array())
	{
		$hostname = empty($post['hostname']) ? 'localhost' : strtolower($post['hostname']);
		$os 	  = empty($post['operating_system']) ? NULL : $post['operating_system'];
		$os_arch  = empty($post['os_arch']) ? NULL : $post['os_arch'];
		$cores 	  = empty($post['cores']) ? NULL : $post['cores'];
		$mem_cap  = empty($post['mem_cap']) ? NULL : $post['mem_cap'];
		$hdd_cap  = empty($post['hdd_cap']) ? NULL : $post['hdd_cap'];
		$notes 	  = empty($post['notes']) ? NULL : $post['notes'];

		$vm = array(
			'device_code' => $post['device'],
			'hostname' => $hostname,
			'operating_system' => $os,
			'os_architecture' => $os_arch,
			'cores' => $cores,
			'mem_cap' => $mem_cap,
			'hdd_cap' => $hdd_cap,
			'notes' => $notes
		);

		if($this->_check_vm($vm['device_code'], $vm['hostname']) == 0)
		{
			$insert = $this->db->insert('tb_vm', $vm) ? true : false;
			
			if($insert)
			{
				$config = array(
					'log_type' => 'service',
					'item' => 'VM '.$vm['hostname'],
					'pic' => $this->user['user_name'],
					'action' => 'added'
				);
				$this->load->library('logging');
				$this->logging->initialize($config);
				$this->logging->add_log();

				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	private function _get_subnet_id()
	{
		$this->db->select('MAX(subnet_id) AS latest_id');
		$subnet = $this->db->get('tb_subnet', 1)->row();
		return $subnet->latest_id;
	}

	private function _insert_ips($table, $ip)
	{
		$object = array(
			'subnet_id' => $this->_get_subnet_id(), 
			'device_code' => NULL,
			'app_id' => NULL,
			'wifi_id' => NULL,
			'vm_id' => NULL,
			'ip_address' => inet_pton($ip),
			'is_active' => 'Y'
		);
		$insert = $this->db->insert($table, $object);
		return $insert ? true : false;
	}

	public function add_subnet($post = array())
	{
		$subnet_cidr= $post['a'].'.'.$post['b'].'.'.$post['c'].'.'.$post['d'].'/'.$post['netmask'];
		$ip_range 	= cidr_to_range($subnet_cidr);

		$subnet = array(
			'network_id' => $post['id'],
			'subnet_label' => $post['label'],
			'ip_subnet' => $subnet_cidr,
			'min_ip' => inet_pton($ip_range[0]),
			'max_ip' => inet_pton($ip_range[1]),
			'vlan' => $post['vlan']
		);

		if($this->_check_network('tb_subnet', 'ip_subnet', $subnet_cidr) == 0)
		{
			$insert = $this->db->insert('tb_subnet', $subnet) ? true : false;
			
			if($insert)
			{
				$ip_count = 1 << (32 - $post['netmask']);

				$start = ip2long($ip_range[0]);
					
				for ($i = 1; $i < ($ip_count - 1); $i++)
				{
					$ip = long2ip($start + $i);
					if ($post['type'] == 'PRIVATE'):
						$this->_insert_ips('tb_private_ip', $ip);
					else:
						$this->_insert_ips('tb_public_ip', $ip);
					endif;
				}

				$config = array(
					'log_type' => 'service',
					'item' => 'subnet '.$subnet_cidr,
					'pic' => $this->user['user_name'],
					'action' => 'added'
				);
				$this->load->library('logging');
				$this->logging->initialize($config);
				$this->logging->add_log();

				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}

/* End of file add_service_m.php */
/* Location: ./application/models/add_service_m.php */