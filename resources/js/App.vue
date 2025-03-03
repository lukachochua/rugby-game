
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
export default {
    name: 'App',
    data() {
        return {
            token: localStorage.getItem('token') || null,
        };
    },
    computed: {
        isAuthenticated() {
            return !!this.token;
        },
    },
    methods: {
        logout() {
            localStorage.removeItem('token');
            this.token = null;  // Update reactive property
            this.$router.push('/login');
        },
    },
    created() {
        // Optionally, listen for token changes from other components
        window.addEventListener('storage', this.syncToken);
    },
    beforeUnmount() {
        window.removeEventListener('storage', this.syncToken);
    },
    methods: {
        logout() {
            localStorage.removeItem('token');
            this.token = null;
            this.$router.push('/login');
        },
        syncToken() {
            this.token = localStorage.getItem('token');
        },
    },
};
</script>