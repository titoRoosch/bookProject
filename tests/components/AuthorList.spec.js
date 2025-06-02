import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import AuthorList from '@/Components/AuthorList.vue'
import { createTestingPinia } from '@pinia/testing'

describe('AuthorList.vue', () => {
  it('renders authors from store', () => {
    const wrapper = mount(AuthorList, {
      global: {
        plugins: [createTestingPinia({
          initialState: {
            authors: {
              authors: [
                { id: 1, name: 'Machado de Assis', birth_date: '1839-06-21' },
                { id: 2, name: 'Clarice Lispector', birth_date: '1920-12-10' }
              ]
            }
          }
        })]
      }
    })

    const rows = wrapper.findAll('tbody tr')
    expect(rows.length).toBe(2)
    expect(wrapper.text()).toContain('Machado de Assis')
    expect(wrapper.text()).toContain('Clarice Lispector')
  })
})
