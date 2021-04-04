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