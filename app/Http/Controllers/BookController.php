<?php

namespace App\Http\Controllers;

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
        
    }

    public function store() {
        
    }

    public function update() {

    }

    public function delete($id) {
        
    }
}