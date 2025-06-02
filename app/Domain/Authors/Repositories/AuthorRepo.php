<?php

namespace App\Domain\Authors\Repositories;

use App\Models\Authors;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AuthorRepo implements AuthorRepoInterface
{

    public function getAll(){
        return Authors::orderBy("name")->get();
    }

    public function getById($id){
        return Authors::with('books')->find($id);
    }

    public function getMostPublished($limit = 5){
        return Cache::remember("top_authors_{$limit}", 300, function () use ($limit) {
            return Authors::select('name')
                    ->withCount('books')
                    ->orderByDesc('books_count')
                    ->take($limit)
                    ->get()
                    ->map(fn ($a) => [
                        'name' => $a->name,
                        'books_count' => $a->books_count,
                    ]);
        });
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