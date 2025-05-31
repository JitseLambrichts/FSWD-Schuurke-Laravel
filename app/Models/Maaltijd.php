<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maaltijd extends Model
{
    use HasFactory;

    protected $table = 'maaltijden';
    protected $primaryKey = 'maaltijd_id';

    protected $fillable = [
        'categorie', 
        'gerecht_id'
    ];

    public function gerecht() {
        return $this->belongsTo(Gerecht::class, 'gerecht_id', 'gerecht_id');
    }
}