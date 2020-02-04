import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './components/Login'
import Home from './components/Home'

import StoreApp from './store/App'

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        // {
        //     path: '/',
        //     redirect: '/Login'
        // },
        {
            name: 'Login',
            path: '/Login',
            component: Login
        },
        {
            name: 'Home',
            path: '/Home',
            component: Home,
            beforeEnter: (to, from, next) => {
                if(StoreApp.state.user === null)
                    next('/Login');
                else 
                    next();
            }
        },
    ],
    mode: 'history'
});

// router.beforeEach();


export default router;