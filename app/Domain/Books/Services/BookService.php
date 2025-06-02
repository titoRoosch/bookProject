<?php

namespace App\Domain\Books\Services;

use App\Domain\Books\Repositories\BookRepo;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookService
{
    protected $bookRepo;

    public function __construct(){
        $this->bookRepo = new BookRepo();
    }

    public function getAll(?string $title = null, ?string $orderBy = 'title', ?string $direction = 'asc'){
        return $this->bookRepo->getAll($title, $orderBy, $direction);
    }

    public function getById($id)
    {
        return $this->bookRepo->getById($id);
    }

    public function getBooksByYear($from, $to)
    {
        return $this->bookRepo->getBooksByYear($from, $to);
    }

    public function create(array $data)
    {
        $rules = [
            'title' => 'required|string|max:255|unique:books,title',
            'publish_date' => 'required|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorsArray = $errors->toArray();
            
            return $errorsArray;
        }
        return $this->bookRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $rules = [
            'title' => 'required|string|max:255|unique:books,title,' . $id,
            'publish_date' => 'required|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errorsArray = $errors->toArray();
            
            return $errorsArray;
        }
        return $this->bookRepo->update($data, $id);
    }

    public function delete($id)
    {
        return $this->bookRepo->delete($id);
    }
}