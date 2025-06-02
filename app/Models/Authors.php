<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'birth_date'
    ];

    public function books() {
        return $this->belongsToMany(Books::class, 'book_author_relations', 'author_id', 'book_id');
    }
}
