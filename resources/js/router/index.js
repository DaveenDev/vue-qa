import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes'

Vue.use(VueRouter)

const router=new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active' //this will rename the router-link-active class into active
    
});

router.beforeEach((to, from, next)=>{ //route event that is triggered on accessing routes
    if(to.matched.some(r=>r.meta.requiresAuth) && !window.Auth.signedIn){
        //next({name: 'login'})
        window.location=window.Urls.login
        return
    }
    next()
});

export default router