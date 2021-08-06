<?php

namespace App\Api\V1\Interfaces;

interface UserInterface
{
    public function register(array $data): array;
}
