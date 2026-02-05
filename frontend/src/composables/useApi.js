// src/composables/useApi.js
import { ref } from 'vue'
import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost/api',
})

const token = ref(localStorage.getItem('token') || null)

if (token.value) {
  api.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
}

export const useApi = () => {
  const login = async (email, password) => {
    const res = await api.post('/login_check', { email, password })
    token.value = res.data.token
    localStorage.setItem('token', token.value)
    api.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
    return res.data
  }

  const logout = () => {
    token.value = null
    localStorage.removeItem('token')
    delete api.defaults.headers.common['Authorization']
  }

  const getKanban = () => api.get('/kanban').then(r => r.data)
  const updateDeal = (id, data) => api.patch(`/deals/${id}`, data, {
    headers: { 'Content-Type': 'application/merge-patch+json' }
  }).then(r => r.data)

  return { login, logout, getKanban, updateDeal, token }
}