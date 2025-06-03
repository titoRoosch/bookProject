import { defineStore } from 'pinia'
import axios from 'axios'
axios.defaults.withCredentials = true

export const useBookStore = defineStore('books', {
  state: () => ({
    books: [],
    pagination: {},
    filters: {
      search: '',
      author_id: null,
    },
  }),
  actions: {
    async fetchBooks(params = {}) {
      const response = await axios.get('/api/book/index', {
        params: { ...this.filters, ...params }
      })

      this.books = response.data.data
      this.pagination = response.data
    }
  }
})
