<?php
defined('BASEPATH') OR exit('No Direct Script Access Allowed');
/**
 *
 * Access Control Library
 *
 * This library controlled the module access and group access
 * for user and restrict area 
 *
 * @package	GovCSRIT Kota Tangerang
 * @author	debu_semesta
 * @copyright	Copyright (c) 2020, @__debu_semesta, DISKOMINFO Kota Tangerang
 * @link	https://instagram.com/__debu_semesta
 * @since	Version 1.0.0
 * @filesource
 * 
*/
class Access_control
{
	/**
	 * Logged User
	 * 
	 * @var string
	*/
	protected $uid = '';

	/**
	 * Logged User Level
	 * 
	 * @var string
	*/
	protected $gid = '';

	/**
	 * Menu or Page
	 * Default : dashboard
	 * 
	 * @var string
	 */
	protected $menu = 'dashboard';

	/**
	 * Submenu atau subpage
	 * 
	 * @var null
	*/
	protected $submenu = NULL;
	
	/**
	 * Parameter
	 * 
	 * @var null
	*/
	protected $param = NULL;

	/**
	 * Codeigniter Instance
	 * 
	 * @var object
	*/
	protected $ci;

	public function __construct(array $config)
	{
		$this->ci = get_instance();

		// Load Role model
		$this->ci->load->model('role_m');

		// Loop Library Configuration
		foreach ($config as $conf => $value) 
		{
			$this->$conf = $value;	
		}
	}

	// Method for prevent user accessing page with login required
	public function check_login()
	{
		if(empty($this->gid) && empty($this->uid)) redirect('signin');
	}

	public function is_login()
	{
		if( ! empty($this->gid) && ! empty($this->uid)) redirect('dashboard');
	}
	
	// Method for Verifiying Page Access by user group
	public function check_role()
	{
		$role = (empty($this->submenu) && empty($this->param)) ?
				$this->ci->role_m->check_menu($this->menu):
				$this->ci->role_m->check_submenu($this->menu.'/'.$this->submenu);
			
		if( ! empty($this->uid) && $role == 0) show_404();
	}

	// Method for Checking Button Access Menu
	public function check_button()
	{
		$role = $this->ci->role_m->check_button($this->menu.'/'.$this->submenu);
		if( ! empty($this->uid) && $role == 0) show_404();
	}
}