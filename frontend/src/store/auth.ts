import { defineStore } from 'pinia'
import axiosInstance from '@/plugins/axios'

interface User {
  id: number
  name: string
  email: string
  is_admin: boolean
}

interface UserRegister {
  name: string,
  email: string,
  password: string,
  password_confirmation: string
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as User | null,
    token: null as string | null,
  }),

  getters: {
    isAuthenticated: (state) => {
      console.log(state)
      return !!state.token}
  },

  actions: {
    async login(payload: { email: string; password: string }) {
      try {
        const response = await axiosInstance.post('/login', payload)
        const token = response.data.access_token

        this.setToken(token)
        this.loadToken()
        await this.fetchUser()
      } catch (error) {
        this.logout()
        throw error
      }
    },

    async register(payload: UserRegister) {
      try {
        const response = await axiosInstance.post('/register', payload)
        const token = response.data.access_token

        this.setToken(token)
        this.loadToken()
        await this.fetchUser()
      } catch (error) {
        this.logout()
        throw error
      }
    },

    // Buscar usuário autenticado
    async fetchUser() {
      try {
        const response = await axiosInstance.get('/user')
        console.log('Resposta user> ', response)
        this.user = response.data
      } catch (error) {
        console.error('Erro ao buscar usuário:', error)
        this.logout()
      }
    },

    // Salva o token
    setToken(token: string) {
      this.token = token
      localStorage.setItem('access_token', token)
    },

    // Carrega o token salvo (ex: onMounted)
    loadToken() {
      const token = localStorage.getItem('access_token')
      if (token) this.token = token
    },

    // Remove tudo
    logout() {
      this.token = null
      this.user = null
      localStorage.removeItem('access_token')
    },
  },
})
