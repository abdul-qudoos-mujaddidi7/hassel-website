import { createApp } from 'vue';
import AdminApp from './AdminApp.vue';
import router from './router';
import '../bootstrap';

const app = createApp(AdminApp);

app.use(router);

app.mount('#admin-app');

