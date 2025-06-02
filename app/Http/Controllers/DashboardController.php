<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'books_by_year' => [
                ['year' => 2021, 'total' => 4],
                ['year' => 2022, 'total' => 7],
                ['year' => 2023, 'total' => 10],
            ],
            'books_by_author' => [
                ['name' => 'Machado de Assis', 'books_count' => 6],
                ['name' => 'Clarice Lispector', 'books_count' => 5],
                ['name' => 'Graciliano Ramos', 'books_count' => 3],
            ],
        ]);
    }
}
