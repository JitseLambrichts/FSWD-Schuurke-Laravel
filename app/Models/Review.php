<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $primaryKey = 'review_id';
    
    protected $fillable = [
        'user_id',
        'gerecht_id',
        'score',
        'extra_info', // Let op: underscore, geen streepje
        'datum'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function gerecht() {
        return $this->belongsTo(Gerecht::class, 'gerecht_id', 'gerecht_id');
    }
}
