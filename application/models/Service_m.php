<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_m extends CI_Model
{
	public function allocated_ip($net_type, $net_id)
	{
		if($net_type == 'PRIVATE'):
			$table = 'tb_private_ip';
			$column = 'private_ip_id';
		else:
			$table = 'tb_public_ip';
			$column = 'public_ip_id';
		endif;

		$this->db->select('a.'.$column);
		$this->db->join('tb_subnet b', 'a.subnet_id = b.subnet_id', 'inner');
		$this->db->join('tb_network c', 'b.network_id = c.network_id', 'inner');
		$this->db->where('c.network_id', $net_id);
		$this->db->where('c.network_type', $net_type);
		return $this->db->get($table.' a')->num_rows();
	}

	public function used_ip($net_type, $net_id)
	{
		if($net_type == 'PRIVATE'):
			$table = 'tb_private_ip';
			$column = 'private_ip_id';
		else:
			$table = 'tb_public_ip';
			$column = 'public_ip_id';
		endif;

		$this->db->select('a.'.$column);
		$this->db->join('tb_subnet b', 'a.subnet_id = b.subnet_id', 'inner');
		$this->db->join('tb_network c', 'b.network_id = c.network_id', 'inner');
		$this->db->where('c.network_id', $net_id);
		$this->db->where('c.network_type', $net_type);
		$this->db->where('a.device_code IS NOT NULL');
		$this->db->order_by('b.network_id', 'asc');
		return $this->db->get($table.' a')->num_rows();
	}
	

}

/* End of file service_m.php */
/* Location: ./application/models/service_m.php */