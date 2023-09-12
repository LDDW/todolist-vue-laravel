import { createRouter, createWebHistory } from "vue-router";

// import views
import Login from './views/auth/Login.vue';
import Register from './views/auth/Register.vue';
import Todolist from './views/Todolist.vue';
import Account from './views/Account.vue';
import PageNotFound from './views/PageNotFound.vue';
import Dashboard from './views/Dashboard.vue';
import axios from "axios";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "Login",
            component: Login,
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('token')) {
                    next('/dashboard')
                } else {
                    next()
                }
            }
        },
        {
            path: "/register",
            name: "Register",
            component: Register,
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('token')) {
                    next('/dashboard')
                } else {
                    next()
                }
            }
        },
        {
            path: "/dashboard",
            name: "dashboard",
            component: Dashboard,
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('token')) {
                    user()
                    next()
                } else {
                    next('/dashboard')
                }
            }
        },
        {
            path: "/todolist/:id",
            name: "Todolist",
            component: Todolist,
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('token')) {
                    user()
                    next()
                } else {
                    next('/login')
                }
            }
        },
        {
            path: "/account",
            name: "Account",
            component: Account,
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('token')) {
                    user()
                    next()
                } else {
                    next('/login')
                }
            }
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: PageNotFound,
        }
    ]
});

const user = async () => {
    try {
        let res = await axios.get('user')

        console.log(res.data)
    } catch (error) {
        console.log(error)
    }
}

export default router;