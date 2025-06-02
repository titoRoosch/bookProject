<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Domain\Books\Services\BookService;
use App\Domain\Authors\Services\AuthorService;

class DashboardController extends Controller
{
    protected $bookService;
    protected $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index(): JsonResponse
    {
        try{
            return response()->json([
                'books_by_year' => $this->bookService->getBooksByYear(),
                'books_by_author' => $this->authorService->getMostPublished(),
            ]);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
