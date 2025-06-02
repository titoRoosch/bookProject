<?php

namespace App\Domain\Authors\Repositories;

use App\Models\Authors;
use Illuminate\Support\Facades\DB;

class AuthorRepo implements AuthorRepoInterface
{

    public function getAll(){
        return Authors::all();
    }

    public function getById($id){
        return Authors::with('books')->find($id);
    }

    public function create(array $data){
        return Authors::create($data);
    }

    public function update(array $data, $id){

        $author = Authors::findOrFail($id);
        $author->update($data);
        return $author;
    }

    public function delete($id){
        $author = Authors::findOrFail($id);
        $author->delete();
    }
}