<?php

namespace App\Api\V1\Interfaces;

interface AllergyInterface
{
    public function myAllergies(array $data): array;

    public function pickAllergies(array $data): array;
}
