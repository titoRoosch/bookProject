<template>
  <div class="relative">
    <div class="flex gap-2">
      <input
        type="text"
        v-model="search"
        placeholder="Buscar autor..."
        class="border px-2 py-1 w-full"
        @focus="showList = true"
      />
      <button
        type="button"
        @click="showList = !showList"
        class="border px-3 py-1 bg-gray-100 text-sm"
      >
        {{ showList ? '▲' : '▼' }}
      </button>
    </div>

    <div
      v-if="showList"
      class="absolute z-10 bg-white border w-full max-h-60 overflow-y-auto mt-1 rounded shadow"
    >
      <label
        v-for="author in authors"
        :key="author.id"
        class="block px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm"
      >
        <input
          type="checkbox"
          :value="author.id"
          :checked="selectedAuthorIds.includes(author.id)"
          @change="toggleAuthor(author.id)"
          class="mr-2"
        />
        {{ author.name }}
      </label>

      <div v-if="hasMorePages" class="text-center py-2">
        <button
          type="button"
          class="text-blue-600 text-sm hover:underline"
          @click="loadMore"
        >
          Carregar mais
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useAuthorStore } from '../stores/authorStore'
import { storeToRefs } from 'pinia'

const props = defineProps({
  modelValue: {
    type: Array,
    required: true
  }
})
const emit = defineEmits(['update:modelValue'])

const search = ref('')
const showList = ref(false)
const selectedAuthorIds = ref([...props.modelValue])
const currentPage = ref(1)

const authorStore = useAuthorStore()
const { authors, pagination } = storeToRefs(authorStore)

const fetchAuthors = async (page = 1, reset = false) => {
  const response = await authorStore.fetchAuthors({ page, search: search.value })

  if (reset) {
    currentPage.value = 1
  } else {
    currentPage.value = page
  }
}

const loadMore = async () => {
  if (hasMorePages.value) {
    await fetchAuthors(currentPage.value + 1)
  }
}

const hasMorePages = ref(false)

watch(pagination, () => {
  hasMorePages.value =
    pagination.value?.current_page < pagination.value?.last_page
})

onMounted(async () => {
  await fetchAuthors(1, true)
})

watch(search, async () => {
  await fetchAuthors(1, true)
})

function toggleAuthor(authorId) {
  const index = selectedAuthorIds.value.indexOf(authorId)
  if (index === -1) {
    selectedAuthorIds.value.push(authorId)
  } else {
    selectedAuthorIds.value.splice(index, 1)
  }
  emit('update:modelValue', [...selectedAuthorIds.value])
}

watch(() => props.modelValue, (newVal) => {
  selectedAuthorIds.value = [...newVal]
})
</script>
