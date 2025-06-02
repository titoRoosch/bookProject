<?php

namespace App\Domain\Authors\Services;

use App\Domain\Authors\Repositories\AuthorRepo;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthorService
{
    protected $authorRepo;

    public function __construct(AuthorRepo $authorRepo){
        $this->authorRepo = $authorRepo;
    }

    public function getAll(){
        return $this->authorRepo->getAll();
    }

    public function getById($id)
    {
        return $this->authorRepo->getById($id);
    }

    public function create(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:authors,name',
            'birth_date' => 'required|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errorsArray = $errors->toArray();
            
            return $errorsArray;
        }
        return $this->authorRepo->create($data);
    }

    public function update(array $data, $id)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:authors,name,' . $id,
            'birth_date' => 'required|date',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $errorsArray = $errors->toArray();
            
            return $errorsArray;
        }
        return $this->authorRepo->update($data, $id);
    }

    public function delete($id)
    {
        return $this->authorRepo->delete($id);
    }
}