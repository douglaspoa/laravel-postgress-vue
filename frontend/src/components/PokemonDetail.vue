<template>
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <h1 class="my-4 text-center">Pokémon Details</h1>
  
      <!-- Loader -->
      <div v-if="isLoading" class="d-flex justify-content-center align-items-center loading-container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtuLvq_z6fGcatFZVwO9KBw03rgVetQA-p9Q&s" alt="Loading..." class="loading-image">
      </div>
  
      <!-- Pokémon Details -->
      <div v-if="!isLoading && pokemon" class="pokemon-details-card p-4">
        <h2 class="text-center">{{ pokemon.name }}</h2>
        <div class="pokemon-details">
          <p><strong>Type:</strong> {{ pokemon.type }}</p>
          <p><strong>Height:</strong> {{ pokemon.height_cm }} cm</p>
          <p><strong>Weight:</strong> {{ pokemon.weight_kg }} kg</p>
        </div>
        <div class="text-center">
          <router-link to="/" class="btn btn-secondary mt-4">Back to List</router-link>
        </div>
      </div>
  
      <!-- Error Message -->
      <div v-if="!isLoading && error" class="alert alert-danger">
        <p>Failed to load Pokémon details. Please try again later.</p>
        <router-link to="/" class="btn btn-secondary mt-4">Back to List</router-link>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        pokemon: null,
        isLoading: true,
        error: null,
      };
    },
    created() {
      this.fetchPokemon();
    },
    methods: {
      async fetchPokemon() {
        try {
          const response = await axios.get(`http://localhost:8000/api/admin/pokemons/${this.$route.params.id}`);
          this.pokemon = response.data;
        } catch (err) {
          this.error = err;
        } finally {
          this.isLoading = false;
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .loading-container {
    height: 50vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .loading-image {
    width: 100px;
    height: 100px;
    animation: spin 2s linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  .pokemon-details-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f8f9fa;
    max-width: 500px;
    width: 100%;
  }
  
  .pokemon-details {
    margin-top: 20px;
    font-size: 1.2rem;
    line-height: 1.6;
  }
  
  .pokemon-details p {
    margin-bottom: 10px;
  }
  
  h2 {
    font-size: 2rem;
    margin-bottom: 20px;
  }
  </style>
  