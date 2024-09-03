import { createRouter, createWebHistory } from 'vue-router';
import PokemonList from '../components/PokemonList.vue';
import PokemonDetail from '../components/PokemonDetail.vue';

const routes = [
  {
    path: '/',
    name: 'PokemonList',
    component: PokemonList,
  },
  {
    path: '/pokemon/:id',
    name: 'PokemonDetail',
    component: PokemonDetail,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
