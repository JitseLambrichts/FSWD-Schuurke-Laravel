<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betaling extends Model
{
    use HasFactory;
    
    protected $table = 'betalingen';
    protected $primaryKey = 'betalingen_id';

    protected $fillable = [
        'bestelling_id',
        'datum',
        'status',
        'betaalmethode'
    ];

    protected $casts = [
        'datum' => 'datetime',
    ];

    public function bestelling() {
        return $this->belongsTo(Bestelling::class, 'bestelling_id', 'bestelling_id');
    }
}
