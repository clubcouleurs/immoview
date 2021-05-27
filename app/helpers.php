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

if(! function_exists('is_rtl'))
{
	function is_rtl( $string )
	{
		$rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';
		return preg_match($rtl_chars_pattern, $string);
	}
}

if(! function_exists('completion'))
{
	function completion($value)
	{
		switch ($value) {
			case 'app':
				return 'appartement' ;
				break;
			case 'lot':
				return $value ;
				break;
			case 'mag':
				return 'magasin' ;
				break;

			case 'bur':
				return 'bureau' ;
				break;

			case 'box':
				return $value ;
				break;
			default:
				return $value ;
				break;
		}
	}
}