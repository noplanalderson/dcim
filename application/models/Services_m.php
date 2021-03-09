<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_m extends CI_Model
{
	public function get_apps()
	{
		$this->db->select('a.app_id, a.app_address, a.notes, 
							INET6_NTOA(b.ip_address) ip_private, 
							INET6_NTOA(c.ip_address) ip_public,
							d.hostname AS vm_hostname,
							e.hostname AS hostname,
							e.device_code');
		$this->db->join('tb_private_ip b', 'a.app_id = b.app_id', 'left');
		$this->db->join('tb_public_ip c', 'a.app_id = c.app_id', 'left');
		$this->db->join('tb_vm d', 'b.vm_id = d.vm_id', 'left');
		$this->db->join('tb_dev_identity e', 'd.device_code = e.device_code', 'left');
		$this->db->order_by('a.app_id', 'asc');
		return $this->db->get('tb_application a')->result_array();
	}
	
	public function get_hostname($type = NULL, $service_id = NULL)
	{
		switch ($type) {
			case 'apps':
				$column = 'app_id';
				break;
			
			default:
				$column = 'wifi_id';
				break;
		}

		$hostname = [];

		$this->db->select('b.hostname');
		$this->db->join('tb_dev_identity b', 'a.device_code = b.device_code', 'left');
		$this->db->where('a.'.$column, $service_id);
		$hosts = $this->db->get('tb_private_ip a')->result_array();

		foreach ($hosts as $host)
		{
			$hostname[] = $host['hostname'];	
		}

		return implode(',', $hostname);
	}

	public function get_networks()
	{
		return $this->db->get('tb_network')->result_array();
	}

	private function _network_type($type)
	{
		if($type == 'PRIVATE'):
			$table = 'tb_private_ip';
			$column = 'private_ip_id';
		else:
			$table = 'tb_public_ip';
			$column = 'public_ip_id';
		endif;

		return array('table' => $table, 'column' => $column);
	}

	public function allocated_ip($type, $network_id)
	{
		$mode = $this->_network_type($type);

		$this->db->select('a.'.$mode['column']);
		$this->db->join('tb_subnet b', 'a.subnet_id = b.subnet_id', 'inner');
		$this->db->join('tb_network c', 'b.network_id = c.network_id', 'inner');
		$this->db->where('c.network_id', $network_id);
		return $this->db->get($mode['table'].' a')->num_rows();
	}

	public function used_ip($type, $network_id)
	{
		$mode = $this->_network_type($type);

		$this->db->select('a.'.$mode['column']);
		$this->db->join('tb_subnet b', 'a.subnet_id = b.subnet_id', 'inner');
		$this->db->join('tb_network c', 'b.network_id = c.network_id', 'inner');
		$this->db->where('c.network_id', $network_id);
		$this->db->where('a.device_code IS NOT NULL');
		return $this->db->get($mode['table'].' a')->num_rows();
	}

	public function get_ips($type, $network_id)
	{
		$mode = $this->_network_type($type);

		$this->db->select('a.'.$mode['column'].' AS address_id, INET6_NTOA(a.ip_address) AS ip_address, 
							a.device_code, a.is_active, b.subnet_id, b.subnet_label, b.ip_subnet,
							INET6_NTOA(b.min_ip) AS minip, INET6_NTOA(b.max_ip) AS maxip,
							b.vlan, c.hostname, e.group_label, f.network_type');
		$this->db->join('tb_subnet b', 'a.subnet_id = b.subnet_id', 'inner');
		$this->db->join('tb_dev_identity c', 'a.device_code = c.device_code', 'left');
		$this->db->join('tb_devices d', 'a.device_code = d.device_code', 'left');
		$this->db->join('tb_dev_group e', 'd.group_code = e.group_code', 'left');
		$this->db->join('tb_network f', 'b.network_id = f.network_id', 'inner');
		$this->db->where('md5(b.network_id)', decrypt($network_id));
		$this->db->order_by('a.'.$mode['column'], 'asc');
		return $this->db->get($mode['table'].' a')->result_array();
	}

	public function get_app_by_network($type, $address_id)
	{
		$mode = $this->_network_type($type);
		$apps = [];

		$this->db->select('b.app_address');
		$this->db->join('tb_application b', 'a.app_id = b.app_id', 'left');
		$this->db->where($mode['column'], $address_id);
		$data_apps = $this->db->get($mode['table'].' a')->result_array();

		foreach ($data_apps as $app)
		{
			$apps[] = $app['app_address'];	
		}

		return implode(', ', $apps);
	}

	public function get_wifi_by_network($type, $address_id)
	{
		$mode = $this->_network_type($type);
		$wifis = [];

		$this->db->select('b.wifi_ssid');
		$this->db->join('tb_wifi b', 'a.wifi_id = b.wifi_id', 'left');
		$this->db->where($mode['column'], $address_id);
		$data_wifi = $this->db->get($mode['table'].' a')->result_array();

		foreach ($data_wifi as $wifi)
		{
			$wifis[] = $wifi['wifi_ssid'];	
		}

		return implode(', ', $wifis);
	}

	public function get_vm_by_network($type, $address_id)
	{
		$mode = $this->_network_type($type);
		$vms = [];

		$this->db->select('b.hostname');
		$this->db->join('tb_vm b', 'a.vm_id = b.vm_id', 'left');
		$this->db->where($mode['column'], $address_id);
		$data_vm = $this->db->get($mode['table'].' a')->result_array();

		foreach ($data_vm as $vm)
		{
			$vms[] = $vm['hostname'];	
		}

		return implode(', ', $vms);
	}

	public function get_wifis()
	{
		$this->db->select('a.wifi_id, a.wifi_ssid, a.wifi_user, a.wifi_password, 
							INET6_NTOA(b.ip_address) private_ip, 
							INET6_NTOA(c.ip_address) public_ip,
							d.hostname, d.device_code');
		$this->db->join('tb_private_ip b', 'a.wifi_id = b.wifi_id', 'left');
		$this->db->join('tb_public_ip c', 'a.wifi_id = c.wifi_id', 'left');
		$this->db->join('tb_dev_identity d', 'b.device_code = d.device_code', 'left');
		$this->db->group_by('a.wifi_ssid');
		$this->db->order_by('a.wifi_ssid', 'asc');
		return $this->db->get('tb_wifi a')->result_array();
	}

	public function get_vms()
	{
		$this->db->select('a.vm_id, a.hostname, a.operating_system, a.os_architecture, 
							a.cores, a.mem_cap, a.hdd_cap, a.notes, 
							INET6_NTOA(b.ip_address) private_ip, 
							INET6_NTOA(c.ip_address) public_ip,
							d.hostname AS host');
		$this->db->join('tb_private_ip b', 'a.vm_id = b.vm_id', 'left');
		$this->db->join('tb_public_ip c', 'a.vm_id = c.vm_id', 'left');
		$this->db->join('tb_dev_identity d', 'a.device_code = d.device_code', 'left');
		$this->db->group_by('a.vm_id');
		$this->db->order_by('a.hostname', 'asc');
		return $this->db->get('tb_vm a')->result_array();
	}

	public function check_item($table, $column_1, $column_2, $param_1, $param_2)
	{
		$this->db->select($column_1);
		$this->db->where($column_1, $param_1);
		$this->db->where("md5($column_2) != ", decrypt($param_2));
		return $this->db->get($table, 1)->num_rows();
	}

	public function get_apps_by_id($param = NULL)
	{
		$this->db->where('md5(app_id)', decrypt($param));
		return $this->db->get('tb_application')->row_array();
	}

	public function get_wifi_by_id($param = NULL)
	{
		$this->db->select('wifi_id, wifi_ssid, wifi_user, wifi_password');
		$this->db->where('md5(wifi_id)', decrypt($param));
		return $this->db->get('tb_wifi')->row_array();
	}

	public function get_network_by_id($param = NULL)
	{
		$this->db->select('network_label, network_type, network_block, submask');
		$this->db->where('md5(network_id)', decrypt($param));
		return $this->db->get('tb_network')->row_array();
	}

	public function check_network_change($network_id = NULL, $network = NULL)
	{
		$this->db->select('network_id');
		$this->db->where('md5(network_id)', decrypt($network_id));
		$this->db->where('network_block', $network);
		$count =  $this->db->get('tb_network')->num_rows();

		if($count == 0)
		{
			$this->db->where('md5(network_id)', decrypt($network_id));
			$this->db->delete('tb_subnet');
		}
	}

	public function check_subnetwork_change($subnet_id = NULL, $subnet = NULL)
	{
		$this->db->select('subnet_id');
		$this->db->where('subnet_id', $subnet_id);
		$this->db->where('ip_subnet', $subnet);
		return $this->db->get('tb_subnet')->num_rows();
	}

	public function edit_app($param = NULL, $post = array())
	{
		$apps = array(
			'app_address' => $post['url'],
			'notes' => $post['notes']
		);

		$this->db->where('md5(app_id)', decrypt($param));
		$update = $this->db->update('tb_application', $apps) ? true : false;

		if($update)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'web/app '.$post['url'],
				'pic' => $this->user['user_name'],
				'action' => 'edited'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function edit_wifi($param = NULL, $post = array())
	{
		$wifi = array(
			'wifi_ssid' => $post['wifi_ssid'],
			'wifi_user' => $post['wifi_user'],
			'wifi_password' => $post['wifi_password']
		);

		$this->db->where('md5(wifi_id)', decrypt($param));
		$update = $this->db->update('tb_wifi', $wifi) ? true : false;

		if($update)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'wifi '.$post['wifi_ssid'],
				'pic' => $this->user['user_name'],
				'action' => 'edited'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function edit_network($param = NULL, $network = NULL, $post = array())
	{
		$net = array(
			'network_label' => $post['network_label'],
			'network_type' => $post['network_type'],
			'network_block' => $network,
			'submask' => $post['submask']
		);

		$this->db->where('md5(network_id)', decrypt($param));
		$update = $this->db->update('tb_network', $net) ? true : false;

		if($update)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'network '.$post['network_label'],
				'pic' => $this->user['user_name'],
				'action' => 'edited'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function get_vm_by_id($param = NULL)
	{
		$this->db->select('device_code, hostname, operating_system, os_architecture,
							cores, mem_cap, hdd_cap, notes');
		$this->db->where('md5(vm_id)', decrypt($param));
		return $this->db->get('tb_vm')->row_array();
	}


	public function edit_vm($param = NULL, $post = array())
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

		$this->db->where('md5(vm_id)', decrypt($param));
		$update = $this->db->update('tb_vm', $vm) ? true : false;

		if($update)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'vm '.$hostname,
				'pic' => $this->user['user_name'],
				'action' => 'edited'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function get_network_by_subnet($subnet_id = NULL)
	{
		$this->db->select('b.network_id, b.network_block, b.network_type, b.submask');
		$this->db->join('tb_network b', 'a.network_id = b.network_id', 'inner');
		$this->db->where('md5(a.subnet_id)', decrypt($subnet_id));
		return $this->db->get('tb_subnet a')->row_array();
	}

	public function get_subnet($param = NULL)
	{
		$this->db->where('md5(subnet_id)', decrypt($param));
		return $this->db->get('tb_subnet')->row_array();
	}

	public function edit_subnet($param = NULL, $subnetwork = NULL, $post = array())
	{
		$ip_range 	= cidr_to_range($subnetwork);

		if($this->check_subnetwork_change($post['subnet_id'], $subnetwork) == 0)
		{
			switch ($post['type']) {
				case 'PRIVATE':
					$table = 'tb_private_ip';
					break;
				
				default:
					$table = 'tb_public_ip';
					break;
			}

			$this->db->where('subnet_id', $post['subnet_id']);
			$this->db->delete($table);

			$ip_count = 1 << (32 - $post['netmask']);

			$start = ip2long($ip_range[0]);
				
			for ($i = 1; $i < ($ip_count - 1); $i++)
			{
				$ip = long2ip($start + $i);
				
				$object = array(
					'subnet_id' => $post['subnet_id'], 
					'device_code' => NULL,
					'app_id' => NULL,
					'wifi_id' => NULL,
					'vm_id' => NULL,
					'ip_address' => inet_pton($ip),
					'is_active' => 'Y'
				);
				$this->db->insert($table, $object);
			}
		}

		$subnet = array(
			'network_id' => $post['id'],
			'subnet_label' => $post['label'],
			'ip_subnet' => $subnetwork,
			'min_ip' => inet_pton($ip_range[0]),
			'max_ip' => inet_pton($ip_range[1]),
			'vlan' => $post['vlan']
		);

		$this->db->where('md5(subnet_id)', decrypt($param));
		$update = $this->db->update('tb_subnet', $subnet) ? true : false;

		if($update)
		{
			$config = array(
				'log_type' => 'service',
				'item' => 'sub network '.$post['label'],
				'pic' => $this->user['user_name'],
				'action' => 'edited'
			);
			$this->load->library('logging');
			$this->logging->initialize($config);
			$this->logging->add_log();

			return true;
		}
	}

	public function use_ip($post = [])
	{
		$mode = $this->_network_type($post['network_type']);

		$device = !empty($post['device_code']) ? $post['device_code'] : NULL;
		$app 	= !empty($post['app_id']) ? $post['app_id'] : NULL;
		$wifi 	= !empty($post['wifi_id']) ? $post['wifi_id'] : NULL;
		$vm 	= !empty($post['vm_id']) ? $post['vm_id'] : NULL;
		$id 	= explode('/', $post['id_ip']);

		$object = array(
			'device_code' => $device,
			'app_id' => $app,
			'wifi_id' => $wifi,
			'vm_id' => $vm
		);

		$this->db->where("md5($mode[column])", decrypt($id[1]));
		return $this->db->update($mode['table'], $object) ? true : false;
	}

	public function get_network_by_ip($type, $id)
	{
		$mode = $this->_network_type($type);

		$this->db->select('c.network_id');
		$this->db->join('tb_subnet b', 'a.subnet_id = b.subnet_id', 'inner');
		$this->db->join('tb_network c', 'b.network_id = c.network_id', 'inner');
		$this->db->where('md5(a.'.$mode['column'].')', decrypt($id));
		$id = $this->db->get($mode['table'].' a')->row_array();

		return $id['network_id'];
	}

	public function block_ip($type, $id)
	{
		$mode = $this->_network_type($type);

		$object = array(
			'device_code' => NULL,
			'app_id' => NULL,
			'wifi_id' => NULL,
			'vm_id' => NULL,
			'is_active' => 'N'
		);

		$this->db->where("md5($mode[column])", decrypt($id));
		return $this->db->update($mode['table'], $object) ? true : false;
	}

	public function allow_ip($type, $id)
	{
		$mode = $this->_network_type($type);

		$this->db->where("md5($mode[column])", decrypt($id));
		return $this->db->update($mode['table'], ['is_active' => 'Y']) ? true : false;
	}

	public function delete_app($id = NULL)
	{
		$this->db->where('md5(app_id)', decrypt($id));
		return $this->db->delete('tb_application') ? true : false;
	}

	public function delete_wifi($id = NULL)
	{
		$this->db->where('md5(wifi_id)', decrypt($id));
		return $this->db->delete('tb_wifi') ? true : false;
	}

	public function delete_network($id = NULL)
	{
		$this->db->where('md5(network_id)', decrypt($id));
		return $this->db->delete('tb_network') ? true : false;
	}

	public function delete_subnet($id = NULL)
	{
		$this->db->select('b.network_id, b.network_type');
		$this->db->join('tb_network b', 'a.network_id = b.network_id', 'inner');
		$this->db->where('md5(subnet_id)', decrypt($id));
		$result = $this->db->get('tb_subnet a')->row_array();

		$this->db->where('md5(subnet_id)', decrypt($id));
		$delete = $this->db->delete('tb_subnet') ? true : false;

		return array(
			'result' => $delete,
			'type' => $result['network_type'],
			'network_id' => $result['network_id']
 		);
	}

	public function delete_vm($id = NULL)
	{
		$this->db->where('md5(vm_id)', decrypt($id));
		return $this->db->delete('tb_vm') ? true : false;
	}
}

/* End of file services_m.php */
/* Location: ./application/models/services_m.php */