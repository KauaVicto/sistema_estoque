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
            if (payload != '') {
                localStorage.setItem('token', payload)
            } else {
                localStorage.removeItem('token')
            }
        },
        setIsLoggedIn: (state, payload) => {
            state.isLoggedIn = payload
        }
    },
    actions: {
        setTokenAction ({ commit }, payload) {
            commit('setToken', payload)
        },
        async Login({ commit }, payload) {
            return await http.post('login', { usuario: payload.usuario, senha: payload.senha })
                // .then(res => {
                //     /* commit('setToken', res.data.token)
                //      */

                // }).catch(error => {
                //     commit('setIsLoggedIn', false)

                //     if (error.response.data.msg == 'USUARIO NÃO ENCONTRADO') {
                //         var msg = 'Usuário não encontrado!';
                //     } else if (error.response.data.msg == 'SENHA INCORRETA') {
                //         var msg = 'Senha incorreta!';
                //     }

                // })
        },
        async checkLogin({ commit }, payload) {
            try {

                const response = await http.post('login/verificar', {}, {
                    headers: {
                        'Authorization': `Bearer ${this.state.token}`
                    }
                })

                if (response.status == '200') {
                    commit('setIsLoggedIn', true)
                }

            } catch (error) {
                if (error.response.status == '401') {
                    commit('setToken', '')
                    commit('setIsLoggedIn', false)
                }
            }
            console.log('opa')
            return
        }
    },
    modules: {
    }

})
