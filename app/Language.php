<?php

namespace App;

use App\Country;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso639_1',
        'iso639_2',
        'name',
        'nativeName'
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
        return $this->belongsToMany(Country::class);
    }
}
