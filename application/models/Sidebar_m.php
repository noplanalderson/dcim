<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sidebar_m extends CI_Model
{
	public function menu_group()
	{
		$this->db->select('a.menu_group_id, a.menu_group');
		$this->db->join('tb_menus b', 'a.menu_group_id = b.menu_group_id', 'inner');
		$this->db->join('tb_roles c', 'b.menu_id = c.menu_id', 'inner');
		$this->db->where('c.user_group_id', $this->session->userdata('gid'));
		$this->db->group_by('b.menu_group_id');
		$this->db->order_by('a.menu_group_id', 'asc');
		return $this->db->get('tb_group_menu a')->result_array();
	}

	// public function menus($menu_group)
	// {
	// 	$this->db->select('a.menu_id, a.menu_group_id, a.menu_label, a.menu_icon, a.menu_link');
	// 	$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
	// 	$this->db->where('a.menu_location', 'sidebar');
	// 	$this->db->where('b.user_group_id', $this->session->userdata('gid'));
	// 	$this->db->where('a.menu_group_id', $menu_group);
	// 	$this->db->order_by('a.menu_sequence', 'asc');
	// 	return $this->db->get('tb_menu a')->result_array();
	// }

	// public function submenus($menu_id)
	// {
	// 	$this->db->where('menu_id', $menu_id);
	// 	$this->db->where('submenu_location', 'sidebar');
	// 	$this->db->order_by('submenu_id', 'asc');
	// 	return $this->db->get('tb_submenu')->result_array();
	// }
	
	public function menus($menu_group)
	{
		$this->db->select('a.menu_id, a.menu_group_id, a.menu_label, a.menu_icon, a.menu_link');
		$this->db->join('tb_roles b', 'a.menu_id = b.menu_id', 'inner');
		$this->db->where('a.menu_location', 'menu');
		$this->db->where('b.user_group_id', $this->session->userdata('gid'));
		$this->db->where('a.menu_group_id', $menu_group);
		$this->db->order_by('a.menu_sequence', 'asc');
		return $this->db->get('tb_menus a')->result_array();
	}

	public function submenus($menu_id)
	{
		$this->db->where('menu_parent', $menu_id);
		$this->db->where('menu_location', 'submenu');
		$this->db->order_by('menu_sequence', 'asc');
		return $this->db->get('tb_menus')->result_array();
	}
}

/* End of file sidebar.php */
/* Location: ./application/models/sidebar.php */