<template>
  <Head title="Dashboard" />

  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
          <div class="flex items-center space-x-4">
            <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
              Online
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Balance Card -->
        <div class="bg-gradient-to-br from-green-400 to-green-600 text-white rounded-2xl p-6 shadow-lg">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium">Current Balance</p>
              <p class="text-3xl font-bold mt-2">{{ balance }} coins</p>
              <p class="text-green-100 text-sm mt-1">≈ {{ (balance / 10).toFixed(2) }} UGX</p>
            </div>
            <div class="bg-white bg-opacity-20 p-3 rounded-full">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Today's Earnings -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Today's Earnings</p>
              <p class="text-3xl font-bold text-blue-600 mt-2">{{ today_earnings }} coins</p>
              <p class="text-gray-500 text-sm mt-1">From ad views</p>
            </div>
            <div class="bg-blue-100 p-3 rounded-full">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Total Earnings -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Earnings</p>
              <p class="text-3xl font-bold text-purple-600 mt-2">{{ total_earnings }} coins</p>
              <p class="text-gray-500 text-sm mt-1">All time</p>
            </div>
            <div class="bg-purple-100 p-3 rounded-full">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Available Ads -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Available Ads</p>
              <p class="text-3xl font-bold text-orange-600 mt-2">{{ available_ads }}</p>
              <p class="text-gray-500 text-sm mt-1">Ready to view</p>
            </div>
            <div class="bg-orange-100 p-3 rounded-full">
              <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Watch Ads Card -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
          <div class="flex items-center space-x-4">
            <div class="bg-blue-100 p-4 rounded-2xl">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900">Watch Ads & Earn</h3>
              <p class="text-gray-600">View ads and earn coins instantly</p>
            </div>
          </div>
          <div class="mt-6">
            <Link href="/ads" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200 flex items-center justify-center">
              <span>Start Earning</span>
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
              </svg>
            </Link>
          </div>
        </div>

        <!-- Withdraw Card -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
          <div class="flex items-center space-x-4">
            <div class="bg-green-100 p-4 rounded-2xl">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900">Withdraw Earnings</h3>
              <p class="text-gray-600">Cash out your coins to mobile money</p>
            </div>
          </div>
          <div class="mt-6">
            <Link href="/withdrawals" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-xl transition duration-200 flex items-center justify-center">
              <span>Withdraw Now</span>
              <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
              </svg>
            </Link>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
          <Link href="/transactions" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            View All
          </Link>
        </div>
        
        <div class="space-y-4">
          <div v-for="activity in recentActivities" :key="activity.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
            <div class="flex items-center space-x-4">
              <div :class="activity.icon_bg" class="p-3 rounded-xl">
                <svg :class="activity.icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="activity.icon_path"></path>
                </svg>
              </div>
              <div>
                <p class="font-medium text-gray-900">{{ activity.title }}</p>
                <p class="text-sm text-gray-500">{{ activity.time }}</p>
              </div>
            </div>
            <div :class="activity.amount_class" class="font-semibold">
              {{ activity.amount }}
            </div>
          </div>
        </div>

        <div v-if="recentActivities.length === 0" class="text-center py-8">
          <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <p class="text-gray-500">No recent activity yet</p>
          <p class="text-gray-400 text-sm">Your transactions will appear here</p>
        </div>

        <div>
    <!-- Your existing dashboard content -->
    
      <AdManagement v-if="activeTab === 'ads'" />
      </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdManagement from '@/Components/AdManagement.vue'; // adjust path

const props = defineProps({
  balance: Number,
  today_earnings: Number,
  total_earnings: Number,
  available_ads: Number,
});

// State
const activeTab = ref('dashboard');

// Dummy recent activities
const recentActivities = [
  {
    id: 1,
    title: 'Ad View Reward',
    time: '2 hours ago',
    amount: '+10 coins',
    amount_class: 'text-green-600',
    icon: 'text-green-600',
    icon_bg: 'bg-green-100',
    icon_path: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
  },
  {
    id: 2,
    title: 'Withdrawal Request',
    time: '5 hours ago',
    amount: '-1000 coins',
    amount_class: 'text-red-600',
    icon: 'text-red-600',
    icon_bg: 'bg-red-100',
    icon_path: 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 0 0118 0z'
  }
];
</script>


<style scoped>
.bg-gradient-to-br {
  background: linear-gradient(135deg, var(--tw-gradient-from), var(--tw-gradient-to));
}

.rounded-2xl {
  border-radius: 1rem;
}
</style>