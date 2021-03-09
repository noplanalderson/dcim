<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subnet_m extends CI_Model
{
	public function get_apps()
	{
		$this->db->select('app_id, app_address, notes');
		$this->db->order_by('app_address', 'asc');
		return $this->db->get('tb_application')->result_array();
		// $sql = "SELECT `a`.`app_id`, `a`.`app_address` FROM `tb_application` `a` 
		// 		WHERE NOT EXISTS (SELECT 1 FROM `tb_private_ip` `b` WHERE `a`.`app_id` = `b`.`app_id`)";
		// return $this->db->query($sql)->result_array();
	}

	public function get_wifis()
	{
		$this->db->select('wifi_id, wifi_ssid');
		$this->db->order_by('wifi_ssid', 'asc');
		return $this->db->get('tb_wifi')->result_array();
		// $sql = "SELECT `a`.`wifi_id`, `a`.`wifi_ssid` FROM `tb_wifi` `a` 
		// 		WHERE NOT EXISTS (SELECT 1 FROM `tb_private_ip` `b` WHERE `a`.`wifi_id` = `b`.`wifi_id`)";
		// return $this->db->query($sql)->result_array();
	}

	public function get_svc_by_id($type, $id)
	{
		switch ($type)
		{
			case 'PRIVATE':
				$tbl = 'tb_private_ip';
				$col = 'private_ip_id';
				break;
			
			default:
				$tbl = 'tb_public_ip';
				$col = 'public_ip_id';
				break;
		}

		$this->db->select($col.' AS address_id, device_code, app_id, wifi_id, vm_id');
		$this->db->where("md5($col)", decrypt($id));
		return $this->db->get($tbl)->row_array();
	}
}

/* End of file subnet_m.php */
/* Location: ./application/models/subnet_m.php */