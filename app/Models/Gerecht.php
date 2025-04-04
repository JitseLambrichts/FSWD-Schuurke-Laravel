<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerecht extends Model
{
    use HasFactory;
    protected $primaryKey = 'gerecht_id';
    protected $table = 'gerechten'; // zorgen dat Laravel de juiste tabel gaat gebruiken, want deze maakt automatisch een gerechts tabel aan

    protected $fillable = [
        'naam', 
        'beschrijving', 
        'prijs', 
        'allergenen', 
        'restaurant_id'
    ];

    // Een gerecht hoort bij één restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'restaurant_id');
    }

    // Een gerecht is OF een drank OF een maaltijd (1-op-1)
    public function drank()
    {
        return $this->hasOne(Drank::class, 'gerecht_id', 'gerecht_id');
    }

    public function maaltijd()
    {
        return $this->hasOne(Maaltijd::class, 'gerecht_id', 'gerecht_id');
    }
    // ... andere relaties (bv BestellingBevatGerechten) ...
}