<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logging
{
	private $log_type = 'device';

	private $pic = '';

	private $action = '';

	private $item = '';

	private $log = '';

	private $obj_link = '#';

	protected $_CI;

    public function __construct(array $config = array())
    {
    	$this->_CI =& get_instance();
    	empty($config) OR $this->initialize($config, FALSE);
    }

    public function initialize(array $config = array(), $reset = TRUE)
    {
    	$reflection = new ReflectionClass($this);

		if ($reset === TRUE)
		{
			$defaults = $reflection->getDefaultProperties();
			foreach (array_keys($defaults) as $key)
			{
				if ($key[0] === '_')
				{
					continue;
				}

				if (isset($config[$key]))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($config[$key]);
					}
					else
					{
						$this->$key = $config[$key];
					}
				}
				else
				{
					$this->$key = $defaults[$key];
				}
			}
		}
		else
		{
			foreach ($config as $key => &$value)
			{
				if ($key[0] !== '_' && $reflection->hasProperty($key))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($value);
					}
					else
					{
						$this->$key = $value;
					}
				}
			}
		}

		return $this;
    }

	private function _create_obj($obj = array())
	{
		return "<a href='".$this->obj_link."' target='_blank'>".$obj['category'].' '.$obj['manufacture'].' '.$obj['model']."</a>";
	}

	private function _logging()
	{
		$object = array(
			'log_type' => $this->log_type,
			'action_date' => date('Y-m-d H:i:s'),
			'action' => $this->log,
			'status' => 'UNREAD'
		);
		$this->_CI->db->insert('tb_logs', $object);
	}

	private function _device_log()
	{
		$query = $this->_CI->db->select('b.group_label AS category, 
								c.dev_manufacture AS manufacture, 
								d.dev_model AS model')
					  	   ->join('tb_dev_group b', 'a.group_code = b.group_code', 'left')
					  	   ->join('tb_dev_manufacture c', 'a.dev_manufacture_id = c.dev_manufacture_id', 'left')
					 	   ->join('tb_dev_model d', 'a.dev_model_id = d.dev_model_id')
					  	   ->where('a.device_code', $this->item)
					  	   ->get('tb_devices a');
		$device = $query->row_array();

		$this->log = $this->pic.' was '.$this->action.' '.$this->log_type.' '.$this->_create_obj($device);
	}

	private function _hardware_log()
	{
		$query = $this->_CI->db->select('a.hw_model AS model,
								b.hw_category AS category,
								c.hw_manufacture AS manufacture')
						   ->join('tb_hw_category b', 'a.category_code = b.hw_code', 'left')
						   ->join('tb_hw_manufacture c', 'a.hw_manufacture_id = c.hw_manufacture_id', 'left')
						   ->where('a.hw_code', $this->item)
						   ->get('tb_hardware a');
		$hardware = $query->row_array();

		$this->log = $this->pic.' was '.$this->action.' '.$this->log_type.' '.$this->_create_obj($hardware);
	}

	private function _service_log()
	{
		$this->log = $this->pic.' was '.$this->action.' '.$this->log_type.' '.$this->item;
	}

	private function _sla_log()
	{
		$this->log = $this->pic.' was '.$this->action.' '.$this->log_type.' '.$this->item;
	}

	public function add_log()
	{
		switch ($this->log_type) 
		{
			case 'device':
				$this->_device_log();
				break;
			
			case 'hardware':
				$this->_hardware_log();
				break;

			case 'sla-summary':
				$this->_sla_log();
				break;

			case 'service':
				$this->_service_log();
				break;

			default:
				break;
		}

		$this->_logging();
	}
}