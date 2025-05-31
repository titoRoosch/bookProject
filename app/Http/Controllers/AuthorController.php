<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Domain\Authors\Services\AuthorService;

class AuthorController extends Controller
{
    protected $authorService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index() {
        $author = $this->authorService->getAll();
        return response()->json($author);
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