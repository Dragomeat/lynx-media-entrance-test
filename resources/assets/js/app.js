import Vue from 'vue';
import App from './App';
import ElementUI from 'element-ui';
import VueDataTables from 'vue-data-tables';

import 'element-ui/lib/theme-chalk/index.css';

import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

locale.use(lang);

Vue.use(ElementUI);
Vue.use(VueDataTables);

new Vue({
    el: '#app',
    template: '<App/>',
    components: { App }
});
