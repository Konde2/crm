<!-- src/views/LoginView.vue -->
<template>
    <div class="login-view">
      <h2>Вход в систему</h2>
      <form @submit.prevent="handleLogin">
        <input v-model="email" placeholder="Email" type="email" required />
        <input v-model="password" placeholder="Пароль" type="password" required />
        <button type="submit">Войти</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue'
  import { useApi } from '@/composables/useApi'
  import { useRouter } from 'vue-router'
  
  export default {
    name: 'LoginView',
    setup() {
      const email = ref('')
      const password = ref('')
      const { login } = useApi()
      const router = useRouter()
  
      const handleLogin = async () => {
        try {
          await login(email.value, password.value)
          router.push('/')
        } catch (error) {
          alert('Ошибка входа')
          console.error(error)
        }
      }
  
      return { email, password, handleLogin }
    }
  }
  </script>
  
  <style scoped>
  .login-view {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
  }
  input, button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  </style>