<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorIndexRequest;
use App\Http\Requests\AuthorUpsertRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Domain\Authors\Services\AuthorService;

class AuthorController extends Controller
{
    protected $authorService;

    /**
     * Injects AuthorService into the controller
     *
     * @param AuthorService $authorService - service responsible for author business logic
    */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Returns a list of authors with support for filtering, sorting, and pagination
     *
     * @param AuthorIndexRequest $request - validated request containing optional filters (search, orderBy, direction)
     * @return \Illuminate\Http\JsonResponse - JSON response containing authors
    */
    public function index(AuthorIndexRequest $request) {

        $validated = $request->validated();

        $author = $this->authorService->getAll(
            $validated['search'] ?? null,
            $validated['orderBy'] ?? 'name',
            $validated['direction'] ?? 'asc'
        );

        return response()->json($author);
    }

    /**
     * Returns a single author by ID among with the book(s)
     *
     * @param int $id - ID of the author
     * @return \Illuminate\Http\JsonResponse - JSON response containing the author data
     */
    public function show($id) {
        $author = $this->authorService->getById($id);
        return response()->json($author);
    }

    /**
     * Creates a new author
     *
     * @param AuthorUpsertRequest $request - validated request containing author data
     * @return \Illuminate\Http\JsonResponse - JSON response containing the created author
     */
    public function store(AuthorUpsertRequest $request) {
        $data = [
            'name' => $request['name'],
            'birth_date' => $request['birth_date'],
        ];
        
        $author = $this->authorService->create($data);
        return response()->json($author);
    }

    /**
     * Updates an existing author by ID
     *
     * @param AuthorUpsertRequest $request - validated request containing updated author data
     * @param int $id - ID of the author to update
     * @return \Illuminate\Http\JsonResponse - JSON response containing the updated author
     */
    public function update(AuthorUpsertRequest $request, $id) {
        $data = [
            'name' => $request['name'],
            'birth_date' => $request['birth_date'],
        ];

        $author = $this->authorService->update($data, $id);
        return response()->json($author);
    }

    /**
     * Deletes an author by ID
     *
     * @param int $id - ID of the author to delete
     * @return \Illuminate\Http\JsonResponse - JSON response with null content
     */
    public function delete($id) {
        $author = $this->authorService->delete($id);
        return response()->json(null);
    }
}