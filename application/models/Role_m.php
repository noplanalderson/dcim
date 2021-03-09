<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_m extends CI_Model
{
	public function check_menu($menu)
	{
		$this->db->select('a.menu_id');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.menu_location', 'menu');
		$this->db->where('a.menu_link', $menu);
		$this->db->where('b.user_group_id', $this->session->userdata('gid'));
		return $this->db->get('tb_menus a')->num_rows();
	}
	
	public function check_submenu($menu)
	{
		$this->db->select('a.menu_id');
		$this->db->join('tb_menus b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->join('tb_roles c', 'b.menu_id = c.menu_id', 'inner');
		$this->db->where('a.menu_location', 'submenu');
		// $this->db->or_where('a.menu_location', 'content');
		$this->db->where('a.menu_link', $menu);
		$this->db->where('c.user_group_id', $this->session->userdata('gid'));
		return $this->db->get('tb_menus a')->num_rows();
	}

	public function check_button($menu)
	{
		$this->db->select('a.menu_id');
		$this->db->join('tb_menus b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->join('tb_roles c', 'b.menu_id = c.menu_id', 'inner');
		$this->db->where('a.menu_location', 'content');
		$this->db->where('a.menu_link', $menu);
		$this->db->where('c.user_group_id', $this->session->userdata('gid'));
		return $this->db->get('tb_menus a')->num_rows();
	}

	public function get_roles_by_ug($id)
	{
		$this->db->select('a.menu_label');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('b.user_group_id', $id);
		$this->db->order_by('a.menu_label', 'asc');
		$result = $this->db->get('tb_menus a');

		$data = $result->result_array();
		$count= $result->num_rows();

		if($count !== 0)
		{
			foreach ($data as $row) 
			{
				$roles[] = $row['menu_label'];
			}

			return implode(', ', $roles);
		}
	}

	public function get_menus()
	{
		$this->db->select('menu_id, menu_label');
		$this->db->order_by('menu_label', 'asc');
		return $this->db->get('tb_menus')->result_array();
	}

	public function check_user_group($group = NULL, $id = NULL)
	{
		$this->db->select('user_group');
		$this->db->where('user_group', $group);
		if(!is_null($id)) $this->db->where('md5(user_group_id) != ', decrypt($id));
		return $this->db->get('tb_user_group')->num_rows();
	}

	public function add_user_group($post = array())
	{
		$insert = $this->db->insert('tb_user_group', array('user_group' => $post['user_group'])) ? true : false;
		
		if($insert)
		{
			$id = $this->_get_group_id(strtolower($post['user_group']));
			$loop = count($post['roles']);

			for ($i = 0; $i < $loop; $i++)
			{
				$this->db->insert('tb_roles', array('user_group_id' => $id, 'menu_id' => $post['roles'][$i]));
			}

			return true;
		}
	}

	private function _get_selected_roles($id)
	{
		$this->db->select('menu_id');
		$this->db->where('md5(user_group_id)', $id);
		$result = $this->db->get('tb_roles');

		$data = $result->result_array();
		$count= $result->num_rows();

		if($count !== 0)
		{
			foreach ($data as $row) 
			{
				$roles[] = $row['menu_id'];
			}

			return implode(',', $roles);
		}
	}

	private function _get_group_id($group)
	{
		$this->db->select('user_group_id');
		$this->db->where('user_group', $group);
		
		$result = $this->db->get('tb_user_group', 1);
		$id = $result->row_array();

		return $id['user_group_id'];
	}

	public function get_group_by_id($id = NULL)
	{
		$id 	= decrypt($id);
		$roles 	= array('roles' => $this->_get_selected_roles($id));
		
		$this->db->where('md5(user_group_id)', $id);
		$level =  $this->db->get('tb_user_group')->row_array();

		return array_merge($level, $roles);
	}

	private function _delete_roles($group_id)
	{
		$this->db->where('user_group_id', $group_id);
		$delete = $this->db->delete('tb_roles');
		return $delete ? true : false;
	}

	public function edit_user_group($post = array())
	{
		$this->db->where('md5(user_group_id)', decrypt($post['id']));
		$update = $this->db->update('tb_user_group', array('user_group' => $post['user_group'])) ? true : false;

		if($update)
		{
			$id = $this->_get_group_id($post['user_group']);

			if($this->_delete_roles($id))
			{
				$loop = count($post['roles']);

				for ($i = 0; $i < $loop; $i++)
				{
					$this->db->insert('tb_roles', array('user_group_id' => $id, 'menu_id' => $post['roles'][$i]));
				}

				return true;
			}
		}
	}

	public function delete_group($id = NULL)
	{
		$this->db->where('md5(user_group_id)', decrypt($id));
		return $this->db->delete('tb_user_group') ? true : false;
	}

	public function get_button($menu)
	{
		$this->db->select('a.menu_label, a.menu_link, a.menu_icon');
		$this->db->join('tb_menus b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->join('tb_roles c', 'b.menu_id = c.menu_id', 'inner');
		$this->db->where('a.menu_link', $menu);
		$this->db->where('c.user_group_id', $this->session->userdata('gid'));
		return $this->db->get('tb_menus a')->row_array();
	}
}

/* End of file role_m.php */
/* Location: ./application/models/role_m.php */