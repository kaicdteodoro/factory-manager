import routes from "./routes.js";
import {createRouter, createWebHistory} from "vue-router";
import {useAuthStore} from "../pinia.js";


// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(),
    routes, // short for `routes: routes`
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;
    let {authenticated} = useAuthStore();

    if (to.meta.middleware === "guest") {
        if (authenticated) {
            next({name: "home"})
        }
        next()
    } else {
        if (authenticated) {
            next()
        } else {
            next({name: "login"})
        }
    }
});

export default router;
