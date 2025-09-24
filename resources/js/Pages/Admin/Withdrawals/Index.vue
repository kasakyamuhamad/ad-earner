<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Withdrawals</h1>

    <table class="min-w-full bg-white border rounded-lg">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-3 border">User</th>
          <th class="p-3 border">Amount</th>
          <th class="p-3 border">Method</th>
          <th class="p-3 border">Status</th>
          <th class="p-3 border">Requested At</th>
          <th class="p-3 border">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="withdrawal in withdrawals.data" :key="withdrawal.id" class="border-b">
          <td class="p-3">{{ withdrawal.user.name }}</td>
          <td class="p-3">{{ withdrawal.amount }} </td>
          <td class="p-3">{{ withdrawal.method }}</td>
          <td class="p-3">
            <span
              :class="{
                'text-yellow-600': withdrawal.status === 'pending',
                'text-green-600': withdrawal.status === 'approved',
                'text-red-600': withdrawal.status === 'rejected',
              }"
            >
              {{ withdrawal.status }}
            </span>
          </td>
          <td class="p-3">{{ new Date(withdrawal.created_at).toLocaleString() }}</td>
          <td class="p-3 flex space-x-2">
            <button
              v-if="withdrawal.status === 'pending'"
              @click="approve(withdrawal.id)"
              class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded"
            >
              Approve
            </button>
            <button
              v-if="withdrawal.status === 'pending'"
              @click="reject(withdrawal.id)"
              class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
            >
              Reject
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center space-x-2">
      <button
        v-if="withdrawals.prev_page_url"
        @click="goToPage(withdrawals.current_page - 1)"
        class="px-3 py-1 bg-gray-200 rounded"
      >
        Previous
      </button>
      <button
        v-if="withdrawals.next_page_url"
        @click="goToPage(withdrawals.current_page + 1)"
        class="px-3 py-1 bg-gray-200 rounded"
      >
        Next
      </button>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
  withdrawals: Object,
});

const approve = (id) => {
  if (confirm('Approve this withdrawal?')) {
    router.post(`/admin/withdrawals/${id}/approve`);
  }
};

const reject = (id) => {
  if (confirm('Reject this withdrawal?')) {
    router.post(`/admin/withdrawals/${id}/reject`);
  }
};

const goToPage = (page) => {
  router.get(`/admin/withdrawals?page=${page}`);
};
</script>
