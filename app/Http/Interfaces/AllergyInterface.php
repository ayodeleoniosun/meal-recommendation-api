<?php

namespace App\Http\Interfaces;

interface AllergyInterface
{
    public function myAllergies(array $data): array;

    public function pickAllergies(array $data): array;
}
