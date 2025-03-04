<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-gray-100 to-white">
        <div class="bg-white rounded-xl shadow-2xl p-10 w-full max-w-md">
            <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Register</h2>
            <form @submit.prevent="registerUser" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" v-model="form.name"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Your Name" required />
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" v-model="form.email"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="you@example.com" required />
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" v-model="form.password"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="********" required />
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" id="password_confirmation" v-model="form.password_confirmation"
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="********" required />
                </div>
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Register</button>
                <div v-if="errorMessage" class="text-red-600 text-center mt-4">{{ errorMessage }}</div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Register',
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            errorMessage: null,
        };
    },
    methods: {
        async registerUser() {
            try {
                this.errorMessage = null;
                const response = await axios.post('/api/register', this.form);
                console.log(response.data);
                this.$router.push('/login');
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'An error occurred.';
            }
        },
    },
};
</script>