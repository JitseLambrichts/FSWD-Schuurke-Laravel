<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'review_id';
    
    protected $fillable = [
        'user_id',
        'gerecht_id',
        'score',
        'extra_info',
        'datum'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function gerecht() {
        return $this->belongsTo(Gerecht::class, 'gerecht_id', 'gerecht_id');
    }
}
