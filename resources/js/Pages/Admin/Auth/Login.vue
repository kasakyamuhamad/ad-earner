<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const submit = () => {
  form.post(route('admin.login'))
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>

      <form @submit.prevent="submit">
        <!-- Email -->
        <div class="mb-4">
          <label class="block text-gray-700">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full mt-1 px-3 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
          <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
            {{ form.errors.email }}
          </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label class="block text-gray-700">Password</label>
          <input
            v-model="form.password"
            type="password"
            class="w-full mt-1 px-3 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
          <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">
            {{ form.errors.password }}
          </div>
        </div>

        <!-- Remember -->
        <div class="mb-4 flex items-center">
          <input type="checkbox" v-model="form.remember" class="mr-2" />
          <span>Remember me</span>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          :disabled="form.processing"
          class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 disabled:opacity-50"
        >
          Login
        </button>
      </form>
    </div>
  </div>
</template>
