<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold mb-6">Create Account</h2>
            <form @submit.prevent="register">
                <!-- Input fields for email, password, etc. -->
                <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700">Register</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            error: null
        };
    },
    methods: {
        async Register() {
            try {
                let response = await axios.post('/api/auth/register', {
                    email: this.email,
                    password: this.password
                });
                localStorage.setItem('token', response.data.token);
                this.$router.push('/');
            } catch (err) {
                this.error = "Invalid credentials";
            }
        }
    }
};
</script>