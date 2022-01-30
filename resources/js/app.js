require('./bootstrap');
import Vue from 'vue';
import jQuery from 'jquery';
window.jQuery = window.$ = jQuery;
jQuery.noConflict();

import VueRouter from 'vue-router';
import routes from './routes';
import Mixin from '@/mixins/mixin';
import { initialize } from './helper/permissionHandle';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate';
import StoreData from './store';
import VueToastr from '@deveodk/vue-toastr';
import VueSweetalert2 from 'vue-sweetalert2';
import axios from 'axios'
import VueAxios from 'vue-axios'
import vSelect from 'vue-select'
import DatePicker from 'vue2-datepicker';


try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}


//Dom attribute Define
const router = new VueRouter({
    mode: 'history',
    routes,
});

Vue.use(Vuex);
const store = new Vuex.Store(StoreData);

// Import Use Section
Vue.use(VueRouter);
Vue.component('v-select', vSelect)
Vue.use(VeeValidate, {
    events: 'input',
    fieldsBagName: '',
});

Vue.use(VueToastr, {
    defaultPosition: 'toast-bottom-right',
    defaultType: 'info',
    defaultTimeout: 2000
});

Vue.use(VueSweetalert2);
Vue.use(VueAxios, axios);

//component Register
import pagination from './components/utilities/pagination'
import dataFilter from './components/dataTable/filter'
import dataTable from './components/dataTable/dataTable'
import baseModal from './components/modal/baseModal'
import createButton from './components/buttons/createButton'
import eyeButton from './components/buttons/eyeButton'
import editButton from './components/buttons/editButton'
import deleteButton from './components/buttons/deleteButton'
import pageHeading from './components/layouts/pageHeading'
import listCount from './components/dataTable/listCount'
import addNew from './components/utilities/addNew.vue'
import returnButton from './components/buttons/returnButton'


Vue.component('pagination', pagination);
Vue.component('dataFilter', dataFilter);
Vue.component('data-table', dataTable);
Vue.component('base-modal', baseModal);
Vue.component('create-button', createButton);
Vue.component('eye-button', eyeButton);
Vue.component('edit-button', editButton);
Vue.component('delete-button', deleteButton);
Vue.component('page-heading', pageHeading);
Vue.component('list-count', listCount);
Vue.component('add-new', addNew);
Vue.component('date-picker', DatePicker);
Vue.component('return-button', returnButton);

// Vue Dom Handeler
initialize(store, router);
Vue.mixin(Mixin);
const app = new Vue({
    el: '#app',
    router,
    store,
    axios
});