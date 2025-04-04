<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestie extends Model
{
    use HasFactory;

    protected $primaryKey = 'suggestie_id';
    protected $table = 'suggesties';

    protected $fillable = [
        'periode',
        'gerecht_id',
    ];

    public function gerecht() {
        return $this->belongsTo(Gerecht::class, 'gerecht_id', 'gerecht_id');
    }


}
