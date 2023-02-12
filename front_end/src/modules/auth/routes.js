import store from '../../store';

export default [
    {
        path: '/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "login" */ './views/LoginView'),
        beforeEnter: async (to, from, next) => {
            await store.dispatch('checkLogin')
            if (store.state.isLoggedIn) {
                return next({ name: 'home' })
            }
            return next()
        }
    },
]