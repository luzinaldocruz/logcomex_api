<?php

namespace App\Services;

use App\Repositories\PokemonRepository;
use App\DTOs\PokemonDTO;

class PokemonService
{
    private PokemonRepository $pokemonRepository;

    public function __construct(PokemonRepository $pokemonRepository)
    {
        $this->pokemonRepository = $pokemonRepository;
    }


    public function getAllPokemons(int $limit = 100, int $page = 1): array
    {
        $pokemons = $this->pokemonRepository->fetchAllPokemons();

        usort($pokemons, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        $totalPokemons = count($pokemons);
        $totalPages = (int) ceil($totalPokemons / $limit);
        $offset = ($page - 1) * $limit;
        $paginatedPokemons = array_slice($pokemons, $offset, $limit);

        return [
            'data' => $paginatedPokemons,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_pokemons' => $totalPokemons,
            'per_page' => $limit,
        ];
    }

    public function getPokemonInfo(string $nameOrId): PokemonDTO
    {
        $pokemonData = $this->pokemonRepository->fetchPokemonData($nameOrId);

        $types = implode(', ', array_map(fn($type) => $type['type']['name'], $pokemonData['types']));
        $sprite = $pokemonData['sprites']['front_default'] ?? '';

        return new PokemonDTO(
            ucfirst($pokemonData['name']),
            $types,
            $pokemonData['height'] * 10,
            $pokemonData['weight'] / 10,
            $sprite,
        );
    }
}
