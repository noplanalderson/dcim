<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function net_possible($mask)
{
	if ($mask == 24)
	{
		$possibleNet = array(0);
	}
	elseif ($mask == 25) {
		$possibleNet = array(0,128);
	}
	elseif ($mask == 26) {
		$possibleNet = array(0,64,128,192);
	}
	elseif ($mask == 27) {
		$possibleNet = array(0,32,64,96,128,160,192,224);
	}
	elseif ($mask == 28) {
		$possibleNet = array(0,16,32,48,64,80,96,112,128,144,160,176,192,208,224,240);
	}
	elseif ($mask == 29) {
		$possibleNet = array(0,8,16,24,32,40,48,56,64,72,80,88,96,104,112,120,128,136,144,152,160,168,176,184,192,200,208,216,224,232,240,248);
	}
	elseif ($mask == 30) {
		$possibleNet = array(0,4,8,12,16,20,24,28,32,36,40,44,48,52,56,60,64,68,72,76,80,84,88,92,96,100,104,108,112,116,120,124,128,132,136,140,144,148,152,156,160,164,168,172,176,180,184,188,192,196,200,204,208,212,216,220,224,228,232,236,240,244,248,252);
	}

	return $possibleNet;
}

function cidr_to_range($cidr) 
{
    $range 		= array();
    $cidr 		= explode('/', $cidr);
    $range[0] 	= long2ip((ip2long($cidr[0])) & ((-1 << (32 - (int)$cidr[1]))));
    $range[1] 	= long2ip((ip2long($cidr[0])) + pow(2, (32 - (int)$cidr[1])) - 1);
    
    return $range;
}

function ip_in_range($ip, $range)
{
	if (strpos($range, '/') == false) 
	{
		$range .= '/32';
	}
	
	list($range, $netmask) = explode('/', $range, 2);
	$range_decimal = ip2long($range);
	$ip_decimal = ip2long($ip);
	$wildcard_decimal = pow(2, (32 -$netmask)) - 1;
	$netmask_decimal = ~ $wildcard_decimal;
	return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
}