import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import BookList from '@/Components/BookList.vue'
import { createTestingPinia } from '@pinia/testing'

describe('BookList.vue', () => {
  it('renders book titles', () => {
    const wrapper = mount(BookList, {
      global: {
        plugins: [createTestingPinia({
          initialState: {
            books: {
              books: [
                { id: 1, title: 'Book A', publish_date: '2020-01-01' },
                { id: 2, title: 'Book B', publish_date: '2021-01-01' }
              ],
              pagination: {}
            }
          },
          stubActions: false,
        })]
      }
    })

    expect(wrapper.text()).toContain('Book A')
    expect(wrapper.text()).toContain('Book B')
  })
})
