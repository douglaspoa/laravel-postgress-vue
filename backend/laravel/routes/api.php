<?php
use App\Http\Controllers\PokemonController;

Route::get('/pokemons', [PokemonController::class, 'index']);
Route::get('/pokemons/{id}', [PokemonController::class, 'show']);
Route::post('/pokemons/sync', [PokemonController::class, 'sync']);

?>