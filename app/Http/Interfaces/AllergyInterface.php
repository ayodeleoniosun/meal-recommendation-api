<?php

namespace App\Http\Interfaces;

interface AllergyInterface
{
    public function index(array $data): array;

    public function store(array $data): array;
}
