<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'aprox_duration',
        'priority',
        'expire_date',
    ];

    /**
     * Get the list that owns the task.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Tdlist');
    }
}
