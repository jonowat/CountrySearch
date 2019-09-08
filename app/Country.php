<?php

namespace App;

use App\Currency;
use App\Language;
use App\Timezone;
use App\Dialingcode;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'region', 'code2', 'code3', 'capital', 'flag'
    ];
    
    /**
     * Indicates if the model should be timestamped.
     * 
     * Laravel timestamps models by default, this is unncessary in this exercise.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The relationships that should always be loaded.
     * 
     * By default relationships are lazy loaded, as we always want the related items, always load them up front.
     *
     * @var array
     */
    protected $with = ['currencies','languages','dialingcodes'];

    public function currencies()
    {
        return $this->belongsToMany(Currency::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function dialingcodes()
    {
        return $this->hasMany(Dialingcode::class);
    }

    public function timezones()
    {
        return $this->hasMany(Timezone::class);
    }
}
