<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PokemonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Pokémon",
 *     version="1.0.0",
 *     description="The documentation of the Pokémon API."
 * )
 */

class PokemonController extends Controller
{
    private PokemonService $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }


    /**
     * @OA\Get(
     *     path="/api/pokemon",
     *     summary="List paginated Pokémons",
     *     tags={"Pokémon List"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of Pokémons to return per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number to fetch",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of Pokémons",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer", description="The current page number"),
     *             @OA\Property(property="total_pages", type="integer", description="The total number of pages"),
     *             @OA\Property(property="total_pokemons", type="integer", description="The total number of Pokémons"),
     *             @OA\Property(property="per_page", type="integer", description="The number of Pokémons per page"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="name", type="string", description="The Pokémon's name")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $limit = $request->query('limit') ?? 10;
        $page = $request->query('page') ?? 1;
        $pokemons = $this->pokemonService->getAllPokemons($limit, $page);
        return response()->json($pokemons, JsonResponse::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/pokemon/{nameOrId}",
     *     summary="Get Pokemon Detail",
     *     tags={"Pokemon Detail"},
     *     @OA\Parameter(
     *         name="nameOrId",
     *         in="path",
     *         description="Name or ID of the Pokemon",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pokemon detail",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="types", type="string"),
     *             @OA\Property(property="height", type="number"),
     *             @OA\Property(property="weight", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pokemon not found"
     *     )
     * )
     */
    public function show(string $nameOrId): JsonResponse
    {
        try {
            $pokemon = $this->pokemonService->getPokemonInfo($nameOrId);
            return response()->json($pokemon->toArray(), JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Pokémon not found or request error.',
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
