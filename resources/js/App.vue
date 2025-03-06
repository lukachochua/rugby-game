<template>
    <div>
        <!-- Navigation Bar -->
        <nav
            class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg">
            <div>
                <router-link to="/" class="text-2xl font-bold">Rugby Game</router-link>
            </div>
            <div>
                <!-- Show login/register links if not authenticated -->
                <template v-if="!isAuthenticated">
                    <router-link to="/login" class="px-3 py-1 hover:underline">Login</router-link>
                    <router-link to="/register" class="px-3 py-1 hover:underline">Register</router-link>
                </template>
                <!-- Show authenticated user links -->
                <template v-else>
                    <router-link to="/create-player" class="px-3 py-1 hover:underline">Create Player</router-link>
                    <router-link to="/players" class="px-3 py-1 hover:underline">View Players</router-link>
                    <router-link to="/teams" class="px-3 py-1 hover:underline">Manage Teams</router-link>
                    <button @click="logout" class="px-3 py-1 hover:underline">Logout</button>
                </template>
            </div>
        </nav>

        <!-- Router View for rendering pages -->
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

        // Check if the user is authenticated
        const isAuthenticated = computed(() => authStore.isAuthenticated);

        // Logout function
        const logout = async () => {
            await authStore.logout(); // Call the logout action from the auth store
            router.push('/login'); // Redirect to the login page
        };

        return { isAuthenticated, logout };
    },
};
</script>