<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_m extends CI_Model
{
	public function count_device()
	{
		$this->db->select('a.group_label, a.group_icon, COUNT(b.group_code) AS total_device');
		$this->db->join('tb_devices b', 'a.group_code = b.group_code', 'left');
		$this->db->group_by('b.group_code');
		$this->db->order_by('a.group_label', 'asc');
		return $this->db->get('tb_dev_group a')->result_array();
	}

	public function count_apps()
	{
		$this->db->select('app_id');
		return $this->db->get('tb_application')->num_rows();
	}

	public function count_wifi()
	{
		$this->db->select('wifi_id');
		return $this->db->get('tb_wifi')->num_rows();
	}

	public function count_vm()
	{
		$this->db->select('vm_id');
		return $this->db->get('tb_vm')->num_rows();
	}

	public function count_network()
	{
		$this->db->select('network_id');
		return $this->db->get('tb_network')->num_rows();
	}

	public function count_hardware()
	{
		$this->db->select('a.hw_category, a.hw_icon, COUNT(b.category_code) AS total_hw');
		$this->db->join('tb_hardware b', 'a.hw_code = b.category_code', 'left');
		$this->db->group_by('b.category_code');
		$this->db->order_by('a.hw_category', 'asc');
		return $this->db->get('tb_hw_category a')->result_array();
	}

	public function get_log_device()
	{
		$this->db->select('date_format(action_date, "%Y-%m-%d") AS date_act,
							date_format(action_date, "%H:%i:%s") AS hour,
							action');
		$this->db->where('log_type !=', 'sla-summary');
		$this->db->order_by('action_date', 'desc');
		return $this->db->get('tb_logs', 15)->result_array();
	}

	public function get_log_sla()
	{
		$this->db->select('date_format(action_date, "%Y-%m-%d") AS date_act,
							date_format(action_date, "%H:%i:%s") AS hour,
							action');
		$this->db->where('log_type', 'sla-summary');
		$this->db->order_by('action_date', 'desc');
		return $this->db->get('tb_logs', 15)->result_array();
	}

	public function get_period()
	{
		$sql = "SELECT date_format(downtime, '%M %Y') AS period 
            				FROM tb_sla 
            				WHERE downtime BETWEEN 
            				(SELECT SUBDATE(MAX(downtime), INTERVAL '12' MONTH) FROM tb_sla) 
            				AND (SELECT MAX(downtime) FROM tb_sla)
				            GROUP BY date_format(downtime, '%Y-%m') 
				            ORDER BY downtime ASC LIMIT 12";
		return $this->db->query($sql)->result_array();
	}

	public function get_sla($isp_id)
	{
		$sql = "SELECT SUM(IF(isp_id = ?, duration, 0)) AS totalDown 
				          FROM tb_sla WHERE downtime BETWEEN 
				          (SELECT SUBDATE(MAX(downtime), INTERVAL '12' MONTH) FROM tb_sla) 
				          AND (SELECT MAX(downtime) FROM tb_sla)
				          GROUP BY date_format(downtime, '%Y-%m') 
				          ORDER BY downtime ASC LIMIT 12";
		return $this->db->query($sql, array($isp_id))->result_array();
	}

	public function get_subnet()
	{
		$this->db->select('a.network_type, b.subnet_id, b.ip_subnet, INET6_NTOA(b.min_ip) AS minip');
		$this->db->join('tb_network a', 'a.network_id = b.network_id', 'inner');
		$this->db->order_by('b.subnet_id', 'asc');
		return $this->db->get('tb_subnet b', 4, 30)->result_array();
	}

	public function add_ips($net_type, $subnet_id, $ip)
	{
		switch ($net_type) {
			case 'PRIVATE':
				$this->db->insert('tb_private_ip', ['subnet_id' => $subnet_id, 'ip_address' => inet_pton($ip)]);
				break;
			
			default:
				$this->db->insert('tb_public_ip', ['subnet_id' => $subnet_id, 'ip_address' => inet_pton($ip)]);
				break;
		}
	}
}

/* End of file dashboard_m.php */
/* Location: ./application/models/dashboard_m.php */