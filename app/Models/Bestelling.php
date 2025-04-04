<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;

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
}
