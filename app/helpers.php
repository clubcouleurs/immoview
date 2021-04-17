<?php

use Illuminate\Support\Facades\Auth;

if(! function_exists('p'))
{
	function p($value='')
	{
		switch ($value) {
			case 'appartement':
			case 'lot':
			case 'magasin':
				return $value . 's' ;
				break;

			case 'bureau':
				return $value . 'x' ;
				break;

			case 'box':
				return $value . 'es' ;
				break;
			default:
				return $value ;
				break;
		}
	}
}

if(! function_exists('s'))
{
	function s($value='')
	{
		return strtolower($value) ;
	}
}

if(! function_exists('numberFormat'))
{
	function numberFormat($value)
	{
		$floor = floor($value) ;
		$rslt = $value - $floor ;
		return ($rslt > 0) ? number_format($value,2) : number_format($value) ;
	}
}