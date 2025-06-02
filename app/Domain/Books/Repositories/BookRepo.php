<?php

namespace App\Domain\Books\Repositories;

use App\Models\Books;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;

class BookRepo implements BookRepoInterface
{
    protected $bookRepo;

    public function getAll(){
        
        $query = Books::with('authors')->orderBy("title");

        return $query->paginate(10);
    }

    public function getById($id){
        return Books::with('authors')->findOrFail($id);
    }

    public function getBooksByYear($from, $to){
        return Cache::remember("books_by_year_{$from}_{$to}", 300, function () use ($from, $to) {
            return DB::table('books')
                ->selectRaw('EXTRACT(YEAR FROM publish_date) as year, COUNT(*) as total')
                ->whereBetween(DB::raw('EXTRACT(YEAR FROM publish_date)'), [$from, $to])
                ->groupBy('year')
                ->orderBy('year')
                ->get();
        });
    }

    public function create(array $data){
        $book = Books::create($data);
        if (isset($data['authors']) && is_array($data['authors'])) {
            foreach($data['authors'] as $author){
                $book->authors()->attach($author['author_id']);
            }
        }

        return $book;
    }

    public function update(array $data, $id){
        $book = Books::findOrFail($id);
        $book->update($data);
        if (isset($data['authors']) && is_array($data['authors'])) {
            $authorIds = collect($data['authors'])->pluck('author_id')->toArray();
            $book->authors()->sync($authorIds);
        }

        return $book;
    }

    public function delete($id){
        $book = Books::findOrFail($id);
        $book->authors()->detach();
        $book->delete();
    }
}