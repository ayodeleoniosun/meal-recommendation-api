<?php

namespace App\Api\V1\Interfaces;

interface AllergyInterface
{
    public function pickAllergies(array $data): array;
}
