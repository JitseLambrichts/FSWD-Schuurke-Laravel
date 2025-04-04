<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestellingBevat extends Model
{
    protected $table = 'bestelling_bevat_gerechten';

    public $incrementing = false; // Fix typo: was $increment

    protected $primaryKey = ['bestelling_id', 'gerecht_id'];
    
    protected $fillable = [
        'bestelling_id',
        'gerecht_id',
        'aantal'
    ];
    
    public function bestelling()
    {
        return $this->belongsTo(Bestelling::class, 'bestelling_id');
    }
    
    public function gerecht()
    {
        return $this->belongsTo(Gerecht::class, 'gerecht_id');
    }
}
