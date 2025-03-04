import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Dashboard from './components/Dashboard.vue';
import CreatePlayer from './components/CreatePlayer.vue';
import ViewPlayers from './components/ViewPlayers.vue';

const routes = [
    { path: '/', component: Dashboard },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/create-player', component: CreatePlayer },
    { path: '/players', component: ViewPlayers },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
