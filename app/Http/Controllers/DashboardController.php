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

    /**
     * Injects BookService and AuthorService into the controller
     *
     * @param BookService $bookService - service responsible for book business logic
     * @param AuthorService $authorService - service responsible for author business logic
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Returns dashboard data with books statistics by year and top authors
     *
     * @param DashboardFilterRequest $request - validated request containing optional filters (from_year, to_year, top_authors)
     * @return JsonResponse - JSON response with aggregated dashboard data
     */
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
