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
        v-for="author in filteredAuthors"
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
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useAuthorStore } from '../stores/authorStore'
import { storeToRefs } from 'pinia'

// Props
const props = defineProps({
  modelValue: {
    type: Array,
    required: true
  }
})
const emit = defineEmits(['update:modelValue'])

// Local state
const search = ref('')
const showList = ref(false)
const selectedAuthorIds = ref([...props.modelValue])

// Pinia store
const authorStore = useAuthorStore()
const { authors } = storeToRefs(authorStore)

onMounted(() => {
  authorStore.fetchAuthors()
})

const filteredAuthors = computed(() => {
  return authors.value.filter(author =>
    author.name.toLowerCase().includes(search.value.toLowerCase())
  )
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
