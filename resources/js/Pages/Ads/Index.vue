<template>
  <div>
    <h1 class="text-xl font-bold mb-4">Available Ads</h1>

    <!-- Error Notification -->
    <div
      v-if="errorMessage"
      class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6"
    >
      <div class="flex justify-between items-center">
        <div>
          <strong>⚠️ Error:</strong> {{ errorMessage }}
        </div>
        <button @click="errorMessage = ''" class="text-red-800 hover:text-red-600">
          ✖
        </button>
      </div>
    </div>

    <!-- Ads Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="ad in ads"
        :key="ad.id"
        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
      >
        <div class="flex justify-between items-start mb-4">
          <h3 class="text-lg font-semibold text-gray-800">{{ ad.title }}</h3>
          <span
            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded"
          >
            {{ ad.reward_amount }} coins
          </span>
        </div>

        <p class="text-gray-600 mb-4">{{ ad.description }}</p>

        <div class="text-sm text-gray-500 mb-4">
          <p>⏱️ Duration: {{ ad.view_duration }} seconds</p>
          <p>🔄 Cooldown: {{ ad.cooldown_minutes }} minutes</p>
        </div>

        <button
          @click="viewAd(ad)"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200"
          :disabled="loading"
          :class="{ 'opacity-50 cursor-not-allowed': loading }"
        >
          <span v-if="loading">⏳ Processing...</span>
          <span v-else>👀 Watch Ad & Earn</span>
        </button>
      </div>
    </div>

    <!-- No Ads Message -->
    <div
      v-if="ads.length === 0"
      class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center"
    >
      <p class="text-gray-600">
        No ads available at the moment. Please check back later.
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Echo from 'laravel-echo';

const props = defineProps({
  ads: Array,
  user_balance: Number,
});

const ads = ref(props.ads || []);
const loading = ref(false);
const showEarning = ref(false);
const earnedAmount = ref(0);
const errorMessage = ref('');
const userBalance = ref(props.user_balance);

onMounted(() => {
  if (props.user_balance !== undefined) {
    window.Echo.channel(`user.${usePage().props.auth.user.id}`)
      .listen('AdViewed', (e) => {
        console.log('Ad viewed event received:', e);
        userBalance.value = e.new_balance;
        earnedAmount.value = e.earned;
        showEarning.value = true;
      });
  }
});

const viewAd = async (ad) => {
  loading.value = true;
  errorMessage.value = '';
  showEarning.value = false;

  try {
    const response = await fetch(`/ads/${ad.id}/view`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': usePage().props.csrf_token,
        'Content-Type': 'application/json',
      },
    });

    const data = await response.json();

    if (data.success) {
      earnedAmount.value = data.earned;
      userBalance.value = data.new_balance;
      showEarning.value = true;
    } else {
      errorMessage.value = data.message;
    }
  } catch (error) {
    errorMessage.value = 'An error occurred. Please try again.';
    console.error('Error viewing ad:', error);
  } finally {
    loading.value = false;
  }
};
</script>
