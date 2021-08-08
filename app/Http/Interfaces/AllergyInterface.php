<?php

namespace App\Http\Interfaces;
use App\Http\Models\User;

interface AllergyInterface
{
    public function index(array $data, int $userId): array;

    public function store(array $data, int $userId): array;
}
