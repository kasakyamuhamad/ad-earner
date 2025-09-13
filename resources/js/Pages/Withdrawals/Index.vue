<template>
  <Head title="Withdrawal Requests" />

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-600">Pending</h3>
          <p class="text-3xl font-bold text-yellow-600">{{ stats.pending }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-600">Approved</h3>
          <p class="text-3xl font-bold text-green-600">{{ stats.approved }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-600">Rejected</h3>
          <p class="text-3xl font-bold text-red-600">{{ stats.rejected }}</p>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-600">Total</h3>
          <p class="text-3xl font-bold text-blue-600">{{ stats.total }}</p>
        </div>
      </div>

      <!-- Filters -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
        <div class="flex space-x-4">
          <button
            v-for="filter in filters"
            :key="filter.status"
            @click="setFilter(filter.status)"
            :class="{
              'bg-blue-500 text-white': status === filter.status,
              'bg-gray-200 text-gray-700': status !== filter.status
            }"
            class="px-4 py-2 rounded-md"
          >
            {{ filter.label }} ({{ filter.count }})
          </button>
        </div>
      </div>

      <!-- Withdrawals Table -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Network</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="withdrawal in withdrawals.data" :key="withdrawal.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ withdrawal.user.first_name }} {{ withdrawal.user.last_name }}</div>
                  <div class="text-sm text-gray-500">{{ withdrawal.user.phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ withdrawal.amount }} coins</div>
                  <div class="text-sm text-gray-500">≈ {{ (withdrawal.amount / 10).toFixed(2) }} UGX</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ withdrawal.phone }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ withdrawal.network }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatDate(withdrawal.created_at) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="statusClasses(withdrawal.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ withdrawal.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2" v-if="withdrawal.status === 'pending'">
                    <button @click="approveWithdrawal(withdrawal.id)" class="text-green-600 hover:text-green-900">
                      Approve
                    </button>
                    <button @click="openRejectModal(withdrawal)" class="text-red-600 hover:text-red-900">
                      Reject
                    </button>
                  </div>
                  <span v-else class="text-gray-400">Processed</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
          <Pagination :links="withdrawals.links" />
        </div>
      </div>

      <!-- Reject Modal -->
      <div v-if="showRejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
          <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900">Reject Withdrawal</h3>
            <p class="text-sm text-gray-500 mt-2">Amount: {{ selectedWithdrawal?.amount }} coins for {{ selectedWithdrawal?.phone }}</p>
            
            <div class="mt-4">
              <label class="block text-sm font-medium text-gray-700">Reason for rejection</label>
              <input
                v-model="rejectReason"
                type="text"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                placeholder="Enter reason..."
                required
              >
            </div>

            <div class="flex justify-end space-x-3 mt-6">
              <button @click="showRejectModal = false" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
                Cancel
              </button>
              <button @click="rejectWithdrawal" class="px-4 py-2 bg-red-600 text-white rounded-md">
                Confirm Reject
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
  withdrawals: Object,
  status: String,
  stats: Object
});

const showRejectModal = ref(false);
const selectedWithdrawal = ref(null);
const rejectReason = ref('');

const filters = computed(() => [
  { status: 'pending', label: 'Pending', count: props.stats.pending },
  { status: 'approved', label: 'Approved', count: props.stats.approved },
  { status: 'rejected', label: 'Rejected', count: props.stats.rejected },
  { status: '', label: 'All', count: props.stats.total }
]);

const setFilter = (status) => {
  router.get(route('admin.withdrawals.index'), { status });
};

const statusClasses = (status) => {
  return {
    'pending': 'bg-yellow-100 text-yellow-800',
    'approved': 'bg-green-100 text-green-800',
    'rejected': 'bg-red-100 text-red-800'
  }[status];
};

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString();
};

const approveWithdrawal = (id) => {
  if (confirm('Are you sure you want to approve this withdrawal?')) {
    router.post(route('admin.withdrawals.approve', id));
  }
};

const openRejectModal = (withdrawal) => {
  selectedWithdrawal.value = withdrawal;
  showRejectModal.value = true;
};

const rejectWithdrawal = () => {
  if (!rejectReason.value) {
    alert('Please enter a reason for rejection');
    return;
  }

  router.post(route('admin.withdrawals.reject', selectedWithdrawal.value.id), {
    reason: rejectReason.value
  }, {
    onFinish: () => {
      showRejectModal.value = false;
      rejectReason.value = '';
    }
  });
};
</script>