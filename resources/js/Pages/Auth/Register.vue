<template>
  <Head title="Register" />

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
        <!-- First Name -->
        <div>
          <InputLabel for="first_name" value="First Name" />
          <TextInput
            id="first_name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.first_name"
            required
            autofocus
            autocomplete="given-name"
          />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
          <InputLabel for="last_name" value="Last Name" />
          <TextInput
            id="last_name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.last_name"
            required
            autocomplete="family-name"
          />
        </div>

        <!-- Phone -->
        <div class="mt-4">
          <InputLabel for="phone" value="Phone Number" />
          <TextInput
            id="phone"
            type="tel"
            class="mt-1 block w-full"
            v-model="form.phone"
            required
            placeholder="+256XXXXXXXXX"
            autocomplete="tel"
          />
        </div>

        <!-- Email -->
        <div class="mt-4">
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autocomplete="email"
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
            autocomplete="new-password"
          />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
          <InputLabel for="password_confirmation" value="Confirm Password" />
          <TextInput
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            required
            autocomplete="new-password"
          />
        </div>

        <!-- Referral Code (Optional) -->
        <div class="mt-4">
          <InputLabel for="referral_code" value="Referral Code (Optional)" />
          <TextInput
            id="referral_code"
            type="text"
            class="mt-1 block w-full"
            v-model="form.referral_code"
            autocomplete="off"
          />
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-between mt-6">
          <Link
            :href="route('login')"
            class="underline text-sm text-gray-600 hover:text-gray-900"
          >
            Already registered?
          </Link>

          <PrimaryButton
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Register
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
  first_name: '',
  last_name: '',
  phone: '',
  email: '',
  password: '',
  password_confirmation: '',
  referral_code: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>
