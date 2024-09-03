import { createApp } from 'vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
import { BootstrapVueNext} from 'bootstrap-vue-next';
import App from './App.vue';
import router from './router';  // Certifique-se de que está importando o router


const app = createApp(App);

app.use(BootstrapVueNext);
app.use(router);  // Certifique-se de que o router está sendo usado

app.mount('#app');
