<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerecht extends Model
{
    use HasFactory;

    protected $table = 'gerechten';
    protected $primaryKey = 'gerecht_id';

    protected $fillable = [
        'naam', 
        'beschrijving', 
        'prijs', 
        'allergenen', 
        'restaurant_id'
    ];

    public function restaurant() {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'restaurant_id');
    }

    public function drank() {
        return $this->hasOne(Drank::class, 'gerecht_id', 'gerecht_id');
    }

    public function maaltijd() {
        return $this->hasOne(Maaltijd::class, 'gerecht_id', 'gerecht_id');
    }
}