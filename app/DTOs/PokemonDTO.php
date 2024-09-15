<?php

namespace App\DTOs;

class PokemonDTO
{
    public function __construct(
        public string $name,
        public string $types,
        public float $height,
        public float $weight,
        public string $sprite
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'types' => $this->types,
            'height' => $this->height,
            'weight' => $this->weight,
            'sprite' => $this->sprite,
        ];
    }
}
