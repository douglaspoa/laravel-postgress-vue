<?php

namespace App\Services;

use App\Repositories\PokemonRepository;

class PokemonService
{ 
    protected $pokemonRepository;

    public function __construct (PokemonRepository $pokemonRepository)
    { 
        $this->pokemonRepository = $pokemonRepository;
    }

    public function syncPokemons() { 
        $this->pokemonRepository->fetchAndStorePokemons();
    }

    public function getPokemonList($filter = null)
    {
        return $this->pokemonRepository->getAll($filter);
    }

    public function getPokemonDetails($id)
    { 
        return $this->pokemonRepository->getById($id);
    }
}
