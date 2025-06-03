import { defineStore } from 'pinia'
import axios from 'axios'
axios.defaults.withCredentials = true

export const useDashboardStore = defineStore('dashboard', {
  state: () => ({
    livrosPorAno: [],
    livrosPorAutor: [],
    loaded: false
  }),

  actions: {
    async fetchDashboard() {
      if (!this.loaded) {
        const { data } = await axios.get('/api/dashboard')
        this.livrosPorAno = data.livros_por_ano
        this.livrosPorAutor = data.livros_por_autor
        this.loaded = true
      }
    }
  }
})
