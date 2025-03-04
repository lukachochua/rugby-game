<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-100 to-white">
        <div class="bg-white rounded-xl shadow-2xl p-10 w-full max-w-md">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Login</h2>
            <form @submit.prevent="login" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" v-model="email"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="you@example.com" required />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" v-model="password"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="********" required />
                </div>
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Login</button>
                <div v-if="error" class="text-red-600 text-center mt-4">{{ error }}</div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: '',
            error: null,
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password,
                });
                const authStore = useAuthStore();
                authStore.setToken(response.data.token);
                this.$router.push('/');
            } catch (err) {
                this.error = "Invalid credentials";
            }
        },
    },
};
</script>