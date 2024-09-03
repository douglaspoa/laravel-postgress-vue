<template>
    <div class="container">
      <h1 class="my-4">Pokémon List</h1>
      <input
        v-model="filter"
        @input="onInputChange"
        type="text"
        class="form-control mb-4"
        placeholder="Filter by name or type"
      />
  
      <!-- Loader -->
      <div v-if="isLoading" class="d-flex justify-content-center align-items-center loading-container">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtuLvq_z6fGcatFZVwO9KBw03rgVetQA-p9Q&s" alt="Loading..." class="loading-image">
      </div>
  
      <!-- Pokémon List with Transition -->
      <transition name="fade">
        <div class="row pokemon-list" v-if="!isLoading">
          <div class="col-md-4" v-for="pokemon in pokemons" :key="pokemon.id">
            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title">{{ pokemon.name }}</h5>
                <p class="card-text">Type: {{ pokemon.type }}</p>
                <router-link :to="`/pokemon/${pokemon.id}`" class="btn btn-primary">
                  View Details
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </transition>
  
      <!-- Fixed navigation bar -->
      <nav aria-label="Page navigation" class="pagination-container">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <button class="page-link" @click="changePage(1)">
              First
            </button>
          </li>
          <li class="page-item" :class="{ disabled: !prevPageUrl }">
            <button class="page-link" @click="changePage(currentPage - 1)">
              Previous
            </button>
          </li>
          
          <li
            v-for="page in paginationPages"
            :key="page"
            class="page-item"
            :class="{ active: page === currentPage }"
          >
            <button class="page-link" @click="changePage(page)">
              {{ page }}
            </button>
          </li>
  
          <li class="page-item" :class="{ disabled: !nextPageUrl }">
            <button class="page-link" @click="changePage(currentPage + 1)">
              Next
            </button>
          </li>
          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <button class="page-link" @click="changePage(totalPages)">
              Last
            </button>
          </li>
        </ul>
      </nav>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        pokemons: [],
        filter: '',
        currentPage: 1,
        pageSize: 8,
        totalPages: 1,
        prevPageUrl: null,
        nextPageUrl: null,
        isLoading: false,
        debounceTimeout: null,
        selectedPokemon: null,
      };
    },
    computed: {
      paginationPages() {
        const range = 2;
        let start = Math.max(this.currentPage - range, 1);
        let end = Math.min(this.currentPage + range, this.totalPages);
  
        if (end - start < range * 2) {
          if (start === 1) {
            end = Math.min(start + range * 2, this.totalPages);
          } else if (end === this.totalPages) {
            start = Math.max(end - range * 2, 1);
          }
        }
  
        const pages = [];
        for (let i = start; i <= end; i++) {
          pages.push(i);
        }
        return pages;
      },
    },
    created() {
      this.fetchPokemons();
    },
    methods: {
      onInputChange() {
        clearTimeout(this.debounceTimeout);
        this.debounceTimeout = setTimeout(() => {
          this.fetchPokemons();
        }, 1500);
      },
      async fetchPokemons(page = 1) {
        this.isLoading = true;
        try {
          const response = await axios.get('http://localhost:8000/api/admin/pokemons', {
            params: {
              filter: this.filter,
              page: page,
              perPage: this.pageSize,
            },
          });
  
          this.pokemons = response.data.data;
          this.currentPage = response.data.current_page;
          this.totalPages = response.data.last_page;
          this.prevPageUrl = response.data.prev_page_url;
          this.nextPageUrl = response.data.next_page_url;
        } catch (error) {
          console.error("Error fetching Pokémon list:", error);
        } finally {
          this.isLoading = false;
        }
      },
      changePage(page) {
        if (page >= 1 && page <= this.totalPages) {
          this.currentPage = page;
          this.fetchPokemons(page);
        }
      },
    },
  };
  </script>
  
  <style>
  /* Estilo da transição de fade */
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease;
  }
  .fade-enter, .fade-leave-to {
    opacity: 0;
  }
  
  /* Estilos para o loader */
  .loading-container {
    height: 50vh;
    width: 100%;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
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
  
  /* Fixar o tamanho da lista de Pokémons para evitar mudanças drásticas na UI */
  .pokemon-list {
    min-height: 50vh;
    margin-bottom: 70px;
  }
  
  /* Estilos para a barra de paginação fixa */
  .pagination-container {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #f8f9fa;
    padding: 10px 0;
    display: flex;
    justify-content: center;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }
  </style>
  