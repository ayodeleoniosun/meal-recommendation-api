<?php

namespace App\Http\Interfaces;

interface UserInterface
{
    public function register(array $data): array;

    public function login(array $data): array;
}
