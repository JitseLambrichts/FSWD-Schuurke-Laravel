<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $primaryKey = 'restaurant_id';
    protected $table = 'restaurants';

    protected $fillable = [
        'naam', 
        'telefoonnummer', 
        'email', 
        'openingsuren'
    ];

    public function gerechten()
    {
        return $this->hasMany(Gerecht::class, 'restaurant_id', 'restaurant_id');
    }
}