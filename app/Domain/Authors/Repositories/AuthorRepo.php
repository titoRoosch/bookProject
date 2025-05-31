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
        
    }

    public function create(array $data){
        
    }

    public function update(array $data, $id){
        
    }

    public function delete($id){
        
    }
}