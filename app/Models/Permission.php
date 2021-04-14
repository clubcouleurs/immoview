<?php

namespace App\Models;

use App\Models\Family;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    use HasFactory;
	public $timestamps = false;
	protected $fillable = ['name'] ;

    public function roles()
    {
    	return $this->belongsToMany(Role::class);
    }
    
    public function family()
    {
        return $this->belongsTo(Family::class);
    }    

}
