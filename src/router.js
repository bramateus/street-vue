import Vue from "vue";
import Router from "vue-router";
import Leader from "./components/Leader.vue";
import Principal from "./components/Principal.vue";
import Modal from "./components/Modal.vue";

Vue.use(Router);

export default new Router({
    mode: "history",
    base: 'street-vue/',
    routes: [
        {
            path: "/",
            component: Principal
        },
        {
            path: "/leaderboards",
            name: "leaderboards",
            component: Leader
        },
        {
            path: "/Modal",
            name: "modal",
            component: Modal
        }
    ]
})