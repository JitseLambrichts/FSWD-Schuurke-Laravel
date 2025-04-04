<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservatie extends Model
{
    use HasFactory;

    protected $table = 'reserveringen';
    protected $primaryKey = 'reservering_id';

    protected $fillable = [
        'user_id',
        'datum',
        'tijdstip',
        'tafelnummer',
        'aantal_personen',
        'speciale_verzoeken'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
