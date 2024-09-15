<?php

namespace App\Repositories;

use GuzzleHttp\Client;

class PokemonRepository
{
    private Client $client;
    private string $baseUrl;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->baseUrl = env('POKE_API_BASE_URL');
    }

    public function fetchAllPokemons(): array
    {
        $response = $this->client->request('GET', $this->baseUrl . '?limit=10000');
        $pokemons = json_decode($response->getBody(), true);

        if (isset($pokemons['results'])) {
            return array_map(fn($pokemonData) => [
                'name' => ucfirst($pokemonData['name']),
            ], $pokemons['results']);
        }

        return [];
    }

    public function fetchPokemonData(string $nameOrId): array
    {
        // Necessário converter para lower novamente, pois a api 
        // externa é case sensitive
        $url = $this->baseUrl . strtolower($nameOrId);

        $response = $this->client->request('GET', $url);
        return json_decode($response->getBody(), true);
    }
}
