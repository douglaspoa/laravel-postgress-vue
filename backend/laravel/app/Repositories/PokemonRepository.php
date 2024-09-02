<?php

namespace App\Repositories;

use App\Models\Pokemon;
use Illuminate\Support\Facades\Http; 

class PokemonRepository 
{
    public function fetchAndStorePokemons()
    {
    
        $nextPage = 'https://pokeapi.co/api/v2/pokemon';

        $response = Http::get($nextPage, ['limit' => 500]);

        $pokemons = $response->json()['results'];

        foreach ($pokemons as $pokemon) { 
            $details = Http::get($pokemon['url'])->json();
            
            Pokemon::updateOrCreate(
                ['name' => $details['name']],
                [
                'type' => $details['types'][0]['type']['name'],
                'height_cm' => $this->convertHeightToCm($details['height']),
                'weight_kg' => $this->convertWeightToKg($details['weight']),
                ]
            );
        }
    }

    public function getAll ($filter = null) 
    {
        $query = Pokemon::query();
        

        if ($filter) { 
            $query->where('name', 'like', "%$filter%")->orWhere('type', 'like', "%$filter");
        }

        return $query->get();
    }

    public function getById ($id)
    {
        return Pokemon::find($id);
    }

    private function convertHeightToCm($height) 
    {
        return $height * 10;
    }

    private function convertWeightToKg($weight)
    {
        return $weight / 10;
    }
}