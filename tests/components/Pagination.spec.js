import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import Pagination from '@/Components/Pagination.vue'

describe('Pagination.vue', () => {
  it('renders correct page buttons and emits on click', async () => {
    const wrapper = mount(Pagination, {
      props: {
        currentPage: 2,
        totalPages: 5
      }
    })

    const pageButtons = wrapper.findAll('button').filter(b => /^\d+$/.test(b.text()))
    expect(pageButtons.length).toBe(5)

    await pageButtons[3].trigger('click') // index 3 = página 4
    expect(wrapper.emitted().change[0]).toEqual([4])
  })
})
