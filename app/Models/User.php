<?php

namespace App\Models;

use App\Models\Dossier;
use App\Models\Visite;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }      
    public function visites()
    {
        return $this->hasMany(Visite::class);
    }      
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function assignRole(Role $role)
    {
        $this->role()->associate($role) ;
    }

    public function permissions()
    {
        return (null !== $this->role) ? $this->role->permissions->flatten()->pluck('name')->unique() : collect([]);
    } 
    public function isAdministrator()
    {
        return ($this->role !== NULL) ? ($this->role->name == 'Admin') : false ;
    }   
}
