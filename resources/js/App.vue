<template>
    <div>
        <nav
            class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg">
            <div>
                <router-link to="/" class="text-2xl font-bold">Rugby Game</router-link>
            </div>
            <div>
                <template v-if="!isAuthenticated">
                    <router-link to="/login" class="px-3 py-1 hover:underline">Login</router-link>
                    <router-link to="/register" class="px-3 py-1 hover:underline">Register</router-link>
                </template>
                <template v-else>
                    <router-link to="/create-player" class="px-3 py-1 hover:underline">Create Player</router-link>
                    <router-link to="/players" class="px-3 py-1 hover:underline">View Players</router-link>
                    <button @click="logout" class="px-3 py-1 hover:underline">Logout</button>
                </template>
            </div>
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
        const isAuthenticated = computed(() => authStore.isAuthenticated);
        const logout = () => {
            authStore.logout();
            router.push('/login');
        };

        return { isAuthenticated, logout };
    },
};
</script>