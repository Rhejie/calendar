/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
    Vue.component(
        key
            .split("/")
            .pop()
            .split(".")[0],
        files(key).default
    )
);

import Vue from "vue";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import "element-ui/lib/theme-chalk/display.css";
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import locale from "element-ui/lib/locale/lang/en";
import FullCalendar from 'vue-full-calendar';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
Vue.use(Vuetify)
Vue.use(ElementUI, { locale, size: "small" });
Vue.config.productionTip = false;
Vue.use(FullCalendar);

import API from "./api/index.js";

Vue.prototype.$API = API;

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify()
});
