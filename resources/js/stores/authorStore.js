import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthorStore = defineStore('authors', {
  state: () => ({
    authors: [],
    pagination: {},
    filters: {
      search: '',
      author_id: null,
    },
  }),
  actions: {
    async fetchAuthors(params = {}) {
      const response = await axios.get('/api/author/index', { params: { ...this.filters, ...params } })
      console.log(response.data);
      this.authors = response.data
      this.pagination = response.data
    }
  }
})