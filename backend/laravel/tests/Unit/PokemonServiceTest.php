<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PokemonService;
use App\Repositories\PokemonRepository; 
use Mockery;

class PokemonServiceTest extends TestCase
{

    protected $pokemonService; 
    protected $pokemonRepositoryMock;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->pokemonRepositoryMock = Mockery::mock(PokemonRepository::class);
        $this->pokemonService = new PokemonService($this->pokemonRepositoryMock);
    }

    public function testGetPokemonList()
    {
        $this->pokemonRepositoryMock
            ->shouldReceive('getAll')
            ->with(null)
            ->andReturn(collect(['Pikachu', 'Charmander']));

        $pokemons = $this->pokemonService->getPokemonList();

        $this->assertCount(2, $pokemons);
    }

    public function testGetPokemonDetails()
    {
        $pokemonDetails = (object) [
            'name' => 'Pikachu',
            'type' => 'electric',
            'height' => 40,
            'weight' => 60,
        ];

        $this->pokemonRepositoryMock
            ->shouldReceive('getById')
            ->with(1)
            ->andReturn($pokemonDetails);

        $pokemon = $this->pokemonService->getPokemonDetails(1);

        $this->assertEquals('Pikachu', $pokemon->name);
        $this->assertEquals('electric', $pokemon->type);
    }


}
