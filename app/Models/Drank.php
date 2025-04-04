<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drank extends Model
{
    use HasFactory;
    protected $primaryKey = 'drank_id';
    
    protected $fillable = [
        'volume', 
        'alcohol_percentage', 
        'gerecht_id'
    ];

    protected $table = 'dranken'; // zie gerecht voor uitleg

    public function gerecht()
    {
        return $this->belongsTo(Gerecht::class, 'gerecht_id', 'gerecht_id');
    }
}