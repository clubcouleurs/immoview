<?php
//app/Services/MenuService.php
namespace App\Services;

use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;

use App\Models\Projet;

class ProjectModulesService
{
    public function getProjetConstructibles()
    {
        $projetConstructibles = explode(',' , session('projetConstructibles'));
        $projetConstructibles = array_map('trim', $projetConstructibles);
        return $projetConstructibles ;
    }

    public function getProjetConstructiblesSingular()
    {       
            $array = $this->getProjetConstructibles() ;
             array_walk($array , function(&$value)
            {
              $value = strtolower($this->getSingular($value));
            }); 
            return $array ;       
    }    

    public function getProjets()
    {

        return Projet::all();
    }

    public function getSingular(String $string)
    {
        $inflector = InflectorFactory::createForLanguage(Language::FRENCH)->build();

        return $inflector->singularize($string);
    }
}
