<?php

namespace App\Http\Interfaces;

interface MealInterface
{
    public function index(array $data): array;

    public function find(int $id): array;

    public function recommendations(array $data): array;
}
