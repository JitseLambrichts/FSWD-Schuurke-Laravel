<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bestelling extends Model
{
    use HasFactory;

    protected $table = 'bestellingen';
    protected $primaryKey = 'bestelling_id';

    protected $fillable = [
        'user_id',
        'status',
        'totaalprijs',
        'afhaaltijdstip'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gerechten() {
        return $this->belongsToMany(Gerecht::class, 'bestelling_bevat_gerechten', 'bestelling_id', 'gerecht_id')
                    ->withTimestamps();
    }

    public function betaling() {
        return $this->hasOne(Betaling::class, 'bestelling_id');
    }

    public function bestellingItems() {
        return $this->hasMany(BestellingBevat::class, 'bestelling_id');
    }
}
