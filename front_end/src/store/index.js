import { http } from '@/http'
import { createStore } from 'vuex'

export default createStore({
    state: {
        user: {},
        token: localStorage.getItem('token') || '',
        isLoggedIn: false
    },
    getters: {
    },
    mutations: {
        setUser: (state, payload) => {
            state.user = payload
        },
        setToken: (state, payload) => {
            state.token = payload
            localStorage.setItem('token', payload)
        },
        setIsLoggedIn: (state, payload) => {
            state.isLoggedIn = payload
        }
    },
    actions: {
         Login: async ({ commit }, payload) => {
            try {
                const response = await http.post('login', { usuario: payload.usuario, senha: payload.senha })
                if (response.status == '201'){
                    commit('setToken', response.data.token)
                    commit('setIsLoggedIn', true)
                    return true;
                }
            }catch(error) {
                commit('setIsLoggedIn', false)
                return false;
            }
            
        },
        async checkLogin ({ commit }, payload) {
            try{

                const response = await http.post('login/verificar', {}, {
                    headers: {
                        'Authorization': `Bearer ${this.state.token}`
                    }
                })

                if (response.status == '200') {
                    commit('setIsLoggedIn', true)
                }

            }catch(error) {
                if (error.response.status == '401') {
                    commit('setToken', '')
                    commit('setIsLoggedIn', false)
                }
            }
        }
    },
    modules: {
    }

})
