
import Vue from 'vue'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
require('./bootstrap');
window.Vue = require('vue');
import Vuetify from 'vuetify'
import router from './router'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import App from './components/app'
const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
        icons:{
            iconfont: 'mdi'
        }
    }),
    components:{App},
    router,

}).$mount('#app');
