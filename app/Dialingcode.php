<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dialingcode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code'
    ];
    
    /**
     * Indicates if the model should be timestamped.
     * 
     * Laravel timestamps models by default, this is unncessary in this exercise.
     *
     * @var bool
     */
    public $timestamps = false;

    public function countries()
    {
        return $this->belongsTo(Country::class);
    }
}
