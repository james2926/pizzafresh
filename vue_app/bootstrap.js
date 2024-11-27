window._ = require("lodash");
window.Vue = require("vue");
window.moment = require('moment')
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import VuetifyToast from "vuetify-toast-snackbar-ng";
window.axios = require("axios");

//window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem(
    "id_token"
)}`;
import Loader from "./base/Loader.vue";
import dynamic_select from "./components/general/dynamicSelect.vue";
import multiple_select from "./components/general/multipleSelect.vue";
import date_select from "./components/general/dateSelect.vue";
import plan_picker from "./components/general/planpicker/planPicker.vue";
import plan_show from "./components/general/planpicker/planShow.vue";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import Vue from "vue";
import VueBarcodeScanner from "vue-barcode-scanner";

Vue.component("dynamic-select", dynamic_select);
Vue.component("multiple-select", multiple_select);
Vue.component("date-select", date_select);
Vue.component("plan-picker", plan_picker);
Vue.component("plan-show", plan_show);

Vue.component("loader", Loader);
import { VTextField } from "vuetify/lib";
Vue.component("TextFieldOutlined", {
    extends: VTextField,
    props: {
        outlined: {
            type: Boolean,
            default: true,
        },
    },
});
import VTextFieldOutlined from "./components/general/textfieldwrapper.vue";
Vue.component("VTextFieldOutlined", VTextFieldOutlined);
import VAutocompleteOutlined from "./components/general/autocompletewrapper.vue";
Vue.component("VAutocompleteOutlined", VAutocompleteOutlined);

Vue.filter('formatArticuloTitle', function(value) {
    if (!value) return '';  // Si el valor es nulo o indefinido, retorna una cadena vacía
    
    const title = value.toLowerCase();

    // Reemplaza "bola" por "B." y "unidades" por "und"
    return title.replace(/bola/g, 'B.').replace(/unidades/g, 'uds');  
});

/**
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
import Echo from "laravel-echo";
window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "abcdefg",
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
    encrypted: false,
    forceTLS: false,

    enabledTransports: ["ws"],
});

Vue.use(VueSweetalert2, {});
Vue.filter("format_date", function (value) {
    let str = (value + "T").split("T")[0].split("-");
    return `${str[2]}/${str[1]}/${str[0]}`;
});

Vue.filter("format_date_time", function (value) {
    let str;
    if(value.includes("T")){
        str = value.split("T");
    }else{
        str = value.split(" ");
    }

    let time = str[1].split(" ")[0]
        .split(":");
    str = str[0].split(" ")[0]
        .split("-");
        
    return `${str[2]}/${str[1]}/${str[0]} ${time[0]}:${time[1]}`;
});

Vue.filter("format_number", function (value) {
    return parseFloat(value).toFixed(2).replace('.',',');
});

const swal_custom = {
    install(app, options) {
        app.prototype.$custom_error = (key) => {
            app.prototype.$swal({
                icon: "error",
                title: "Error",
                text: key,
            });
        };
    },
};
let options = {
    sound: true, // default is false
    soundSrc: "/static/sound.wav", // default is blank
    sensitivity: 300, // default is 100
    requiredAttr: true, // default is false
    controlSequenceKeys: ["NumLock", "Clear"], // default is null
    callbackAfterTimeout: true, // default is false
};

Vue.use(VueBarcodeScanner, options);
Vue.use(swal_custom);
Vue.use(VuetifyToast, {
    x: "right",
    y: "top",
    color: "info",
    icon: "mdi-info",
    timeout: 3000,
    dismissable: true,
    autoHeight: false,
    multiLine: false,
    vertical: false,
    shorts: {
        error: {
            color: "red",
        },
        sucs: {
            color: "green",
        },
        warn: {
            color: "orange",
        },
    },
    property: "$toast",
});
