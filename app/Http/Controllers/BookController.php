<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookUpsertRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Domain\Books\Services\BookService;

class BookController extends Controller
{
    protected $bookService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index() {
        $book = $this->bookService->getAll();
        return response()->json($book);
    }

    public function show($id) {
        $book = $this->bookService->getById($id);
        return response()->json($book);
    }

    public function store(BookUpsertRequest $request) {
        $data = [
            'title' => $request['title'],
            'publish_date' => $request['publish_date'],
            'authors' => $request['authors'],
        ];
        
        $book = $this->bookService->create($data);
        return response()->json($book);
    }

    public function update(BookUpsertRequest $request, $id) {
        $data = [
            'title' => $request['title'],
            'publish_date' => $request['publish_date'],
            'authors' => $request['authors'],
        ];

        $book = $this->bookService->update($data, $id);
        return response()->json($book);
    }

    public function delete($id) {
        $book = $this->bookService->delete($id);
        return response()->json(null);
    }
}