

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';
import app from './views/App.vue';
import home from './views/home.vue';
import tes from './views/tesAPI.vue';
import { store } from './store/store';
import './filters/filters';
import VuePaginate from 'vue-paginate';
import VMdDateRangePicker from 'v-md-date-range-picker';

Vue.use(VuePaginate);
Vue.use(VueMaterial);
Vue.use(VueRouter);
Vue.use(VMdDateRangePicker);

const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes: [
        {path: '/asd', component: home},
        {path: '/masuk', component: app},
        {path: '/tesapi', component: tes}
    ]
});
 
new Vue({
    store: store,
    router
}).$mount('#app');