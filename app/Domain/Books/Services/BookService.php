<?php

namespace App\Domain\Books\Services;

use App\Domain\Books\Repositories\BookRepo;
use Symfony\Component\HttpFoundation\Response;

class BookService
{
    protected $bookRepo;

    public function __construct(){
        $this->bookRepo = new BookRepo();
    }

    public function getAll(){
        return $this->bookRepo->getAll();
    }
}