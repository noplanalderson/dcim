<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilities_m extends CI_Model
{
	public function get_dev_groups()
	{
		$this->db->order_by('group_code', 'asc');
		return $this->db->get('tb_dev_group')->result_array();
	}
	
	public function get_dev_manufactures()
	{
		$this->db->select('a.*, b.group_label');
		$this->db->join('tb_dev_group b', 'a.group_id = b.group_id', 'left');
		$this->db->order_by('a.dev_manufacture_id', 'asc');
		return $this->db->get('tb_dev_manufacture a')->result_array();
	}

	public function get_dev_models()
	{
		$this->db->select('a.*, b.dev_manufacture');
		$this->db->join('tb_dev_manufacture b', 'a.dev_manufacture_id = b.dev_manufacture_id', 'left');
		$this->db->order_by('a.dev_model_id', 'asc');
		return $this->db->get('tb_dev_model a')->result_array();
	}

	public function get_hw_groups()
	{
		$this->db->order_by('hw_code', 'asc');
		return $this->db->get('tb_hw_category')->result_array();
	}

	public function get_hw_manufactures()
	{
		$this->db->select('a.*, b.hw_category');
		$this->db->join('tb_hw_category b', 'a.hw_category_id = b.hw_category_id', 'left');
		$this->db->order_by('a.hw_manufacture_id', 'asc');
		return $this->db->get('tb_hw_manufacture a')->result_array();
	}

	public function check_utils($table, $comparison = [], $or_comparison = [], $not_comparison = [])
	{
		foreach ($comparison as $column => $value) {
			$this->db->where($column, $value);
		}
		if(!empty($or_comparison))
		{
			foreach ($or_comparison as $column => $value) {
				$this->db->or_where($column, $value);
			}
		}

		if(!empty($not_comparison))
		{
			foreach ($not_comparison as $column => $value) {
				$this->db->where('md5('.$column.') != ', $value);
			}
		}
		return $this->db->get($table)->num_rows();
	}

	public function add_manufacture($post = [])
	{
		$manufacture = array(
			'group_id' => $post['device_group'], 
			'dev_manufacture' => strtoupper($post['manufacture_name'])
		);

		$insert = $this->db->insert('tb_dev_manufacture', $manufacture) ? true : false;
		return $insert;
	}

	public function add_dev_model($post = [])
	{
		$model = array(
			'dev_manufacture_id' => $post['manufacture'], 
			'dev_model' => strtoupper($post['model'])
		);

		$insert = $this->db->insert('tb_dev_model', $model) ? true : false;
		return $insert;
	}

	public function add_dev_group($post = [])
	{
		$group = array(
			'group_code' => strtoupper($post['group_code']),
			'group_label' => $post['dev_group'], 
			'group_icon' => $post['dev_icon']
		);

		$insert = $this->db->insert('tb_dev_group', $group) ? true : false;
		return $insert;
	}

	public function add_hw_manufacture($post = [])
	{
		$manufacture = array(
			'hw_manufacture' => $post['hw_manufacture'], 
			'hw_category_id' => strtoupper($post['hw_group'])
		);

		$insert = $this->db->insert('tb_hw_manufacture', $manufacture) ? true : false;
		return $insert;
	}

	public function add_hw_group($post = [])
	{
		$group = array(
			'hw_code' => strtoupper($post['hw_code']),
			'hw_category' => $post['hw_group_name'], 
			'hw_icon' => $post['hw_icon']
		);

		$insert = $this->db->insert('tb_hw_category', $group) ? true : false;
		return $insert;
	}

	public function delete_manufacture($id = NULL)
	{
		$this->db->where('md5(dev_manufacture_id)', decrypt($id));
		return $this->db->delete('tb_dev_manufacture') ? true : false;
	}

	public function delete_model($id = NULL)
	{
		$this->db->where('md5(dev_model_id)', decrypt($id));
		return $this->db->delete('tb_dev_model') ? true : false;
	}

	public function delete_group($id = NULL)
	{
		$this->db->where('md5(group_id)', decrypt($id));
		$result = $this->db->delete('tb_dev_group') ? true : false;

		if($result == true)
		{
			$this->db->where('group_code IS NULL');
			$this->db->update('tb_devices', array('group_code' => 'UC'));
		}

		return $result;
	}

	public function delete_hw_manufacture($id = NULL)
	{
		$this->db->where('md5(hw_manufacture_id)', decrypt($id));
		return $this->db->delete('tb_hw_manufacture') ? true : false;
	}

	public function delete_hw_group($id = NULL)
	{
		$this->db->where('md5(hw_category_id)', decrypt($id));
		$result = $this->db->delete('tb_hw_category') ? true : false;

		if($result == true)
		{
			$this->db->where('category_code IS NULL');
			$this->db->update('tb_hardware', array('category_code' => 'UC'));
		}

		return $result;
	}

	public function getDataByID($table, $column, $param)
	{
		$this->db->where('md5('.$column.')', decrypt($param));
		return $this->db->get($table)->row_array();
	}

	public function edit_manufacture(array $data, $id)
	{
		$this->db->where('md5(dev_manufacture_id)', decrypt($id));
		return (bool) $this->db->update('tb_dev_manufacture', $data);
	}

	public function edit_dev_model(array $data, $id)
	{
		$this->db->where('md5(dev_model_id)', decrypt($id));
		return (bool) $this->db->update('tb_dev_model', $data);
	}

	public function edit_dev_group(array $data, $id)
	{
		$this->db->where('md5(group_id)', decrypt($id));
		return (bool) $this->db->update('tb_dev_group', $data);
	}

	public function edit_hw_manufacture(array $data, $id)
	{
		$this->db->where('md5(hw_manufacture_id)', decrypt($id));
		return (bool) $this->db->update('tb_hw_manufacture', $data);
	}

	public function edit_hw_group(array $data, $id)
	{
		$this->db->where('md5(hw_category_id)', decrypt($id));
		return (bool) $this->db->update('tb_hw_category', $data);
	}
}

/* End of file utilities_m.php */
/* Location: ./application/models/utilities_m.php */