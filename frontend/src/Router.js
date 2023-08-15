import { createRouter, createWebHistory } from "vue-router";

// import views
import Home from './views/Home.vue';
import Login from './views/auth/Login.vue';
import Register from './views/auth/Register.vue';
import Todolist from './views/Todolist.vue';
import Account from './views/Account.vue';
import PageNotFound from './views/PageNotFound.vue';
import Dashboard from './views/Dashboard.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "Home",
            component: Home,
        },
        {
            path: "/login",
            name: "Login",
            component: Login,
        },
        {
            path: "/register",
            name: "Register",
            component: Register,
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
        },
        {
            path: "/todolist/:id",
            name: "Todolist",
            component: Todolist,
            // beforeEnter: (to, from, next) => {
            //     if (localStorage.getItem('token')) {
            //         next()
            //     } else {
            //         next('/login')
            //     }
            // }
        },
        {
            path: "/account",
            name: "Account",
            component: Account,
            // beforeEnter: (to, from, next) => {
            //     if (localStorage.getItem('token')) {
            //         next()
            //     } else {
            //         next('/login')
            //     }
            // }
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: PageNotFound,
        }
    ]
});

export default router;