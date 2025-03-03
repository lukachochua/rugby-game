import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('token') || null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        setToken(newToken) {
            this.token = newToken;
            if (newToken) {
                localStorage.setItem('token', newToken);
            } else {
                localStorage.removeItem('token');
            }
        },
        logout() {
            this.setToken(null);
        },
    },
});
