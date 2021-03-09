<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_term_m extends CI_Model
{
	public function get_dev_code()
	{
		$this->db->select('device_code AS data');
		return $this->db->get('tb_devices')->result_array();
	}

	public function get_dev_manufacture()
	{
		$this->db->select('dev_manufacture AS data');
		return $this->db->get('tb_dev_manufacture')->result_array();
	}

	public function get_hostname()
	{
		$this->db->select('hostname AS data');
		return $this->db->get('tb_dev_identity')->result_array();
	}

	public function get_hw_code()
	{
		$this->db->select('hw_code AS data');
		return $this->db->get('tb_hardware')->result_array();
	}

	public function get_hw_manufacture()
	{
		$this->db->select('hw_manufacture AS data');
		return $this->db->get('tb_hw_manufacture')->result_array();
	}

	public function get_apps()
	{
		$this->db->select('app_address AS data');
		return $this->db->get('tb_application')->result_array();
	}

	public function get_wifi()
	{
		$this->db->select('wifi_ssid AS data');
		return $this->db->get('tb_wifi')->result_array();
	}

	public function get_networks()
	{
		$this->db->select('network_block AS data');
		return $this->db->get('tb_network')->result_array();
	}

	public function get_network_desc()
	{
		$this->db->select('network_label AS data');
		return $this->db->get('tb_network')->result_array();
	}

	public function get_device_by_term($term)
	{
		$this->db->select('a.device_code, a.processor_type, a.cores, 
							a.memory_model, a.memory_cap, a.hdd_model, a.hdd_cap,
							b.serial_number, b.procurement, b.device_location,
							b.rack_number, b.hostname, b.device_status, b.device_owner,
							c.dev_manufacture, d.dev_model, e.group_label');
		$this->db->join('tb_dev_identity b', 'a.device_code = b.device_code', 'inner');
		$this->db->join('tb_dev_manufacture c', 'a.dev_manufacture_id = c.dev_manufacture_id', 'left');
		$this->db->join('tb_dev_model d', 'a.dev_model_id = d.dev_model_id', 'left');
		$this->db->join('tb_dev_group e', 'a.group_code = e.group_code', 'left');
		$this->db->like('e.group_label', $term, 'BOTH');
		$this->db->or_like('a.device_code', $term, 'BOTH');
		$this->db->or_like('b.hostname', $term, 'BOTH');
		$this->db->or_like('c.dev_manufacture', $term, 'BOTH');
		$this->db->order_by('a.device_code', 'asc');
		$this->db->order_by('b.hostname', 'asc');
		return $this->db->get('tb_devices a')->result_array();
	}

	public function get_hw_by_term($term)
	{
		$this->db->select('a.hw_code, a.hw_model, a.capacity, 
							a.procurement, a.hw_quantity, a.capacity_unit, 
							a.notes, a.hw_status, b.hw_manufacture, c.hw_category');
		$this->db->join('tb_hw_manufacture b', 'a.hw_manufacture_id = b.hw_manufacture_id', 'left');
		$this->db->join('tb_hw_category c', 'a.category_code = c.hw_code', 'left');
		$this->db->like('a.hw_code', $term, 'BOTH');
		$this->db->or_like('a.hw_model', $term, 'BOTH');
		$this->db->or_like('b.hw_manufacture', $term, 'BOTH');
		$this->db->or_like('c.hw_category', $term, 'BOTH');
		$this->db->order_by('c.hw_category', 'asc');
		$this->db->order_by('a.hw_code', 'asc');
		return $this->db->get('tb_hardware a')->result_array();
	}

	public function get_apps_by_term($term)
	{
		$this->db->select('a.app_id, a.app_address, a.notes, 
							INET6_NTOA(b.ip_address) private_ip, 
							INET6_NTOA(c.ip_address) public_ip,
							d.hostname AS vm_hostname,
							e.hostname AS hostname,
							e.device_code');
		$this->db->join('tb_private_ip b', 'a.app_id = b.app_id', 'left');
		$this->db->join('tb_public_ip c', 'a.app_id = c.app_id', 'left');
		$this->db->join('tb_vm d', 'b.vm_id = d.vm_id', 'left');
		$this->db->join('tb_dev_identity e', 'd.device_code = e.device_code', 'left');
		$this->db->like('a.app_address', $term, 'BOTH');
		$this->db->like('e.hostname', $term, 'BOTH');
		$this->db->or_like('INET6_NTOA(b.ip_address)', $term, 'BOTH');
		$this->db->or_like('INET6_NTOA(c.ip_address)', $term, 'BOTH');
		$this->db->order_by('a.app_id', 'asc');
		return $this->db->get('tb_application a')->result_array();
	}

	public function get_net_by_term($term)
	{
		$this->db->select('network_id, network_type, network_label, network_block');
		$this->db->like('network_block', $term, 'BOTH');
		$this->db->or_like('network_label', $term, 'BOTH');
		$this->db->order_by('network_label', 'asc');
		$this->db->order_by('network_id', 'asc');
		return $this->db->get('tb_network')->result_array();
	}

	public function get_wifi_by_term($term)
	{
		$this->db->select('a.wifi_id, a.wifi_ssid, a.wifi_user, a.wifi_password, 
							INET6_NTOA(b.ip_address) private_ip, 
							INET6_NTOA(c.ip_address) public_ip,
							d.hostname, d.device_code');
		$this->db->join('tb_private_ip b', 'a.wifi_id = b.wifi_id', 'left');
		$this->db->join('tb_public_ip c', 'a.wifi_id = c.wifi_id', 'left');
		$this->db->join('tb_dev_identity d', 'b.device_code = d.device_code', 'left');
		$this->db->like('a.wifi_ssid', $term, 'BOTH');
		$this->db->or_like('d.hostname', $term, 'BOTH');
		$this->db->or_like('INET6_NTOA(b.ip_address)', $term, 'BOTH');
		$this->db->or_like('INET6_NTOA(c.ip_address)', $term, 'BOTH');
		$this->db->group_by('a.wifi_ssid');
		$this->db->order_by('a.wifi_ssid', 'asc');
		return $this->db->get('tb_wifi a')->result_array();
	}
	

}

/* End of file search_term_m.php */
/* Location: ./application/models/search_term_m.php */