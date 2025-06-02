<template>
  <div class="p-6 space-y-8">
    <h1 class="text-2xl font-bold mb-4">Dashboard 📊</h1>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4 items-end">
      <div>
        <label class="text-sm font-semibold">From Year</label>
        <input type="number" v-model="fromYear" class="border px-2 py-1 rounded w-24" min="1900" :max="toYear" />
      </div>

      <div>
        <label class="text-sm font-semibold">To Year</label>
        <input type="number" v-model="toYear" class="border px-2 py-1 rounded w-24" :min="fromYear" :max="currentYear" />
      </div>

      <div>
        <label class="text-sm font-semibold">Top Authors</label>
        <input type="number" v-model="topAuthors" class="border px-2 py-1 rounded w-24" min="1" max="50" />
      </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Books by Year</h2>
        <canvas id="booksYearChart"></canvas>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Top Authors</h2>
        <canvas id="booksAuthorChart"></canvas>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({ layout: AuthenticatedLayout })

const currentYear = new Date().getFullYear()
const fromYear = ref(currentYear - 4)
const toYear = ref(currentYear)
const topAuthors = ref(5)

let booksYearChart = null
let booksAuthorChart = null

async function fetchDataAndUpdateCharts() {
  const query = new URLSearchParams({
    from_year: fromYear.value,
    to_year: toYear.value,
    top_authors: topAuthors.value
  }).toString()

  const res = await fetch(`/api/dashboard?${query}`)
  const data = await res.json()

  // Books by year chart
  const anoCtx = document.getElementById('booksYearChart').getContext('2d')
  if (booksYearChart) booksYearChart.destroy()
  booksYearChart = new Chart(anoCtx, {
    type: 'bar',
    data: {
      labels: data.books_by_year.map(item => item.year),
      datasets: [{
        label: 'Books',
        data: data.books_by_year.map(item => item.total),
        backgroundColor: '#4f46e5'
      }]
    },
    options: { responsive: true }
  })

  // Books by author chart
  const autorCtx = document.getElementById('booksAuthorChart').getContext('2d')
  if (booksAuthorChart) booksAuthorChart.destroy()
  booksAuthorChart = new Chart(autorCtx, {
    type: 'doughnut',
    data: {
      labels: data.books_by_author.map(item => item.name),
      datasets: [{
        label: 'Books',
        data: data.books_by_author.map(item => item.books_count),
        backgroundColor: ['#4f46e5', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9']
      }]
    },
    options: { responsive: true }
  })
}

onMounted(fetchDataAndUpdateCharts)

watch([fromYear, toYear, topAuthors], fetchDataAndUpdateCharts)
</script>
