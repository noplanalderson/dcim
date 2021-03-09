<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_hardware_m extends CI_Model
{
	public function get_hw_categories()
	{
		$this->db->order_by('hw_category', 'asc');
		return $this->db->get('tb_hw_category')->result_array();
	}
	
	public function get_hw_manufactures($hw_category_id = NULL)
	{
		if(!is_null($hw_category_id))
		{
			$this->db->where('hw_category_id', $hw_category_id);
		}
		$this->db->select('hw_manufacture_id, hw_manufacture');
		$this->db->order_by('hw_manufacture', 'asc');
		return $this->db->get('tb_hw_manufacture')->result_array();
	}

	public function get_hw_models()
	{
		$this->db->select('hw_model');
		$this->db->where('hw_model != ', '');
		$this->db->or_where('hw_model IS NOT NULL');
		$this->db->group_by('hw_model');
		$this->db->order_by('hw_model', 'asc');
		return $this->db->get('tb_hardware')->result_array();
	}

	public function check_hw($hw_code, $hw_number)
	{
		$this->db->select('hardware_id');
		$this->db->where('category_code', $hw_code);
		$this->db->where('SPLIT_STRING(hw_code, ".", 1) = ', $hw_number);
		return $this->db->get('tb_hardware')->num_rows();
	}

	public function add_hardware($hardware = array())
	{
		if($this->db->insert('tb_hardware', $hardware) == TRUE)
		{
			$config = array(
				'log_type' => 'hardware',
				'item' => $hardware['hw_code'],
				'pic' => $this->user['user_name'],
				'action' => 'added',
				'obj_link' => '#'
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
}

/* End of file add_hardware_m.php */
/* Location: ./application/models/add_hardware_m.php */