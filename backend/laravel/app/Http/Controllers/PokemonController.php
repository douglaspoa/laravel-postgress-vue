<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PokemonService;

class PokemonController extends Controller
{
    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    public function sync()
    {
        $this->pokemonService->syncPokemons();

        return response()->json(['message' => 'Pokemons atualizados!']);
    }

    public function index(Request $request)
    {
        $filter = $request->query('filter');
        return response()->json($this->pokemonService->getPokemonList($filter));
    }

    public function show($id)
    {
        return response()->json($this->pokemonService.getPokemonDetails($id));
    }
}
