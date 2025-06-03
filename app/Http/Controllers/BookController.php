<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookUpsertRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Domain\Books\Services\BookService;

class BookController extends Controller
{
    protected $bookService;

    /**
     * Injects the BookService into the controller
     *
     * @param BookService $bookService - service responsible for the business logic of books
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Returns a list of books with support for filtering, sorting, and pagination
     *
     * @param BookIndexRequest $request - validated request containing optional filters (search, orderBy, direction)
     * @return \Illuminate\Http\JsonResponse - JSON response containing the books
     */
    public function index(BookIndexRequest $request)
    {
        $validated = $request->validated();

        $book = $this->bookService->getAll(
            $validated['search'] ?? null,
            $validated['orderBy'] ?? 'title',
            $validated['direction'] ?? 'asc'
        );

        return response()->json($book);
    }

    /**
     * Returns a specific book by its ID among with its author(s)
     *
     * @param int $id - ID of the book
     * @return \Illuminate\Http\JsonResponse - JSON response containing the book
     */
    public function show($id) {
        $book = $this->bookService->getById($id);
        return response()->json($book);
    }

    /**
     * Creates a new book with the given data
     *
     * @param BookUpsertRequest $request - validated request containing book data
     * @return \Illuminate\Http\JsonResponse - JSON response containing the created book
     */
    public function store(BookUpsertRequest $request) {
        $data = [
            'title' => $request['title'],
            'publish_date' => $request['publish_date'],
            'authors' => $request['authors'],
        ];
        
        $book = $this->bookService->create($data);
        return response()->json($book);
    }

    /**
     * Updates an existing book by its ID with the given data
     *
     * @param BookUpsertRequest $request - validated request containing book data
     * @param int $id - ID of the book to update
     * @return \Illuminate\Http\JsonResponse - JSON response containing the updated book
     */
    public function update(BookUpsertRequest $request, $id) {
        $data = [
            'title' => $request['title'],
            'publish_date' => $request['publish_date'],
            'authors' => $request['authors'],
        ];

        $book = $this->bookService->update($data, $id);
        return response()->json($book);
    }

    /**
     * Deletes a book by its ID
     *
     * @param int $id - ID of the book to delete
     * @return \Illuminate\Http\JsonResponse - JSON response with null (no content)
     */
    public function delete($id) {
        $book = $this->bookService->delete($id);
        return response()->json(null);
    }
}