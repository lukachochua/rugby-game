<template>
    <div>
        <nav class="p-4 bg-gray-200">
            <router-link to="/">Dashboard</router-link>
            <span v-if="!isAuthenticated">
                | <router-link to="/login">Login</router-link>
                | <router-link to="/register">Register</router-link>
            </span>
            <span v-else>
                | <a href="#" @click.prevent="logout">Logout</a>
            </span>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
import { useAuthStore } from './stores/auth';
import { computed } from 'vue';
import { useRouter } from 'vue-router';

export default {
    name: 'App',
    setup() {
        const authStore = useAuthStore();
        const router = useRouter();

        // Use the store's reactive getter
        const isAuthenticated = computed(() => authStore.isAuthenticated);

        function logout() {
            authStore.logout();
            router.push('/login');
        }

        return { isAuthenticated, logout };
    },
};
</script>