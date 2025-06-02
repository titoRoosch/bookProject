<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DashboardFilterRequest;
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

    public function index(DashboardFilterRequest $request): JsonResponse
    {
        try{
            $from = $request->input('from_year', 2020);
            $to = $request->input('to_year', now()->year);
            $top = $request->input('top_authors', 5);

            return response()->json( [
                'books_by_year' => $this->bookService->getBooksByYear($from, $to),
                'books_by_author' => $this->authorService->getMostPublished($top),
            ]);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
