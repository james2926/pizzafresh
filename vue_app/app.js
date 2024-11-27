require('./bootstrap');
// Require Vue
import Vue from 'vue'

// Register Vue Components
import vuetify from './vuetify_installer/vuetify_installer'
import Main from "./components/main/Main.vue";
import router from './router/router.js';
import auth from './auth/auth.js';
import store from './store/store.js';
import moment from 'moment';
// Initialize Vue
const app = new Vue({
    el: '#app',
    vuetify,
    auth,
    router,
    store,

    components: {
        "main-component": Main
    },
    mounted() {
        if (auth.check()) {
            this.$store.dispatch('getRoles', this);
            this.$store.dispatch('getPais', this);
          }
        },
});