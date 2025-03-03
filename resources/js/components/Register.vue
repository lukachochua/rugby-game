<template>
    <div class="max-w-md mx-auto mt-8">
        <h2 class="text-2xl font-bold text-center">Register</h2>
        <form @submit.prevent="registerUser" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" v-model="form.name" class="w-full px-4 py-2 mt-1 border rounded-md" />
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" v-model="form.email" class="w-full px-4 py-2 mt-1 border rounded-md" />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" v-model="form.password"
                    class="w-full px-4 py-2 mt-1 border rounded-md" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <input type="password" id="password_confirmation" v-model="form.password_confirmation"
                    class="w-full px-4 py-2 mt-1 border rounded-md" />
            </div>
            <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-md">Register</button>
            <div v-if="errorMessage" class="text-red-500 text-center mt-4">{{ errorMessage }}</div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
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
                // handle success: store the token or redirect
                console.log(response.data);
                this.$router.push('/login');
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'An error occurred.';
            }
        },
    },
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>