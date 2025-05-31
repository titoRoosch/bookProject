<?php

namespace App\Domain\Books\Repositories;

use App\Models\Books;
use Illuminate\Support\Facades\DB;

class BookRepo implements BookRepoInterface
{
    protected $bookRepo;

    public function getAll(){

        // return Books::all();
        
        $query = Books::with('authors');

        return $query->paginate(10);
    }

    public function getById($id){
        
    }

    public function create(array $data){
        
    }

    public function update(array $data, $id){
        
    }

    public function delete($id){
        
    }
}