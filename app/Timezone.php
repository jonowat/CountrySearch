<?php

namespace App;

use App\Country;
use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timezone'
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
