<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

     protected $fillable = [
        'title',
        'publish_date'
    ];

    public function authors() {
        return $this->belongsToMany(Authors::class, 'book_author_relations', 'book_id', 'author_id');
    }
}
