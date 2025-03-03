import './bootstrap'; // Load Laravel's bootstrap.js (e.g., CSRF tokens, etc.)
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// Create Vue app instance and mount it to the DOM element with id="app"
const app = createApp(App).use(router);

// Register components manually (if needed)
// Example component (remove if not required)
import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

// Alternatively, automatically register all components in the directory (uncomment to use)
Object.entries(import.meta.glob('./components/**/*.vue', { eager: true })).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

// Finally, mount the app to the DOM
app.mount('#app');
