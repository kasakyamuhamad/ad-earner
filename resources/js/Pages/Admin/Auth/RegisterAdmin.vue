<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.post(route('admin.register.store'))
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
      <h2 class="text-2xl font-bold text-center mb-6">Create New Admin</h2>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label>First Name</label>
          <input v-model="form.first_name" class="w-full mt-1 border rounded px-3 py-2"/>
          <div v-if="form.errors.first_name" class="text-red-500 text-sm">{{ form.errors.first_name }}</div>
        </div>

        <div class="mb-4">
          <label>Last Name</label>
          <input v-model="form.last_name" class="w-full mt-1 border rounded px-3 py-2"/>
          <div v-if="form.errors.last_name" class="text-red-500 text-sm">{{ form.errors.last_name }}</div>
        </div>

        <div class="mb-4">
          <label>Email</label>
          <input v-model="form.email" type="email" class="w-full mt-1 border rounded px-3 py-2"/>
          <div v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</div>
        </div>

        <div class="mb-4">
          <label>Phone</label>
          <input v-model="form.phone" class="w-full mt-1 border rounded px-3 py-2"/>
          <div v-if="form.errors.phone" class="text-red-500 text-sm">{{ form.errors.phone }}</div>
        </div>

        <div class="mb-4">
          <label>Password</label>
          <input v-model="form.password" type="password" class="w-full mt-1 border rounded px-3 py-2"/>
          <div v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</div>
        </div>

        <div class="mb-4">
          <label>Confirm Password</label>
          <input v-model="form.password_confirmation" type="password" class="w-full mt-1 border rounded px-3 py-2"/>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700" :disabled="form.processing">
          Create Admin
        </button>
      </form>
    </div>
  </div>
</template>
