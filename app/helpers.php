<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Projet;
use NumberToWords\NumberToWords;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;
use Carbon\Carbon;

if(! function_exists('shortcode_parse_atts'))
{
	function shortcode_parse_atts( $text ) {
	    $atts    = array();
	    $pattern =  get_shortcode_atts_regex();
	    $text    = preg_replace( "/[\x{00a0}\x{200b}]+/u", ' ', $text );
	    if ( preg_match_all( $pattern, $text, $match, PREG_SET_ORDER ) ) {
	        foreach ( $match as $m ) {
	            if ( ! empty( $m[1] ) ) {
	                $atts[ strtolower( $m[1] ) ] = stripcslashes( $m[2] );
	            } elseif ( ! empty( $m[3] ) ) {
	                $atts[ strtolower( $m[3] ) ] = stripcslashes( $m[4] );
	            } elseif ( ! empty( $m[5] ) ) {
	                $atts[ strtolower( $m[5] ) ] = stripcslashes( $m[6] );
	            } elseif ( isset( $m[7] ) && strlen( $m[7] ) ) {
	                $atts[] = stripcslashes( $m[7] );
	            } elseif ( isset( $m[8] ) && strlen( $m[8] ) ) {
	                $atts[] = stripcslashes( $m[8] );
	            } elseif ( isset( $m[9] ) ) {
	                $atts[] = stripcslashes( $m[9] );
	            }
	        }

	        // Reject any unclosed HTML elements.
	        foreach ( $atts as &$value ) {
	            if ( str_contains( $value, '<' ) ) {
	                if ( 1 !== preg_match( '/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value ) ) {
	                    $value = '';
	                }
	            }
	        }
	    } else {
	        $atts = ltrim( $text );
	    }

	    return $atts;
	}
}

if(! function_exists('localize_shortcode'))
{
	function localize_shortcode($shortcode_name, $atts, $dossier) {
    // Process the shortcode and return the replacement data
		$projet_id = session('projet_id') ;
		$projet = Projet::findOrFail($projet_id);
        $toWords = new NumberToWords();
        $numberTransformer = $toWords->getNumberTransformer('fr');

	    switch ($shortcode_name)
		    {
		        case 'entreprise':
		            return $projet->entreprise->nom;
		            break;
		        case 'siege':
		            return $projet->entreprise->siege;
		            break;
		        case 'capital':
		            return number_format($projet->entreprise->capital) . ' Dhs';
		            break;			            
		        case 'rc':
		            return $projet->entreprise->rc;
		            break;	  
		        case 'ville':
		            return $projet->entreprise->ville;
		            break;		
		        case 'nom_projet':
		            return $projet->nom;
		            break;			
		        case 'ville_projet':
		            return $projet->ville;
		            break;
		        case 'titre':
		            return $projet->titre;
		            break;			            
		        case 'client':
		            return implode($dossier->sanitizeClientInfos());
		            break;			
		        case 'numero_lot':
		            return $dossier->produit->constructible->num;
		            break;	
		        case 'tranche':
		            return $dossier->produit->tranche;
		            break;	
		        case 'immeuble':
		            return $dossier->produit->immeuble;
		            break;		            
		        case 'surface':
		        
		            return $dossier->produit->constructible->surface . 'm²';
		            break;	
		        case 'etage':
		            return $dossier->produit->etage;
		            break;
		        case 'prix_total_chiffre':
		            return number_format($dossier->produit->total, 2 , ',' , '.' ) . ' Dhs';
		            break;
		        case 'prix_total_lettre':
		            return ucfirst($numberTransformer->toWords($dossier->produit->total)) . ' dirhams.';
		            break;	
		        case 'prix_unitaire':
		            return $dossier->produit->prix . ' Dhs/m²' ;
		            break;	
		        case 'avance_chiffre':
		            return number_format((($dossier->produit->total) * 30) /100 , 2 , ',' , '.' ) . ' Dhs' ;
		            break;
		        case 'avance_lettre':
		            return ucfirst($numberTransformer->toWords((($dossier->produit->total) * 30) /100 , 2 , ',' , '.' )) . ' dirhams.' ;
		            break;		
		        case 'total_versements':
		            return number_format($dossier->totalPaiements,  2 , ',' , '.')   . ' Dhs' ;
		            break;		
		        case 'date_du_jour':
		            return Carbon::now()->locale('fr_FR')->isoFormat('D MMMM YYYY')	 ;
		            break;		
		        case 'type':
		            return strtoupper($dossier->produit->constructible_type) ;
		            break;			            	            	            	            
		        default:
		            // code...
		            break;
		    }

    // Return empty string if shortcode is not recognized
    return '';
	}
}
if(! function_exists('dateOfToDay'))
{
	function dateOfToDay()
	{
		return Carbon::now()->locale('fr_FR')->isoFormat('D MMMM YYYY')	 ;
	}
}

if(! function_exists('get_shortcode_atts_regex'))
{
	function get_shortcode_atts_regex()
	{
    return '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|\'([^\']*)\'(?:\s|$)|(\S+)(?:\s|$)/';
	}
}

if(! function_exists('replace_shortcodes'))
{
            function replace_shortcodes($content, $dossier) {
                return preg_replace_callback(
                    '/\[([a-zA-Z0-9_]+)([^\]]*)\]/',
                    function ($matches) use ($dossier){
                        $shortcode_name = $matches[1];
                        $atts = shortcode_parse_atts($matches[2]);
                        return localize_shortcode($shortcode_name, $atts, $dossier);
                    },
                    $content
                );
            }
}

if(! function_exists('getSingular'))
{
	function getSingular($value='')
	{
		$inflector = InflectorFactory::createForLanguage(Language::FRENCH)->build();
		return $inflector->pluralize($value); // browser

	}
}

if(! function_exists('Singular'))
{
	function Singular($value='')
	{
		$inflector = InflectorFactory::createForLanguage(Language::FRENCH)->build();
		return $inflector->singularize($value); // browser

	}
}

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