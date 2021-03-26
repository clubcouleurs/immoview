<?php

namespace App\Models;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
	public $timestamps = false;
	protected $fillable = ['name'] ;


    public function permissions()
    {
    	return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
    	return $this->hasMany(User::class);
    }    

    public function allowTo($permissions)
    {
    	// if(is_string($permission))
    	// {
    	// 	$permission = Permission::whereName($permission)->firstOrFail() ;
    	// }

    	$this->permissions()->sync($permissions);
        //$this->permissions()->syncWithoutDetaching($permission);
    }

}
