<template>
  <div class="relative">
    <button @click="toggleNotifications" class="p-2 text-gray-400 hover:text-gray-500 relative">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span v-if="unreadCount > 0" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
        {{ unreadCount }}
      </span>
    </button>

    <div v-if="showNotifications" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50">
      <div class="p-4 border-b flex justify-between items-center">
        <h3 class="text-lg font-medium">Notifications</h3>
        <Link :href="route('notifications.index')" class="text-sm text-blue-600 hover:text-blue-800">
          View All
        </Link>
      </div>
      
      <div class="max-h-96 overflow-y-auto">
        <div v-if="notifications.length === 0" class="p-4 text-center text-gray-500">
          No notifications
        </div>
        
        <div v-for="notification in notifications" :key="notification.id" 
             class="p-4 border-b hover:bg-gray-50 cursor-pointer"
             @click="markAsRead(notification)">
          <div class="flex justify-between items-start">
            <div>
              <p class="text-sm font-medium" :class="{ 'text-gray-900': !notification.read_at, 'text-gray-500': notification.read_at }">
                {{ notification.data.message }}
              </p>
              <p class="text-xs text-gray-500 mt-1">{{ formatTime(notification.created_at) }}</p>
            </div>
            <span v-if="!notification.read_at" class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">New</span>
          </div>
        </div>
      </div>
      
      <div class="p-4 border-t flex justify-between">
        <button @click="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800" :disabled="unreadCount === 0">
          Mark all as read
        </button>
        <button @click="clearAll" class="text-sm text-red-600 hover:text-red-800" :disabled="notifications.length === 0">
          Clear all
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const showNotifications = ref(false);
const notifications = ref([]);
const unreadCount = ref(0);

const loadNotifications = async () => {
  try {
    const response = await fetch('/api/notifications');
    const data = await response.json();
    notifications.value = data.notifications;
    unreadCount.value = data.unread_count;
  } catch (error) {
    console.error('Error loading notifications:', error);
  }
};

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value;
  if (showNotifications.value) {
    loadNotifications();
  }
};

const markAsRead = async (notification) => {
  try {
    await fetch(`/api/notifications/${notification.id}/read`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.csrf_token,
      },
    });
    loadNotifications();
  } catch (error) {
    console.error('Error marking notification as read:', error);
  }
};

const markAllAsRead = async () => {
  try {
    await fetch('/api/notifications/read-all', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': window.csrf_token,
      },
    });
    loadNotifications();
  } catch (error) {
    console.error('Error marking all notifications as read:', error);
  }
};

const clearAll = async () => {
  if (confirm('Clear all notifications?')) {
    try {
      await fetch('/api/notifications', {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': window.csrf_token,
        },
      });
      loadNotifications();
    } catch (error) {
      console.error('Error clearing notifications:', error);
    }
  }
};

const formatTime = (dateString) => {
  return new Date(dateString).toLocaleString();
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  const dropdown = event.target.closest('.relative');
  if (!dropdown) {
    showNotifications.value = false;
  }
};

onMounted(() => {
  loadNotifications();
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>