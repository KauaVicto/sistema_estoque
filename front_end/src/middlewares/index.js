import store from "../store";

const middlewares = {
    LoginMiddleware: async (to, from, next) => {
        await store.dispatch('checkLogin');
        if (store.state.isLoggedIn) {
            return next({ name: 'home' });
        }
        return next();
    },
    AuthMiddleware: async (to, from, next) => {
        await store.dispatch('checkLogin');
        if (!store.state.isLoggedIn) {
            return next({ name: 'login' });
        }
        return next();
    }
}

export { middlewares }