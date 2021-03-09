<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hardwares_m extends CI_Model
{
	public function get_hardwares($group = NULL)
	{
		$this->db->select('a.*, b.hw_category, c.hw_manufacture');
		$this->db->join('tb_hw_category b', 'a.category_code = b.hw_code', 'left');
		$this->db->join('tb_hw_manufacture c', 'a.hw_manufacture_id = c.hw_manufacture_id', 'left');
		if(!is_null($group))
		{
			$this->db->where('b.hw_category', $group);
		}
		return $this->db->get('tb_hardware a')->result_array();
	}
	
	public function get_groups()
	{
		$this->db->select('hw_category');
		$this->db->order_by('hw_category', 'asc');
		return $this->db->get('tb_hw_category')->result_array();
	}

	public function get_hw_by_id($id = NULL)
	{
		$this->db->select('a.*, b.hw_category, c.hw_manufacture');
		$this->db->join('tb_hw_category b', 'a.category_code = b.hw_code', 'left');
		$this->db->join('tb_hw_manufacture c', 'a.hw_manufacture_id = c.hw_manufacture_id', 'left');
		$this->db->where('md5(a.hw_code)', decrypt($id));
		return $this->db->get('tb_hardware a')->row_array();
	}

	public function check_hw($category_code, $hw_number, $hw_code)
	{
		$this->db->select('hardware_id');
		$this->db->where('category_code', $category_code);
		$this->db->where('SPLIT_STRING(hw_code, ".", 1) = ', $hw_number);
		$this->db->where('md5(hw_code) != ', decrypt($hw_code));
		return $this->db->get('tb_hardware')->num_rows();
	}

	public function edit_hardware($hardware = array(), $hw_code)
	{
		$this->db->where('md5(hw_code)', decrypt($hw_code));
		if($this->db->update('tb_hardware', $hardware) == TRUE)
		{
			$config = array(
				'log_type' => 'hardware',
				'item' => $hardware['hw_code'],
				'pic' => $this->user['user_name'],
				'action' => 'updated',
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

	public function get_image($id = NULL)
	{
		$this->db->select('hw_code, hw_picture');
		$this->db->where('md5(hw_code)', decrypt($id));
		return $this->db->get('tb_hardware')->row();
	}

	public function delete_hardware($id = NULL)
	{
		$this->db->where('md5(hw_code)', decrypt($id));
		return $this->db->delete('tb_hardware') ? true : false;
	}

	public function get_hardwares_by_year($year = NULL)
	{
		$this->db->select('a.*, b.hw_category, c.hw_manufacture');
		$this->db->join('tb_hw_category b', 'a.category_code = b.hw_code', 'left');
		$this->db->join('tb_hw_manufacture c', 'a.hw_manufacture_id = c.hw_manufacture_id', 'left');
		if(!is_null($year)){
			$this->db->where('a.procurement', $year);
		}
		$this->db->order_by('b.hw_category', 'asc');
		$this->db->order_by('a.hw_code', 'asc');
		return $this->db->get('tb_hardware a')->result_array();
	}

	public function get_years()
	{
		$this->db->select('procurement');
		$this->db->group_by('procurement');
		$this->db->order_by('procurement', 'asc');
		return $this->db->get('tb_hardware')->result_array();
	}
}

/* End of file hard.php */
/* Location: ./application/models/hard.php */