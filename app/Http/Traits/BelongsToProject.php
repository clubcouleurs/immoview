<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToProject
{
    /**
     * Boot the BelongsToProject trait for a model.
     */
    public static function bootBelongsToProject()
    {
        // 1. Automatically filter all SELECT, UPDATE, and DELETE queries
        static::addGlobalScope('projet', function (Builder $builder) {
            // Check if there is an active session project_id
            if (session()->has('projet_id')) {
                $builder->where('projet_id', session('projet_id'));
            }
        });

        // 2. Automatically set the project_id when INSERTING new records
        static::creating(function ($model) {
            if (session()->has('projet_id') && empty($model->projet_id)) {
                $model->projet_id = session('projet_id');
            }
        });
    }

    /**
     * Optional: Define the relationship so you can do $item->projet
     */
    public function projet()
    {
        return $this->belongsTo(\App\Models\Projet::class);
    }
}