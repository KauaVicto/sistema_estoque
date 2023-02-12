import store from '../../store';

export default [
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "about" */ './HomeView'),
        beforeEnter: async (to, from, next) => {
            await store.dispatch('checkLogin')
            if (!store.state.isLoggedIn) {
                return next({ name: 'login' })
            }
            next()
        }
    },
]