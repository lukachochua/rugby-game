import './bootstrap'; // Load Laravel's bootstrap.js (e.g., CSRF tokens, etc.)
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';

const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);

// Optionally, automatically register all components in the directory
Object.entries(import.meta.glob('./components/**/*.vue', { eager: true })).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

app.mount('#app');
