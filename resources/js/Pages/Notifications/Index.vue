<template>
  <Head title="Notifications" />

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
          <div class="flex space-x-2">
            <button 
              @click="markAllAsRead" 
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md"
              :disabled="unreadCount === 0"
            >
              Mark All as Read
            </button>
            <button 
              @click="clearAll" 
              class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md"
              :disabled="notifications.data.length === 0"
            >
              Clear All
            </button>
          </div>
        </div>
        <p class="text-gray-600 mt-2">You have {{ unreadCount }} unread notifications</p>
      </div>

      <!-- Notifications List -->
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div v-if="notifications.data.length === 0" class="p-8 text-center">
          <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
          </div>
          <p class="text-gray-500 text-lg">No notifications yet</p>
          <p class="text-gray-400">You'll see important updates here</p>
        </div>

        <div v-else class="divide-y divide-gray-200">
          <div v-for="notification in notifications.data" :key="notification.id" 
               class="p-6 hover:bg-gray-50 transition duration-150"
               :class="{ 'bg-blue-50': !notification.read_at }">
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <div class="flex items-center space-x-2 mb-2">
                  <span class="text-sm font-medium" :class="notification.read_at ? 'text-gray-600' : 'text-gray-900'">
                    {{ notification.data.message }}
                  </span>
                  <span v-if="!notification.read_at" class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                    New
                  </span>
                </div>
                <p class="text-sm text-gray-500">{{ formatDate(notification.created_at) }}</p>
                
                <!-- Additional notification data -->
                <div v-if="notification.data.amount" class="mt-2 p-3 bg-gray-100 rounded-md">
                  <p class="text-sm text-gray-700">
                    <span class="font-medium">Amount:</span> {{ notification.data.amount }} coins
                  </p>
                  <p v-if="notification.data.phone" class="text-sm text-gray-700">
                    <span class="font-medium">Phone:</span> {{ notification.data.phone }}
                  </p>
                  <p v-if="notification.data.reason" class="text-sm text-gray-700">
                    <span class="font-medium">Reason:</span> {{ notification.data.reason }}
                  </p>
                </div>
              </div>
              
              <div class="flex space-x-2 ml-4">
                <button 
                  v-if="!notification.read_at"
                  @click="markAsRead(notification.id)"
                  class="text-blue-600 hover:text-blue-800 text-sm"
                  title="Mark as read"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </button>
                <button 
                  @click="deleteNotification(notification.id)"
                  class="text-red-600 hover:text-red-800 text-sm"
                  title="Delete"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="notifications.data.length > 0" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
          <Pagination :links="notifications.links" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
  notifications: Object,
  unreadCount: Number
});

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleString();
};

const markAsRead = async (notificationId) => {
  try {
    await fetch(`/api/notifications/${notificationId}/read`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.csrf_token,
      },
    });
    router.reload();
  } catch (error) {
    console.error('Error marking notification as read:', error);
  }
};

const markAllAsRead = async () => {
  if (!confirm('Mark all notifications as read?')) return;
  
  try {
    await fetch('/api/notifications/read-all', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.csrf_token,
      },
    });
    router.reload();
  } catch (error) {
    console.error('Error marking all as read:', error);
  }
};

const deleteNotification = async (notificationId) => {
  if (!confirm('Delete this notification?')) return;
  
  try {
    await fetch(`/api/notifications/${notificationId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': window.csrf_token,
      },
    });
    router.reload();
  } catch (error) {
    console.error('Error deleting notification:', error);
  }
};

const clearAll = async () => {
  if (!confirm('Clear all notifications? This action cannot be undone.')) return;
  
  try {
    await fetch('/api/notifications', {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': window.csrf_token,
      },
    });
    router.reload();
  } catch (error) {
    console.error('Error clearing notifications:', error);
  }
};
</script>