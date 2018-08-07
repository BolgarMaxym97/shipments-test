/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Notifications from 'vue-notification';
import VModal from 'vue-js-modal';
import MomentJs from 'vue-moment';
import Tooltip from 'vue-directive-tooltip';
import MixinsMethods from './mixinsMethods.js';
import 'vue-directive-tooltip/css/index.css';

Vue.use(Notifications);
Vue.use(VModal);
Vue.use(MomentJs);
Vue.use(Tooltip);

Vue.component('shipments', require('./components/Shipments.vue'));

Vue.mixin(MixinsMethods);

const app = new Vue({
    el: '#app'
});
