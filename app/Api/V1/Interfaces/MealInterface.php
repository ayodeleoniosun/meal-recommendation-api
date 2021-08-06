<?php

namespace App\Api\V1\Interfaces;

interface MealInterface
{
    public function index(array $data): array;

    public function show(int $id): array;

    public function userRecommendations(array $data): array;
}
