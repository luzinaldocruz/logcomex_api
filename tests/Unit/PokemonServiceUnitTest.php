<?php

namespace Tests\Unit;

use App\Repositories\PokemonRepository;
use App\Services\PokemonService;
use PHPUnit\Framework\TestCase;

class PokemonServiceUnitTest extends TestCase
{
    public function testGetPokemonInfoReturnsCorrectData()
    {
        $pokemonRepositoryMock = $this->createMock(PokemonRepository::class);

        $pokemonRepositoryMock->method('fetchPokemonData')
            ->willReturn([
                'name' => 'pikachu',
                'types' => [['type' => ['name' => 'electric']]],
                'height' => 4,
                'weight' => 60,
            ]);

        $pokemonService = new PokemonService($pokemonRepositoryMock);

        $pokemon = $pokemonService->getPokemonInfo('pikachu');

        $this->assertArrayHasKey('name', $pokemon->toArray());
        $this->assertArrayHasKey('types', $pokemon->toArray());
        $this->assertArrayHasKey('height', $pokemon->toArray());
        $this->assertArrayHasKey('weight', $pokemon->toArray());


        $this->assertIsString($pokemon->name);
        $this->assertIsString($pokemon->types);
        $this->assertIsFloat($pokemon->height);
        $this->assertIsFloat($pokemon->weight);
    }
}
