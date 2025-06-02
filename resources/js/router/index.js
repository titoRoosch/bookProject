import { createRouter, createWebHistory } from 'vue-router'
import BooksForm from '../pages/BooksForm.vue'
import BooksPage from '../pages/BooksPage.vue'
import AuthorsPage from '../pages/AuthorsPage.vue'
import Dashboard from '../pages/Dashboard.vue'
import Home from '../components/Home.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/books', name: 'books', component: BooksPage },
  { path: '/books/insert', name: 'booksForm', component: BooksForm },
  { path: '/authors', name: 'authors', component: AuthorsPage },
  { path: '/dashboard', name: 'dashboard', component: Dashboard },
]

export const router = createRouter({
  history: createWebHistory(),
  routes,
})
