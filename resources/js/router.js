import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Dashboard from './components/Dashboard.vue';
import CreatePlayer from './components/CreatePlayer.vue';
import ViewPlayers from './components/ViewPlayers.vue';
import TeamsPage from './components/TeamSelection.vue'; // Import the new TeamsPage component
import { useAuthStore } from './stores/auth'; // Import the auth store for navigation guards

const routes = [
    { path: '/', component: Dashboard, meta: { requiresAuth: true } }, // Protected route
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/create-player', component: CreatePlayer, meta: { requiresAuth: true } }, // Protected route
    { path: '/players', component: ViewPlayers, meta: { requiresAuth: true } }, // Protected route
    { path: '/teams', component: TeamsPage, meta: { requiresAuth: true } }, // New protected route for team management
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation guard to check authentication
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    // Check if the route requires authentication
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next('/login'); // Redirect to login if not authenticated
    } else {
        next(); // Proceed to the route
    }
});

export default router;