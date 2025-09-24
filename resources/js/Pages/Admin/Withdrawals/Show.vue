<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Withdrawal Details</h1>

    <div class="bg-white shadow rounded p-6">
      <p><strong>User:</strong> {{ withdrawal.user.name }} ({{ withdrawal.user.email }})</p>
      <p><strong>Amount:</strong> {{ withdrawal.amount }}</p>
      <p><strong>Method:</strong> {{ withdrawal.method }}</p>
      <p><strong>Status:</strong> {{ withdrawal.status }}</p>
      <p><strong>Requested At:</strong> {{ new Date(withdrawal.created_at).toLocaleString() }}</p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  withdrawal: Object,
});
</script>

      
