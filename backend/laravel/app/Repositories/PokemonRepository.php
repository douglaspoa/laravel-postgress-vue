<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http; 
use App\Models\Pokemon;

class PokemonRepository 
{
    public function fetchAndStorePokemons()
    {
        $client = new Client();
        $nextPage = 'https://pokeapi.co/api/v2/pokemon?limit=20';  
        $concurrency = 5;  
    
        do {
            $response = Http::get($nextPage);
            $data = $response->json();
            $pokemons = $data['results'];
            $nextPage = $data['next'];  
    
            $requests = function ($pokemons) {
                foreach ($pokemons as $pokemon) {
                    yield new Request('GET', $pokemon['url']);
                }
            };
    
            $pool = new Pool($client, $requests($pokemons), [
                'concurrency' => $concurrency,
                'fulfilled' => function ($response, $index) use ($pokemons) {

                    $details = json_decode($response->getBody()->getContents(), true);
    
                    Pokemon::updateOrCreate(
                        ['name' => $details['name']],
                        [
                            'type' => $details['types'][0]['type']['name'],
                            'height_cm' => $this->convertHeightToCm($details['height']),
                            'weight_kg' => $this->convertWeightToKg($details['weight']),
                        ]
                    );
                },
                'rejected' => function (RequestException $reason, $index) {
                    echo "Erro ao buscar Pokémon: " . $reason->getMessage();
                },
            ]);
    
            $promise = $pool->promise();
            $promise->wait();
    
        } while (!is_null($nextPage)); 
    }

    public function getAll($filter = null, $perPage = 15) 
    {
        $query = Pokemon::query();

        if ($filter) { 
            $query->where('name', 'like', "%$filter%")
                  ->orWhere('type', 'like', "%$filter%");
        }

        return $query->paginate($perPage);
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