<?php

namespace App\Domain\Authors\Services;

use App\Domain\Authors\Repositories\AuthorRepo;
use Symfony\Component\HttpFoundation\Response;

class AuthorService
{
    protected $authorRepo;

    public function __construct(AuthorRepo $authorRepo){
        $this->authorRepo = $authorRepo;
    }

    public function getAll(){
        return $this->authorRepo->getAll();
    }
}