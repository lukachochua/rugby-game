<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold mb-6">Login</h2>
            <form @submit.prevent="login">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" v-model="email"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm"
                        placeholder="Enter your email" required />
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" v-model="password"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm"
                        placeholder="Enter your password" required />
                </div>
                <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

export default {
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
                // Set the token in the store (which will update localStorage and reactive state)
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
