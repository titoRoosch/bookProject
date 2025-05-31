import { createRouter, createWebHistory } from 'vue-router'
import BooksPage from '../pages/BooksPage.vue'
import Home from '../components/Home.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/books', name: 'books', component: BooksPage },
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})
