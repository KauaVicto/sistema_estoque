/* eslint-disable */
import Vue from 'vue'
import Vuex from 'vuex'
import { http } from '../http'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {

    /* NavBar */
    isNavBarVisible: true,

    /* FooterBar */
    isFooterBarVisible: true,

    /* Aside */
    isAsideVisible: true,
    isAsideMobileExpanded: false,


    user: {},
    token: localStorage.getItem('token') || sessionStorage.getItem('token') || '',
    isLoggedIn: false,
    remember: false
  },
  mutations: {
    /* A fit-them-all commit */
    basic(state, payload) {
      state[payload.key] = payload.value
    },


    /* Aside Mobile */
    asideMobileStateToggle(state, payload = null) {
      const htmlClassName = 'has-aside-mobile-expanded'

      let isShow

      if (payload !== null) {
        isShow = payload
      } else {
        isShow = !state.isAsideMobileExpanded
      }

      if (isShow) {
        document.documentElement.classList.add(htmlClassName)
      } else {
        document.documentElement.classList.remove(htmlClassName)
      }

      state.isAsideMobileExpanded = isShow
    },

    /* Full Page mode */
    fullPage(state, payload) {
      state.isNavBarVisible = !payload
      state.isAsideVisible = !payload
      state.isFooterBarVisible = !payload
    },
    setUser: (state, payload) => {
      state.user = payload
    },
    setToken: (state, payload) => {
      state.token = payload
      if (payload == '') {
        localStorage.removeItem('token')
        sessionStorage.removeItem('token')
        return
      }
      if (state.remember){
        localStorage.setItem('token', payload)
      } else {
        sessionStorage.setItem('token', payload)
      }
    },
    setIsLoggedIn: (state, payload) => {
      state.isLoggedIn = payload
    },
    setRemember: (state, payload) => {
      state.remember = payload
    }
  },
  actions: {
    asideDesktopOnlyToggle(store, payload = null) {
      let method

      switch (payload) {
        case true:
          method = 'add'
          break
        case false:
          method = 'remove'
          break
        default:
          method = 'toggle'
      }
      document.documentElement.classList[method]('has-aside-desktop-only-visible')
    },
    toggleFullPage({ commit }, payload) {
      commit('fullPage', payload)

      document.documentElement.classList[!payload ? 'add' : 'remove']('has-aside-left', 'has-navbar-fixed-top')
    },
    fetch({ commit }, payload) {
      http
        .get(`data-sources/${payload}.json`)
        .then((r) => {
          if (r.data && r.data.data) {
            commit('basic', {
              key: payload,
              value: r.data.data
            })
          }
        })
        .catch(error => {
          alert(error.message)
        })
    },
    setTokenAction({ commit }, payload) {
      commit('setToken', payload)
    },
    async Login({ commit }, payload) {
      commit('setRemember', payload.remember)
      return await http.post('login', { usuario: payload.usuario, senha: payload.senha })
    },
    async Logout({ commit }, payload) {
      commit('setToken', '');
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
      return
    }
  }
})

export default store

export function useStore() {
  return store
}
