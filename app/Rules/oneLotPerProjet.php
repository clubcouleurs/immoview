<?php

namespace App\Rules;

use App\Models\Lot;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class oneLotPerProjet implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct($id='', $typeNum='lots.num', $table = 'lots', $typeConstructible = 'lot')
    {
        $this->id = $id ;
        $this->num = $typeNum ;
        $this->table = $table ;
        $this->typeConstructible = $typeConstructible ;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $count = DB::table($this->table)
            ->join('produits', 'produits.constructible_id' , '=' , $this->table.'.id')
            ->where($this->num, $value)
            ->whereNotIn($this->table.'.id' , [$this->id])
            ->where('produits.constructible_type' , $this->typeConstructible)
            ->where('produits.projet_id', session('projet_id'))
            ->count();

            // dd($count) ;
        return $count == 0;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $msg = '';
        switch ($this->typeNum) {
            case 'lots.num_cadastre':
                $msg = 'cadastrale ';
                break;
        }

        return 'Ce numéro ' . $this->typeConstructible  .' '. $msg .'existe déjà pour ce projet.';
    }
}
