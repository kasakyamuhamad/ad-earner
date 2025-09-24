<template>
  <Head title="Login" />

  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <!-- Logo -->
    <div>
      <Link href="/">
        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
      </Link>
    </div>

    <!-- Form Container -->
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
      <ValidationErrors class="mb-4" :errors="form.errors" />

      <form @submit.prevent="submit">
        <!-- Email -->
        <div>
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autofocus
            autocomplete="username"
          />
        </div>

        <!-- Password -->
        <div class="mt-4">
          <InputLabel for="password" value="Password" />
          <TextInput
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="current-password"
          />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
          <label class="flex items-center">
            <input
              type="checkbox"
              v-model="form.remember"
              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            />
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
          </label>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end mt-4">
          <Link
            href="/forgot-password"
            class="underline text-sm text-gray-600 hover:text-gray-900"
          >
            Forgot your password?
          </Link>

          <PrimaryButton
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Log in
          </PrimaryButton>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/login', {
    onFinish: () => form.reset('password'),
  });
};
</script>
